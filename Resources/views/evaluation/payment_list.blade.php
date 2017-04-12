<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Accounts')
@section('content_description','View patient accounts')

@section('content')
<div class="box box-info">
    <br>
    <div class="form-horizontal">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#patients" data-toggle="tab">
                        Patients
                    </a>
                </li>
                <li>
                    <a href="#sales" data-toggle="tab">
                        Point Of Sale
                        <span class="badge alert-info">
                            {{$sales->count()}}
                        </span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!--Patient List Tab -->
                <div class="tab-pane active" id="patients">

                    <table class="table table-condensed table-responsive" id="patients">
                        <tbody>
                            @foreach($patients as $patient)
                            <tr id="patient{{$patient->patient_id}}">
                                <td>{{$patient->full_name}}</td>
                                <td>{{$patient->id_no}}</td>
                                <td>{{$patient->mobile}}</td>
                                <td>
                                    <a class="btn btn-primary btn-xs" href="{{route('finance.evaluation.pay',$patient->id)}}">
                                        <i class="fa fa-hand-lizard-o"></i> Receive Payments</a>
                                    <a class="btn btn-success btn-xs" href="{{route('finance.evaluation.individual_account',$patient->id)}}">
                                        <i class="fa fa-eye-slash"></i> View Account</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Mobile</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!--Pharmacy Sales Tab -->
                <div class="tab-pane" id="sales">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sale ID</th>
                                <th>Receipt Number</th>
                                <th>Client</th>
                                <th>Sale Date/Time</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$sale->id}}</td>
                                <td>{{$sale->receipt}}</td>
                                <td>{{$sale->patients?$sale->patients->full_name:'not set (walk in)'}}</td>
                                <td>{{$sale->created_at}}</td>
                                <td>{{number_format($sale->amount,2)}}</td>
                                <td>
                                    <a class="btn btn-primary btn-xs" href="{{route('finance.evaluation.sale.pay',$sale->id)}}">
                                        <i class="fa fa-hand-lizard-o"></i> Receive Payments</a>
                                    <a class="btn btn-success btn-xs" href="{{route('finance.evaluation.sale',$sale->id)}}">
                                        <i class="fa fa-eye-slash"></i> View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- -->
            </div>
        </div>
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