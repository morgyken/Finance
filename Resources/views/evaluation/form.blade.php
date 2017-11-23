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
<?php $___p = null ?>
@if(isset($patient))
    <?php $___p = $patient->id ?>
    {!! Form::hidden('patient',$patient->id) !!}
@elseif(isset($visit))
    <?php $___p = $$visit->patients->id ?>
    {!! Form::hidden('patient',$visit->patients->id) !!}
@elseif(isset($sales))
    <?php $___p = $sales->patient ?>
    <input type="hidden" name="patient" value="{{$sales->patient}}">
@endif
<!--
@if(get_patient_balance($___p)>0)
    <?php $prepaid = get_patient_balance($___p) ?>
            <h3>
                <i class="fa fa-info-circle"></i> Patient has
{{number_format(get_patient_balance($___p),2)}}
            in their account.
        </h3>
@endif
        -->
<div class="accordion form-horizontal" id="someForm">
    @if(m_setting('finance.enable_jambo_pay'))
        @include('finance::partials.jambo_pay')
    @else
        <h4>Cash</h4>
        <div>
            <div class="form-group">
                <label class="col-md-4 control-label">Cash Amount</label>
                <div class="col-md-8">
                    @if(isset($visit))
                        <input type="hidden" name="visit" value="{{$visit->id}}">
                    @endif
                    {!! Form::text('cash[amount]',old('cash[amount]'), ['class'=>'form-control','placeholder'=>'Cash Amount']) !!}
                </div>
            </div>
        </div>
        <h4>Mpesa</h4>
        <div>
            <div class="form-group">
                <label class="col-md-4 control-label">Mpesa Code</label>
                <div class="col-md-8">
                    {!! Form::text('mpesa[reference]',old('mpesa[reference]'),['class'=>'form-control','placeholder'=>'Transaction Number']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Amount</label>
                <div class="col-md-8">
                    {!! Form::text('mpesa[amount]',old('mpesa[amount]'),['class'=>'form-control','placeholder'=>'Mpesa Amount']) !!}
                </div>
            </div>
        </div>
        <h4>Cheque</h4>
        <div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">Name:</label>
                    <div class="col-md-8">
                        {!! Form::text('cheque[name]',old('cheque[name]'),['class'=>'form-control','placeholder'=>'Ac Holder Name']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Date:</label>
                    <div class="col-md-8">
                        {!! Form::text('cheque[date]',old('cheque[date]'),['class'=>'form-control datepicker','placeholder'=>'Date on Cheque']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Amount:</label>
                    <div class="col-md-8">
                        {!! Form::text('cheque[amount]',old('cheque[amount]'),['class'=>'form-control','placeholder'=>'Amount']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">Bank:</label>
                    <div class="col-md-8">
                        {!! Form::text('cheque[bank]',old('cheque[bank]'),['class'=>'form-control','placeholder'=>'Bank']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Branch:</label>
                    <div class="col-md-8">
                        {!! Form::text('cheque[bank_branch]',old('cheque[bank_branch]'),['class'=>'form-control','placeholder'=>'Branch']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Cheque Number:</label>
                    <div class="col-md-8">
                        {!! Form::text('cheque[number]',old('cheque[number]'),['class'=>'form-control','placeholder'=>'Cheque Number']) !!}
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
                        {!! Form::select('card[type]',mconfig('evaluation.options.card_types'),null,['class'=>'form-control','placeholder'=>'Select...']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Name:</label>
                    <div class="col-md-8">
                        {!! Form::text('card[name]',old('card[name]'),['placeholder'=>'Name on Card','class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Card No:</label>
                    <div class="col-md-8">
                        {!! Form::text('card[number]',old('card[number]'),['class'=>'form-control','placeholder'=>'16 digit card number']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">Expiry:</label>
                    <div class="col-md-8">
                        {!! Form::text('card[expiry]',old('card[expiry]'),['placeholder'=>'eg. 04/22','class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Amount:</label>
                    <div class="col-md-8">
                        {!! Form::text('card[amount]',old('card[amount]'),['placeholder'=>'Card Amount','class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="row">
    <div class="col-md-12">
        <hr/>
        <div class="pull-left">
            <!-- <span id="all"></span><br/> -->
            <span id="balance"></span>
        </div>
        <div class="pull-right">
            <button class="btn btn-success" type="submit" @if(!empty($invoice_mode)) id="saver" @endif><i
                        class="fa fa-save"></i> Save
            </button>
        </div>
    </div>
</div>