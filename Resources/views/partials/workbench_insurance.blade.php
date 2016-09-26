<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$insurances = $data['insurance'];
$billed = $insurances->where('status', 1);
$canceled = $insurances->where('status', 2);
?>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li class="active"><a href="#billed" data-toggle="tab">Billed</a></li>
            <li><a href="#canceled" data-toggle="tab">Canceled</a></li>
            <li><a href="#dispatch" data-toggle="tab">Dispatch</a></li>
            <li><a href="#payment" data-toggle="tab">Insurance Payment</a></li>
            <li><a href="#paid" data-toggle="tab">Paid</a></li>
        </ul>
        <div class="tab-content">
            <div id="billed" class="tab-pane fade in active">
                <br/>
                @if($billed->isEmpty())
                <div class="alert alert-info">
                    <i class="fa fa-info"> No recent billed insurance invoices</i>
                </div>
                @else
                <table class="table table-responsive table-condensed">
                    <tbody>
                        @foreach($billed as $invoice)
                        <tr>
                            <td>{{$invoice->invoice_no}}</td>
                            <td>{{$invoice->payments->patients->full_name}}</td>
                            <td>{{$invoice->payments->schemes->company->name}}</td>
                            <td>{{$invoice->payments->schemes->name}}</td>
                            <td>{{$invoice->payments->InsuranceAmount}}</td>
                            <td>{{(new Date($invoice->created_at))->format('d/m/Y')}}</td>
                            <td><a href="{{route('system.print.invoice',$invoice->invoice_no)}}"
                                   target="_blank"><i class="fa fa-print"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Patient</th>
                            <th>Insurance</th>
                            <th>Scheme</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @endif
            </div>
            <div id="canceled" class="tab-pane fade">
                <br/>
                @if($canceled->isEmpty())
                <div class="alert alert-info">
                    <i class="fa fa-info"> No recently canceled insurance invoices</i>
                </div>
                @else
                <table class="table table-responsive table-condensed">
                    <tbody>
                        @foreach($canceled as $invoice)
                        <tr>
                            <td>{{$invoice->invoice_no}}</td>
                            <td>{{$invoice->payments->patients->full_name}}</td>
                            <td>{{$invoice->payments->schemes->company->name}}</td>
                            <td>{{$invoice->payments->schemes->name}}</td>
                            <td>{{$invoice->payments->InsuranceAmount}}</td>
                            <td>{{(new Date($invoice->created_at))->format('d/m/Y')}}</td>
                            <td><a href="{{route('system.print.invoice',$invoice->invoice_no)}}"
                                   target="_blank"><i class="fa fa-print"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Patient</th>
                            <th>Insurance</th>
                            <th>Scheme</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @endif
            </div>
            <div id="dispatch" class="tab-pane fade">
                <h3>Menu 2</h3>
                <p>Some content in menu 2.</p>
            </div>
            <div id="payment" class="tab-pane fade">
                <h3>Menu 1</h3>
                <p>Some content in menu 1.</p>
            </div>
            <div id="paid" class="tab-pane fade">
                <h3>Menu 2</h3>
                <p>Some content in menu 2.</p>
            </div>
        </div>
    </div>
</div>
