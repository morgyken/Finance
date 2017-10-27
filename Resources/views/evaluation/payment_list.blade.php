<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);

function amount_after_discount($discount, $amount)
{
    try {
        $discounted = $amount - (($discount / 100) * $amount);
        return ceil($discounted);
    } catch (\Exception $e) {
        return $amount;
    }
}

?>
@extends('layouts.app')
@section('content_title','Patient Accounts')
@section('content_description','View patient accounts')

@section('content')
    <div class="box box-info">
    </div>
    <div class="box box-body">
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#patients" data-toggle="tab">
                            Patients
                            <span class="badge alert-info">
                            {{$visits->count()}}
                        </span>
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
                    <li>
                        <a href="#invoice" data-toggle="tab">
                            Payment for Invoice
                            <span class="badge alert-info">
                            {{$invoiced->count()}}
                        </span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!--Patient List Tab -->
                    <div class="tab-pane active" id="patients">

                        <table class="table table-striped table-condensed table-responsive" id="patients">
                            <tbody>
                            @foreach($visits as $visit)
                                <?php $patient = $visit->patients; ?>
                                <tr id="patient{{$patient->patient_id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$patient->full_name}}</td>
                                    <td>{{$patient->id_no}}</td>
                                    <td>{{$visit->created_at->format('d/m/y')}} </td>
                                    <td>{{$patient->mobile}}</td>
                                    <td>
                                        @if(patient_has_pharmacy_bill($visit))
                                            <a class="btn btn-warning btn-xs"
                                               href="{{route('finance.evaluation.pay.pharmacy',$patient->id)}}">
                                                <i class="fa fa-bolt"></i> Process Meds</a>
                                        @endif
                                        <a class="btn btn-primary btn-xs"
                                           href="{{route('finance.evaluation.pay',['patient'=>$patient->id])}}">
                                            <i class="fa fa-hand-lizard-o"></i> Receive Payment</a>
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('finance.evaluation.invoice',$patient->id)}}">
                                            <i class="fa fa-file-text"></i> Create Invoice</a>
                                        <a class="btn btn-success btn-xs"
                                           href="{{route('finance.evaluation.individual_account',$patient->id)}}">
                                            <i class="fa fa-eye-slash"></i> View Account</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Date</th>
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
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{route('finance.evaluation.sale.pay',$sale->id)}}">
                                            <i class="fa fa-hand-lizard-o"></i> Receive Payments</a>
                                        <a class="btn btn-success btn-xs"
                                           href="{{route('finance.evaluation.sale',$sale->id)}}">
                                            <i class="fa fa-eye-slash"></i> View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- -->


                    <!--For Invoice -->
                    <div class="tab-pane" id="invoice">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Mobile</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoiced as $patient)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$patient->full_name}}</td>
                                    <td>{{$patient->id_no}}</td>
                                    <td>{{$patient->mobile}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs"
                                           href="{{route('finance.evaluation.pay',['patient'=>$patient->id,'invoice'=>true])}}">
                                            <i class="fa fa-hand-lizard-o"></i> Receive Payment</a>
                                        <a class="btn btn-success btn-xs"
                                           href="{{route('finance.evaluation.individual_account',$patient->id)}}">
                                            <i class="fa fa-eye-slash"></i> View Account</a>
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