@if(!empty($patient_invoices))
<div class="accordion">
    @foreach($patient_invoices as $_invoice)
    <h3>
        Ksh {{$_invoice->total}} Invoice 0{{$_invoice->id}} - {{(new Date($_invoice->created_at))->format('dS M y g:i a')}}
    </h3>
    <div id="visit{{$_invoice->id}}">
        <input type="hidden" name="invoice{{$_invoice->id}}" value="{{$_invoice->id}}">
        <input type="hidden" name="invoice_mode" value="true">
        <table class="table table-condensed table-striped" id="paymentsTable">
            <thead>
                <tr>
                    <th colspan="2">Invoice Details</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                </tr>
            </thead>
            <tbody>
                @include('finance::evaluation.payment.invoice')
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <small><i>Click checkbox to receive payment</i></small>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endforeach
</div>
@endif