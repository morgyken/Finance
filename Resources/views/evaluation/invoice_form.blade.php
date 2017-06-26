<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<strong>Proceed</strong>
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
@elseif(isset($visit))
{!! Form::hidden('patient',$visit->patients->id) !!}
@elseif(isset($sales))
<input type="hidden" name="patient" value="{{$sales->patient}}">
@endif
@if(isset($visit))
<input type="hidden" name="visit" value="{{$visit->id}}">
@endif
<div class="row">
    <div class="col-md-12">
        <h4><span class="pull-right" id="total"></span></h4>
    </div>
    <div class="col-md-12">
        <hr/>
        <div class="pull-left">
            <span id="all"></span><br/>
            <span id="balance"></span>
        </div>
        <div class="pull-right">
            <button class="btn btn-success" type="submit">
                <i class="fa fa-folder-open"></i> Create Invoice
            </button>
        </div>
    </div>
</div>