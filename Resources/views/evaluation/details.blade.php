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
@section('content_description','Payment from patients')


@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Payment Details</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-6">
                <dl class="dl-horizontal">
                    <dt>Name:</dt><dd>{{$payment->patients->full_name}}</dd>
                    <dt>Receipt:</dt><dd>#{{$payment->receipt}}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="dl-horizontal">
                    <dt>Cashier:</dt><dd>{{$payment->users->profile->full_name}}</dd>
                    <dt>Date:</dt><dd>{{smart_date_time($payment->created_at)}}</dd>
                </dl>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Procedure</th>
                        <th>Cost (Ksh.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment->details as $pay)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$pay->investigations->procedures->name}} <i
                                class="small">({{$pay->investigations->type}})</i></td>
                        <td>{{$pay->price}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Total</th>
                        <th>{{$payment->details->sum('price')}}</th>
                    </tr>
                </tfoot>
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
            <strong>Total: Ksh {{$payment->total}}</strong>
            <hr/>


        </div>
    </div>
    <div class="box-footer">
        {!! Form::open(['route'=>'evaluation.report.pay_receipt','target'=>'_blank'])!!}
        {!! Form::hidden('payment',$payment->id) !!}
        <button class="btn btn-primary" type="submit"><i class="fa fa-file-pdf-o"></i> Print Receipt</button>
        {{Form::close()}}
    </div>
</div>
@endsection
