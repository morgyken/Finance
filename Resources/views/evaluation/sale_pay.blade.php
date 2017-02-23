<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Receive Payments')
@section('content_description','Receive payments from patients')

@section('content')
{!! Form::open(['id'=>'payForm','route'=>'finance.evaluation.pay.save','autocomplete'=>'off'])!!}

<div class="box box-info">
    <div class="box-body">
        <div class="col-md-6">
            Sale ID: <strong>{{$sales->id}}</strong><br>
            Receipt Number: <strong>{{$sales->receipt}}</strong>
            <hr/>
            <h4>Select items for payment<span class="pull-right" id="total"></span></h4>
            <div class="accordion">
                <h3>{{(new Date($sales->created_at))->format('dS M y g:i a')}}</h3>
                <div id="visit{{$sales->id}}">
                    @include('finance::evaluation.partials.from_pos')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @include('finance::evaluation.form')
        </div>
    </div>
</div>

{!! Form::close()!!}
<script src="{{m_asset('evaluation:js/payments.min.js')}}"></script>
<style type="text/css">
    #visits tbody tr.highlight {
        background-color: #B0BED9;
    }
</style>
@endsection