<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Receive Payment')
@section('content_description','Receive payment from patient')

@section('content')
    
{!! Form::open(['id'=>'payment-details-form', 'url'=>"finance/patient/$patient->id/account/deposit", 'autocomplete'=>'off', 'files' => true])!!}
    <input id="patient-detail" name="patient" type="hidden" value="{{$patient->id}}" />
    <div class="box box-info">
        <div class="box-body">
            <div class="col-md-6">
                <h2>Deposit Funds</h2>
                Patient Name: <strong>{{$patient->full_name}}</strong>
                <hr/>
                <input type="hidden" name="deposit" value="1">
            </div>
            <div class="col-md-6">
                <div class="accordion" id="someForm">
                    <h4>Cash</h4>
                    <div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Cash Amount</label>
                            <div class="col-md-8">
                                {!! Form::text('cash[amount]', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Mpesa</h4>
                    <div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Mpesa Code</label>
                            <div class="col-md-8">
                                {!! Form::text('mpesa[reference]', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Amount</label>
                            <div class="col-md-8">
                                {!! Form::text('mpesa[amount]', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Cheque</h4>
                    <div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name:</label>
                                <div class="col-md-8">
                                    {!! Form::text('cheque[name]', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Amount:</label>
                                <div class="col-md-8">
                                    {!! Form::text('cheque[amount]', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Bank:</label>
                                <div class="col-md-8">
                                    {!! Form::text('cheque[bank]', null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Cheque Number:</label>
                                <div class="col-md-8">
                                    {!! Form::text('cheque[number]', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4>Credit Card</h4>
                    <div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Card Type:</label>
                                <div class="col-md-8">
                                    {!! Form::select('CardType',mconfig('evaluation.options.card_types'),null,['class'=>'form-control','placeholder'=>'Select...']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name:</label>
                                <div class="col-md-8">
                                    {!! Form::text('card[name]', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Card No:</label>
                                <div class="col-md-8">
                                    {!! Form::text('card[number]', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Expiry:</label>
                                <div class="col-md-8">
                                    {!! Form::text('card[expiry]', null, ['placeholder'=>'eg. 04/22','class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Amount:</label>
                                <div class="col-md-8">
                                    {!! Form::text('card[amount]', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr/>
                        <div class="pull-left">
                            <span id="all"></span><br/>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success" type="submit"><i
                                        class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>    
{!! Form::close()!!}

    <script src="{{m_asset('finance:js/payments.js')}}"></script>
    <style type="text/css">
        #visits tbody tr.highlight {
            background-color: #B0BED9;
        }
    </style>
@endsection