<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Payment Summary')
@section('content_description','View payment summary')

@section('content')
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Payment Summary</h3>
    </div>
    <div class="box-body">
        @if(!$all->isEmpty())
        <table class="table table-condensed table-responsive" id="patients">
            <tbody>
                @foreach($all as $payment)
                <tr id="payment{{$payment->id}}">
                    <td>{{$payment->id}}</td>
                    <td>{{$payment->receipt}}</td>
                    <td>{{$payment->patients->full_name}}</td>
                    <td>{{smart_date_time($payment->created_at)}}</td>
                    <td>{{$payment->total}}</td>
                    <td>{{$payment->modes}}</td>
                    <td><a href="{{route('finance.evaluation.payment_details', $payment->id)}}"> <i class="fa fa-eye"></i></a></td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Receipt</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Modes</th>
                    <th></th>
                </tr>
            </thead>
        </table>
        @else
        <div class="alert alert-info">
            <p><i class="fa fa-info-circle"></i> No payment records found</p>
        </div>
        @endif
    </div>
    <div class="box-footer">

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').DataTable();
        } catch (e) {
        }
    });
</script>
@endsection