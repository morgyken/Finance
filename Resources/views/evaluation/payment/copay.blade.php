<!-- pharmacy queue -->
@if($visit->copay)
    <tr>
        @if(!$visit->copay->payment_id)
            <td><input type="checkbox" value="{{$visit->copay->id}}" name="item{{$visit->copay->id}}"/></td>
            <input type="hidden" value="{{$visit->id}}" name="visits{{$visit->copay->id}}"/>
            <input type="hidden" value="copay" name="type{{$visit->copay->id}}"/>
            <td>
                {{$visit->copay->desc}}
                Ksh <span class="topay">{{$visit->copay->amount}}</span>
            </td>
        @else
            <td><input type="checkbox" disabled/></td>
            <td>
                <div class="label label-success">Paid</div>
                {{$item->drugs->name}} <i class="small">(Drug) {{$item->payment->quantity}} units</i>
                Ksh {{$item->payment->total}}
            </td>
        @endif
    </tr>
@endif