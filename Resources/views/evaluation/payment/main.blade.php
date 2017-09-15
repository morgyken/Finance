@foreach($visit->investigations as $item)
<tr>
    @if($item->is_paid  || $item->invoiced)
    <td>
        <input type="checkbox" disabled/>
    </td>
    <td>
        @if($item->is_paid)
        <div class="label label-success">Paid</div>
        @elseif($item->invoiced)
        <div class="label label-warning">Invoiced</div>
        @endif
        {{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i> -
        Ksh {{$item->amount>0?$item->amount:$item->price}}
    </td>
    @else
    <td>
        <?php try { ?>
            @if($item->removed_bills->isEmpty)
            <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
            @else
            <input disabled="" type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
            @endif
        <?php } catch (Exception $ex) { ?>
            <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
        <?php } ?>
        <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}" />
    <td>
        {{$item->procedures->name}}
        <i class="small">({{ucwords($item->type)}})</i> - Ksh <span class="topay">{{$item->amount>0?$item->amount:$item->price}}</span>
        @endif
    </td>
</tr>
@endforeach