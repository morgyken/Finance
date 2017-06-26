<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice No.</th>
            <th>Invoice Date</th>
            <th>Amount (Ksh.)</th>
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
            <td>{{$d->patient_invoices->total}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Invoice Amount Paid</td>
            <td>{{get_patient_invoice_paid_amount($d->patient_invoices->id)}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Balance</td>
            <td>{{get_patient_invoice_pending_amount($d->patient_invoices->id)}}.00</td>
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
