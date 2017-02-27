
<table class="table table-condensed" id="paymentsTable">
    <tbody><!-- From pos -->
        <tr>
    <input type="hidden" name="sale" value="{{$sales->id}}">
    @if($sales->paid===1)
    <td>
        <input type="checkbox" disabled=""/>
    </td>
    <td>
        Drugs <i class="small">(point of sale)</i>
        <div class="label label-success">Paid</div>
        Ksh <span class="topay">{{$sales->amount}}.00/=</span>
    </td>
    <ul>
        @foreach($sales->goodies as $g)
        <li>
            {{$g->products->name}} x {{$g->quantity}},
            {{$g->discount}}%discount --
            {{$g->quantity*$g->price-($g->discount/100*$g->quantity*$g->price)}}.00/=
        </li>
        @endforeach
    </ul>
    @else
    <input type="hidden" name="batch[]" value="{{$sales->id}}">
    <td><input type="checkbox" value="{{$sales->id}}"
               name="item{{$sales->id}}" />
    </td>
    <td>Drugs <i class="small">(point of sale)</i>
        Ksh <span class="topay">{{$sales->amount}}.00/=</span>
    </td>
    <ul>
        @foreach($sales->goodies as $g)
        <li>
            {{$g->products->name}} x {{$g->quantity}},
            {{$g->discount}}%discount --
            {{$g->quantity*$g->price-($g->discount/100*$g->quantity*$g->price)}}.00/=
        </li>
        @endforeach
    </ul>
    @endif
</tr>
</tbody>
</table>