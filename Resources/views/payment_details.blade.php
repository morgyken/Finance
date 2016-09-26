<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$payment = $data['payment'];
$patient = Dervis\Model\Reception\Patients::find($payment->patient);
$pays = \Dervis\Helpers\FinancialFunctions::paymentFor($payment->description);
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
            Name: <strong>{{$patient->full_name}}</strong>
        </div>
        <div class="col-md-6">
            @if(!$pays->isEmpty())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Procedure</th>
                        <th>Cost (Ksh.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pays as $pay)
                    <tr>
                        <td>{{$pay->procedures->name}} <i class="small">({{$pay->type}})</i></td>
                        <td>{{$pay->price}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th></th>
                        <th>{{$pays->sum('net')}}</th>
                    </tr>
                </tfoot>
            </table>
            @else
            <br/>
            <p class="text-warning">No treatment found</p>
            @endif
        </div>
        <div class="col-md-6">
            {!! Form::open(['route'=>'reports.print_receipt','target'=>'_blank'])!!}
            @if(!empty($payment->InsuranceAmount))
            <h4>Insurance</h4>
            Amount: Ksh {{$payment->InsuranceAmount}}
            <hr/>
            @endif
            @if(!empty($payment->CashAmount))
            <h4>Cash Payment</h4>
            Amount: Ksh {{$payment->CashAmount}}
            <hr/>
            @endif

            @if(!empty($payment->MpesaAmount))
            <h4>Mpesa Payment</h4>
            MPESA Ref: {{$payment->MpesaReference}}<br/>
            Amount: Ksh {{$payment->MpesaAmount}}
            <hr/>
            @endif
            @if(!empty($payment->ChequeAmount))
            <h4>Cheque Payment</h4>
            Amount: Ksh {{$payment->ChequeAmount}}
            <hr/>
            @endif
            @if(!empty($payment->CardAmount))
            <h4>Card Payment</h4>
            Amount: Ksh {{$payment->CardAmount}}
            <hr/>
            @endif
            <strong>Total:    Ksh {{$payment->total}}</strong><hr/>
            <input type="hidden" name="payment" value="{{$payment->payment_id}}"/>
            <button class="btn btn-primary" type="submit"><i class="fa fa-file-pdf-o"></i> Print Receipt</button>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection