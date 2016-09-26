<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
@extends('layouts.app')
@section('content_title','Billing workbench')
@section('content_description','View invoices and notes')

@section('content')
<div class="box box-info">
    <div class="box-header">
        <div class="btn-group">
            <a href="{{route('finance.workbench','insurance')}}" class="btn btn-default">
                <i class="fa fa-institution"></i> Insurance Bills</a>
            <a href="{{route('finance.workbench','cash')}}" class="btn btn-default">
                <i class="fa fa-money"></i> Cash Bills</a>
        </div>
    </div>
    <div class="box-body">
        @if(!$data['insurance']->isEmpty())
        @include('finance.partials.workbench_insurance')
        @endif
        @if(!$data['cash']->isEmpty())
        @include('finance.partials.workbench_cash')
        @endif
    </div>
</div>
@endsection