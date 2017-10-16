<!-- pharmacy queue -->
@foreach($visit->prescriptions as $item)
    @if(!$item->payment->complete)
        <tr>
            @if(!$item->payment->paid)
                <td><input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}"/></td>
                <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}"/>
                <input type="hidden" value="pharmacy" name="type{{$item->id}}"/>
                <td>
                    {{$item->drugs->name}} <i class="small">(Drug) {{$item->payment->quantity}} units</i>
                    Ksh <span class="topay">{{$item->payment->total}}</span>
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
@endforeach