<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Insurance Billing Workbench')
@section('content_description','Manage insurance bills')


@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Manage insurance billing</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="nav-custom">
                <ul class="nav nav-tabs">
                    <li  class="active"><a href="#pending" data-toggle="tab">Pending</a></li>
                    <li><a href="#billed" data-toggle="tab">Billed</a></li>
                    <li><a href="#cancelled" data-toggle="tab">Canceled</a></li>
                    <li><a href="#dispatched" data-toggle="tab">Dispatched</a></li>
                    <li><a href="#payment" data-toggle="tab">Payment</a></li>
                    <li><a href="#paid" data-toggle="tab">Paid</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="pending">
                        @if(!$all->isEmpty())
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient</th>
                                    <th>Visit</th>
                                    <th>Company</th>
                                    <th>Scheme</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($all as $visit)
                                <tr>
                                    <td>{{$visit->id}}</td>
                                    <td>{{$visit->patients->full_name}}</td>
                                    <td>{{(new Date($visit->created_at))->format('dS M y g:i a')}} - Clinic {{$visit->clinics->name}}</td>
                                    <td>{{$visit->patient_scheme->schemes->companies->name}}</td>
                                    <td>{{$visit->patient_scheme->schemes->name}}</td>
                                    <td>{{$visit->unpaid_amount}}</td>
                                    <td><a href="" class="btn btn-xs btn-primary"><i class="fa fa-usd"></i> Bill</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No pending insurance bill</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
@endsection
