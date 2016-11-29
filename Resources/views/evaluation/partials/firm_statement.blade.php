@extends('finance::evaluation.workbench')
@section('tab')
<?php
extract($data);
$thirty = \Carbon\Carbon::now()->subWeeks(4);
$sixty = \Carbon\Carbon::now()->subWeeks(8);
$ninety = \Carbon\Carbon::now()->subWeeks(12);

$current = 0;
$thirty1_to_60 = 0;
$six1_to_90 = 0;
$ninety_plus = 0;
$AMOUNT = 0
?>
<!-- Row start -->
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Company Statements</h3>
            </div>
            <div class="panel-body">
                @if(!$payments->isEmpty())
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Invoice Number</th>
                            <th>Firm</th>
                            <th>Scheme</th>
                            <th>Beneficiary</th>
                            <th style="text-align: center">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="response">
                        @foreach($payments as $item)
                        <?php $AMOUNT+=$item->amount; ?>
                        @if($item->created_at >= $thirty)
                        <?php $current+=$item->amount; ?>
                        @elseif($item->created_at < $thirty && $item->created_at >= $sixty)
                        <?php $thirty1_to_60+=$item->amount; ?>
                        @elseif($item->created_at < $sixty && $item->created_at >= $ninety)
                        <?php $six1_to_90 += $item->amount; ?>
                        @else
                        <?php $ninety_plus += $item->amount; ?>
                        @endif
                        <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{$item->created_at}}
                            </td>
                            <td>{{$item->invoice->invoice_no}}</td>
                            <td>{{$item->invoice->visits->patient_scheme->schemes->companies->name}}</td>
                            <td>{{$item->invoice->visits->patient_scheme->schemes->name}}</td>
                            <td>{{$item->invoice->visits->patients->full_name}}</td>
                            <td style="text-align: center">{{$item->amount}}
                                <i class="fa fa-sort-asc" style="color: green" aria-hidden="true"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <br>
                <p>No payments received yet</p>
                @endif
            </div>
        </div>




        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Aging Analysis</h3>
            </div>
            <div class="panel-body">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>90+ Days Old</th>
                            <th>61-90 Days Old</th>
                            <th>31-60 Days Old</th>
                            <th>Current</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$ninety_plus}}</td>
                            <td>{{$six1_to_90}}</td>
                            <td>{{$thirty1_to_60}}</td>
                            <td>{{$current}}</td>
                            <td>{{$AMOUNT}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
<!-- Row end -->

@endsection


