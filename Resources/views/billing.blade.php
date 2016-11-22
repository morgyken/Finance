<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo (bkiptoo@gmail.com)
 *
 * =============================================================================
 */
$count = 0;
?>
@extends('layouts.app')
@section('content_title','Billing')
@section('content_description','View and dispatch insurance bills')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Bills</h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['insurance_invoices']->isEmpty())
                {!! Form::open(['class'=>'form-horizontal', 'route'=>'finance.billing.dispatch']) !!}
                <table class="table table-responsive table-striped" id="bills">
                    <tbody>
                        <?php $t = $n = 0; ?>
                        @foreach($data['insurance_invoices'] as $bill)
                        <?php $amount = 0; ?>
                        <?php if (isset($bill->sales->goodies)) { ?>
                            @foreach($bill->sales->goodies as $sale)
                            <?php
                            $amount+=($sale->price * $sale->quantity);
                            ?>
                            @endforeach
                            <?php
                            $t +=$amount;
                        } else {
                            $amount += $bill->payment;
                        }
                        ?>
                        <tr>
                            <td>{{$n+=1}}</td>
                            <td>
                                <input onclick="updateAmount({{$amount}}, {{$bill->id}})" id="check{{$bill->id}}" type="checkbox" name="bill[]" value="{{$bill->id}}" @if($bill->status !==0) disabled="disabled" @endif >
                            </td>
                            <td>{{$bill->invoice_no}}</td>
                            <td>
                                {{@$bill->sales->insuranceses->clients->first_name}}
                                {{@$bill->sales->insuranceses->clients->last_name}}
                            </td>
                            <td>{{$bill->invoice_date}}</td>
                            <td>
                                {{number_format($amount,2)}}
                                <input type="hidden" name="amount[]" value="{{$amount}}">
                            </td>
                            <td>
                                @if($bill->status ==0)
                                <span  class="btn-default btn-xs"><small><i class="fa fa-cog fa-spin"></i>billed</small></span>
                                @elseif($bill->status ==1)
                                <span  class="btn-info btn-xs"><small>dispatched</small></span>
                                @elseif($bill->status ==2)
                                <span  class="btn-info btn-xs">
                                    <small><i style="color:green" class="fa fa-check"></i>paid</small>
                                </span>
                                @elseif($bill->status ==3)
                                <span  class="btn-default btn-xs"><small><i style="color:red" class="fa fa-trash"></i>cancelled</small></span>
                                @endif
                            </td>
                            <td>
                                {{@$bill->sales->insuranceses->companies->name}}:
                                {{@$bill->sales->insuranceses->schemes->name}}
                            </td>
                            <td>
                                <a target="blank" href="{{route('finance.bill.print', $bill->id)}}"> <i class="fa fa-print"></i></a>
                                @if($bill->status ==3)
                                @else
                                <a href="{{route('finance.bill.cancel', $bill->id)}}">
                                    <i id="cancel" style="color:red" class="fa fa-times"></i>
                                </a>
                                @endif

                                @if($bill->status ==1)
                                <a href="{{route('finance.bill.pay', $bill->id)}}">
                                    <i class="fa fa-money"></i>
                                    receive payment?
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Invoice Number</th>
                            <th>Client</th>
                            <th>Date of Invoice</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Insurance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="3"><input type="submit" class="btn-primary" value="Dispatch Selected Invoices"></td>
                            <td colspan="2">Dispatched Total: <input id="dis_tot" disabled="disabled" size="7" value="0.00"></td>
                            <td colspan="2"><!-- Balance: <input id="bal" disabled="disabled" size="7" value=""> --></td>
                            <td style="text-align: right">Total Bill:</td>
                            <td>
                                <input id="sum" disabled="disabled" size="10" value="{{number_format($t,2)}}">
                            </td>
                        </tr>
                    </tfoot>
                </table>
                {!! Form::close() !!}
                @else
                <div class="alert alert-info">
                    <p>No bills have been made yet</p>
                </div>
                @endif

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
        try {
        $('#bills').dataTable();
        } catch (e) {
        }
        });
        function updateAmount(amount, i) {
        $amount = $('#dis_tot');
        $bal = $('#bal');
        $sum = $('#sum');
        if ($('#check' + i).is(':checked')) {
        $amount.val(parseInt($amount.val(), 10) + amount);
        $bal.val($sum.val());
        } else {
        $amount.val(parseInt($amount.val(), 10) - amount);
        }
        }
    </script>
    @endsection