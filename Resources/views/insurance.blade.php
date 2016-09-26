<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
@extends('layouts.app')
@section('content_title','View Insurance Financial')
@section('content_description','View patient patient insurance financial')

@section('content')
<div class="box box-info">
    <div class="box-body">
        @if($data['invoice']->isEmpty())
        <div class="alert alert-info">
            <i class="fa fa-info">No insurance invoices</i>
        </div>
        @else
        <table class="table table-responsive table-condensed">
            <tbody>
                @foreach($data['invoice'] as $invoice)
                <tr>
                    <td>{{$invoice->invoice_no}}</td>
                    <td>{{$invoice->payments->schemes->name}}</td>
                    <td>{{$invoice->payments->schemes->name}}</td>
                    <td>{{$invoice->payments->InsuranceAmount}}</td>
                    <td>{{(new Date($invoice->created_at))->format('d/m/Y')}}</td>
                    <td><a href=""><i class="fa fa-print"></i></a></td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Company</th>
                    <th>Scheme</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
        </table>
        @endif
    </div>
</div>
@endsection