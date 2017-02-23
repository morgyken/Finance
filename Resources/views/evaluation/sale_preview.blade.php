<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Point of sale')
@section('content_description','Sales note ')


@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Items dispensed</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Sale ID: {{$data['sales']->id}}</th>
                        <th>Receipt Number: {{$data['sales']->receipt}}</th>
                    </tr>
                </table>
                <br>
                <table class="table table-condensed">
                    <tbody>
                        @foreach($data['sales']->goodies as $item)
                        <tr>
                            <td>{{$item->products->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->discount}}</td>
                            <td>{{number_format($item->unit_cost,2)}}</td>
                            <td>{{number_format($item->total,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Discount (%)</th>
                            <th>Unit Cost</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th>{{number_format($data['sales']->goodies->sum('total'),2)}}</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="btn-group">
                    <a href="{{route('finance.evaluation.sale.pay',$data['sales']->id)}}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-print"></i> Receive Payment</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .strike{
        color:red;
        text-decoration:line-through;
    }
</style>
@endsection
