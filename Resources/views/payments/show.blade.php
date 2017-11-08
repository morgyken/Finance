@extends('layouts.app')
@section('content_title','Deposit Details')
@section('content_description','deposits')

@section('content')
    <div class="box box-info">

        <div class="panel panel-info">
            <div class="panel-heading">
                <span ><b>#{{ $payment->receipt }}</b> | </span>
                <span>{{ $payment->patients->fullName }}</span>

                <span class="pull-right">Patient Balance: <b>kshs. {{ number_format($payment->patients->account->balance) }}</b></span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Cashier <small class="pull-right">{{ $payment->created_at }}</small></h4>
                        <div class="row">
                            <p class="col-md-6">{{ $payment->users->profile->name }}</p>
                            <!-- <div class="col-md-6"> -->
                                <div class="drop-down pull-right">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Print Deposit Slip
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Thermal</a></li>
                                        <li><a href="#">A4</a></li>
                                    </ul>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row"> 
                    @foreach($modes as $mode => $detail)
                        <div class="col-md-6">
                            <h4>{{ ucwords($mode) }} Payment</h4>

                            <p>Amount Paid: <code>kshs. {{ number_format($detail->amount) }}</code></p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{ $total }}
        </div>

    </div>
@stop