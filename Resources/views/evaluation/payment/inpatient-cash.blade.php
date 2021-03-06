@foreach($visit->chargeSheet as $item)
    @if($item->ward_id||$item->charge_id)
        <tr>
            @if($item->paid)
                <td>
                    <input type="checkbox" disabled/>
                </td>
                <td>
                    @if($item->paid)
                        <div class="label label-success">Paid</div>
                    @elseif($item->invoiced)
                        <div class="label label-warning">Invoiced</div>
                    @endif
                    {{$item->desc}}
                    <i class="small">({{ $item->ward_id?'Ward':'Inpatient'}}
                        <strong>{{$item->created_at->format('d/m/Y')}}</strong>
                        )</i> - Ksh
                    {{$item->price}}
                </td>
            @else
                <td>
                    <?php try { ?>
                    @if($item->removed_bills->isEmpty)
                        <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}"/>
                    @else
                        <input disabled="" type="checkbox" value="{{$item->id}}" name="item{{$item->id}}"/>
                    @endif
                    <?php } catch (Exception $ex) { ?>
                    <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}"/>
                    <?php } ?>
                    <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}"/>
                    <input type="hidden" value="chargesheet" name="type{{$item->id}}"/>
                <td>
                    {{$item->desc}}
                    <i class="small">({{ $item->ward_id?'Ward':'Inpatient'}}
                        <strong>{{$item->created_at->format('d/m/Y')}}</strong>
                        )</i> - Ksh
                    <span class="topay">{{$item->price}}</span>
                    @endif
                </td>
        </tr>
    @endif
@endforeach