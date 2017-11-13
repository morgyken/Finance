<?php
extract($data);
/** @var \Ignite\Finance\Entities\InsuranceInvoice $invoice */
$visit = $invoice->visits;
?>
@extends('layouts.app')
@section('content_title','Invoice Details')
@section('content_description','View billed items in invoice')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Bill Details <code>Patient: {{$invoice->visits->patients->full_name}}</code> -
                <small>{{$visit->mode}}</small>
            </h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <?php $TOTAL = 0;$PAID = 0;$UNPAID = 0;?>
                <table class="table table-condensed">
                    <tbody>
                    @foreach($invoice->investigations as $item)
                        <?php
                        $is_paid = $item->invoiced;
                        if ($is_paid) {
                            $TOTAL += $item->amount;
                            $PAID += $item->amount;
                        } else {
                            continue;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->procedures->name}}</td>
                            <td>{{ucfirst($item->type)}}</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->price,2)}}</td>
                            <td style="text-align: right">{{$item->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->amount,2)}}</td>
                        </tr>
                    @endforeach

                    @foreach($invoice->prescriptions as $item)
                        <?php
                        $is_paid = $item->is_paid;
                        if ($is_paid) {
                            $TOTAL += $item->payment->total;
                            $PAID += $item->payment->total;
                        } else {
                            if ($only == 'billed') {
                                continue;
                            }
                            $UNPAID += $item->payment->total;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->drugs->name}}</td>
                            <td>Drug</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->payment->price,2)}}</td>
                            <td style="text-align: right">{{$item->payment->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->payment->total,2)}}</td>
                        </tr>

                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="text-align: right">Price</th>
                        <th style="text-align: right">Units</th>
                        <th style="text-align: right">Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">TOTAL:</th>
                        <th style="text-align: right">{{ number_format($TOTAL,2) }}</th>
                    </tr>
                    @if($invoice->copaid)
                        <tr>
                            <th style="text-align: right;" colspan="6" class="grand total">Copay:</th>
                            <th style="text-align: right">{{ number_format($invoice->copaid->amount,2) }}</th>
                        </tr>
                        <?php $PAID -= $invoice->copaid->amount; ?>
                    @endif
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Billed Amount:
                        </th>
                        <th style="text-align: right">{{ number_format($PAID,2) }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <div class="box-footer">
            <div class="pull-left">
                <a class="btn btn-default" href="{{URL::previous()}}"><i class="fa fa-arrow-circle-o-left"></i> Back</a>
            </div>
            <div class="pull-right">
                @if($invoice->prescriptions->count())
                    <a class="btn btn-default"
                       href="{{route('evaluation.print.prescription',[$item->visits->id,true])}}"
                       target="_blank">
                        Print Prescriptions (thermal)</a>
                    <a class="btn btn-primary"
                       href="{{route('evaluation.print.prescription',[$item->visits->id])}}"
                       target="_blank">
                        Print Prescriptions (A5)</a>
                @endif
            </div>
        </div>
    </div>
@endsection