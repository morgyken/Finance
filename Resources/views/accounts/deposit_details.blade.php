<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);

?>
@extends('layouts.app')
@section('content_title','Payment Details')
@section('content_description','Deposit')


@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Payment Details: Deposit</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt>Name:</dt>
                        <dd>{{$payment->patients->full_name}}</dd>
                        <dt>Receipt:</dt>
                        <dd>#{{$payment->receipt}}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt>Cashier:</dt>
                        <dd>{{$payment->users->profile->full_name}}</dd>
                        <dt>Date:</dt>
                        <dd>{{smart_date_time($payment->created_at)}}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-striped">
                    <tr>
                        <td></td>
                        <td style="text-align: right">Amount Paid</td>
                        <th>
                            {{$payment->total}}
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: right">Total Account Balance</td>
                        <th>
                            {{number_format($payment->patients->account->balance,2)}}
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                @if(!empty($payment->cash))
                    <h4>Cash Payment</h4>
                    Amount: Ksh {{$payment->cash->amount}}
                    <hr/>
                @endif

                @if(!empty($payment->mpesa))
                    <h4>Mpesa Payment</h4>
                    MPESA Ref: {{$payment->mpesa->reference}}<br/>
                    Amount: Ksh {{$payment->mpesa->amount}}
                    <hr/>
                @endif
                @if(!empty($payment->cheque))
                    <h4>Cheque Payment</h4>
                    Amount: Ksh {{$payment->cheque->amount}}
                    <hr/>
                @endif
                @if(!empty($payment->card))
                    <h4>Card Payment</h4>
                    Amount: Ksh {{$payment->card->amount}}
                    <hr/>
                @endif
                <strong>Total Amount Paid: Ksh {{number_format($payment->total,2)}}</strong>
                <hr/>
            </div>
        </div>
        <div class="box-footer">
            <div class="col-md-4 col-lg-4 col-sm-12">
                {!! Form::open(['route'=>'finance.evaluation.normal.rcpt.print','target'=>'_blank'])!!}
                {!! Form::hidden('payment',$payment->id) !!}
                <button class="btn btn-primary btn-sm" type="submit">
                    <i class="fa fa-print"></i> Print Receipt (Thermal Printer)
                </button>
                {{Form::close()}}
            </div>

            <div class="col-md-4 col-lg-4 col-sm-12">
                {!! Form::open(['route'=>'finance.evaluation.a4.rcpt.print','target'=>'_blank'])!!}
                {!! Form::hidden('payment',$payment->id) !!}
                <button class="btn btn-primary btn-sm" type="submit">
                    <i class="fa fa-print"></i> Print Receipt (A4)
                </button>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
