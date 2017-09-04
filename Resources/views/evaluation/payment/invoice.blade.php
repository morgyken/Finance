@foreach($_invoice->details as $item)
<tr>
    <td>
        {{$loop->iteration}}.
    <td>
        {{$item->item_name}}
        <i class="small"> ({{ucwords($item->item_type)}})</i>
        <span style="text-align: right; font-weight: bold">Ksh {{$item->amount}}</span>
    </td>
</tr>
@endforeach
<tr>
    <td style='text-align: right; font-weight: bold'>Amount</td>
    <td style='text-align: right; font-weight: bold'>{{$_invoice->total}}.00</td>
</tr>

<tr>
    <td style='text-align: right; font-weight: bold'>Total Paid</td>
    <td style='text-align: right; font-weight: bold'>{{get_patient_invoice_paid_amount($_invoice->id)}}</td>
</tr>

<tr>
    @if($_invoice->status == 'paid')
    <td>
        <input type="checkbox" disabled/>
    </td>
    <td>
        <div class="label label-success">{{$_invoice->status}}</div> Ksh {{$_invoice->total}}
    </td>
    @else
    <th>
        <input type="checkbox" value="{{$_invoice->id}}" name="item{{$_invoice->id}}" />
    </th>
    <th style='text-align: right'>Balance
        <i class="small"></i><span class="topay">{{get_patient_invoice_pending_amount($_invoice->id)}}</span>
    </th>
    @endif
</tr>