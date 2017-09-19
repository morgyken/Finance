@foreach(\Ignite\Inpatient\Entities\WardAssigned::where('visit_id', $visit->id)->get() as $wardAssigned)
    <tr>
        @if($wardAssigned->status == "paid" || $wardAssigned->invoiced == 1)
        <td>
            <input type="checkbox" disabled/>
        </td>
        <td>
            @if($wardAssigned->status == "paid")
            <div class="label label-success">Paid</div>
            @elseif($wardAssigned->invoiced == 1)
            <div class="label label-warning">Invoiced</div>
            @endif
             {{ $wardAssigned->ward->name }} - Ksh {{ $wardAssigned->ward->cost  }}
        </td>
        @else
        <td>
            <?php try { ?>
                @if($item->removed_bills->isEmpty)
                    <input type="checkbox" value="{{$wardAssigned->ward_id}}" name="item{{$wardAssigned->ward_id}}" />
                @else
                    <input disabled type="checkbox" value="{{$wardAssigned->ward_id}}" name="item{{$wardAssigned->ward_id}}" />
                @endif
            <?php } catch (Exception $ex) { ?>
                <input type="checkbox" value="{{$wardAssigned->ward_id}}" name="item{{$wardAssigned->ward_id}}" />
            <?php } ?>
            <input type="hidden" value="{{$visit->id}}" name="visits{{$wardAssigned->ward_id}}" />
        <td>
            {{ $wardAssigned->ward->name }} Ward Charge<i class="small"> - Ksh <span class="topay">{{ $wardAssigned->ward->cost * (($wardAssigned->discharged_at != null) ? \Carbon\Carbon::parse($wardAssigned->discharged_at)->diffInDays($wardAssigned->created_at) : (\Carbon\Carbon::now()->diffInDays($wardAssigned->created_at) > 0) ? Carbon\Carbon::now()->diffInDays($wardAssigned->created_at) : 1) }} ({{ (($wardAssigned->discharged_at != null) ? \Carbon\Carbon::parse($wardAssigned->discharged_at)->diffInDays($wardAssigned->created_at) : (\Carbon\Carbon::now()->diffInDays($wardAssigned->created_at) > 0) ? Carbon\Carbon::now()->diffInDays($wardAssigned->created_at) : 1) }} days @ Ksh.{{ $wardAssigned->ward->cost }} per day)</span>
        </td>
        @endif
    </tr>
    @foreach(\Ignite\Evaluation\Entities\RecurrentCharge::where('visit_id', $visit->id)->get() as $item)
    <tr>
        @if($item->status == "paid" || $item->invoiced == 1)
        <td>
            <input type="checkbox" disabled/>
        </td>
        <td>
            @if($item->status == "paid")
            <div class="label label-success">Paid</div>
            @elseif($item->invoiced == 1)
            <div class="label label-warning">Invoiced</div>
            @endif
             {{ $item->charge->name }} - Ksh {{ $item->charge->cost  }}
        </td>
        @else
        <td>
            <?php try { ?>
                @if($item->removed_bills->isEmpty)
                    <input type="checkbox" value="{{$item->charge->id}}" name="item{{$item->charge->id}}" />
                @else
                    <input disabled type="checkbox" value="{{$item->charge->id}}" name="item{{$item->charge->id}}" />
                @endif
            <?php } catch (Exception $ex) { ?>
                <input type="checkbox" value="{{$item->charge->id}}" name="item{{$item->charge->id}}" />
            <?php } ?>
            <input type="hidden" value="{{$visit->id}}" name="visits{{$item->charge->id}}" />
        <td>
            {{ $item->charge->name }} (Ward {{ $wardAssigned->ward->name }}) <i class="small"> - Ksh <span class="topay">{{ $item->charge->cost * ($wardAssigned->discharged_at != null) ? $item->charge->cost * \Carbon\Carbon::parse($wardAssigned->discharged_at)->diffInDays($wardAssigned->created_at) : $item->charge->cost }}</span>
        </td>
        @endif
    </tr>
    @endforeach
@endforeach