<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th style="text-align: right">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $n = 0; ?>
        @if(isset($payment->details))
        @foreach($payment->details as $d)
        <!--Display Invoice Details-->
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>0{{$d->patient_invoices->id}}</td>
            <td>{{$d->patient_invoices->created_at}}</td>
            <td style="text-align: right">{{number_format($d->patient_invoices->total,2)}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: bolder; text-align: right">Amount Paid</td>
            <td style="text-align: right">{{number_format(get_patient_invoice_paid_amount($d->patient_invoices->id),2)}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            @if(get_patient_invoice_pending_amount($d->patient_invoices->id)>0)
                <td style="font-weight: bolder;text-align: right">Amount Pending</td>
                <td style="text-align: right">{{number_format(get_patient_invoice_pending_amount($d->patient_invoices->id),2)}}</td>
            @else
                <td style="font-weight: bolder; text-align: right">Change</td>
                <td style="text-align: right">{{number_format(-1*(get_patient_invoice_pending_amount($d->patient_invoices->id)),2)}}</td>
            @endif
        </tr>
        @endforeach
        @endif
    </tbody>
    <!--
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th>Total</th>
            <th>
                {{$payment->total}}
            </th>
        </tr>
    </tfoot>
    -->
</table>
