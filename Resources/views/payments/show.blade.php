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
                        <!-- <h4>Cashier </h4> -->
                        <div class="row">
                            <p class="col-md-12">Cashier: {{ $payment->users->profile->name }}
                                <small class="pull-right">{{ $payment->created_at }}</small>
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row"> 
                    @if($modes->count() > 0)
                        @foreach($modes as $mode => $detail)
                            <div class="col-md-6">
                                <h4>{{ ucwords($mode) }} Payment</h4>

                                <p>Amount Paid: <code>kshs. {{ number_format($detail->amount) }}</code></p>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="jumbotron col-md-12">
                                <h4 class="text-center">Sorry! No deposits were made</h4> 
                            </div>
                        </div>
                    @endif    
                </div>

                <hr>

                @if($modes->count() > 0)
                    <div class="row"> 
                        <div class="col-md-5">
                            <h4><b>DEPOSIT TOTAL kshs. {{ $total }}</b></h4>
                        </div>
                        <div class="col-md-7">
                            <button class="col-md-2 col-md-offset-1 btn btn-sm btn-primary">Print Thermal</button>
                            <button class="col-md-2 col-md-offset-1 btn btn-sm btn-primary">Print A4</button>
                        </div>
                    </div>
                    <hr>
                @endif

                @if(is_module_enabled('Inpatient'))
                <div class="row"> 
                    <div class="col-md-12">
                        <a target="_blank" href="{{ url('/inpatient/admission-letter/create/'. $payment->patients->id) }}" class="col-md-2 btn btn-sm btn-success">
                            Print Admission Letter
                        </a>
                    </div>
                </div>
                @endif

            </div>

            
        </div>

    </div>
@stop