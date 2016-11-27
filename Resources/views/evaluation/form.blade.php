<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<strong>Payment Options</strong>
<hr/>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Uh Oh!</strong> Check the following<br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(isset($patient))
{!! Form::hidden('patient',$patient->id) !!}
@else
{!! Form::hidden('patient',$visit->patients->id) !!}
@endif
<div class="accordion form-horizontal" id="someForm">
    <h4>Cash</h4>
    <div>
        <div class="form-group">
            <label class="col-md-4 control-label">Cash Amount</label>
            <div class="col-md-8">
                {!! Form::text('CashAmount',old('CashAmount'),['class'=>'form-control','placeholder'=>'Cash Amount']) !!}
            </div>
        </div>
    </div>
    <h4>Mpesa</h4>
    <div>
        <div class="form-group">
            <label class="col-md-4 control-label">Mpesa Code</label>
            <div class="col-md-8">
                {!! Form::text('MpesaCode',old('MpesaCode'),['class'=>'form-control','placeholder'=>'Transaction Number']) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Amount</label>
            <div class="col-md-8">
                {!! Form::text('MpesaAmount',old('MpesaAmount'),['class'=>'form-control','placeholder'=>'Mpesa Amount']) !!}
            </div>
        </div>
    </div>
    <h4>Cheque</h4>
    <div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">Name:</label>
                <div class="col-md-8">
                    {!! Form::text('ChequeName',old('ChequeName'),['class'=>'form-control','placeholder'=>'Ac Holder Name']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Date:</label>
                <div class="col-md-8">
                    {!! Form::text('ChequeDate',old('ChequeDate'),['class'=>'form-control datepicker','placeholder'=>'Date on Cheque']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Amount:</label>
                <div class="col-md-8">
                    {!! Form::text('ChequeAmount',old('ChequeAmount'),['class'=>'form-control','placeholder'=>'Amount']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">Bank:</label>
                <div class="col-md-8">
                    {!! Form::text('ChequeBank',old('ChequeBank'),['class'=>'form-control','placeholder'=>'Bank']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Branch:</label>
                <div class="col-md-8">
                    {!! Form::text('ChequeBankBranch',old('ChequeBankBranch'),['class'=>'form-control','placeholder'=>'Branch']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Cheque Number:</label>
                <div class="col-md-8">
                    {!! Form::text('ChequeNumber',old('ChequeNumber'),['class'=>'form-control','placeholder'=>'Cheque Number']) !!}
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
                    {!! Form::text('CardNames',old('CardNames'),['placeholder'=>'Name on Card','class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Card No:</label>
                <div class="col-md-8">
                    {!! Form::text('CardNumber',old('CardNumber'),['class'=>'form-control','placeholder'=>'16 digit card number']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-4 control-label">Expiry:</label>
                <div class="col-md-8">
                    {!! Form::text('CardExpiry',old('expiry'),['placeholder'=>'eg. 04/22','class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Amount:</label>
                <div class="col-md-8">
                    {!! Form::text('CardAmount',old('CardAmount'),['placeholder'=>'Card Amount','class'=>'form-control']) !!}
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
            <span id="balance"></span>
        </div>
        <div class="pull-right">
            <button class="btn btn-success" type="submit" id="saver"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
</div>