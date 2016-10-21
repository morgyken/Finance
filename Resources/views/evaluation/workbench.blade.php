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
            <div class="nav-tabs-custom">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="#billed" data-toggle="pill">Billed</a></li>
                    <li><a href="#cancelled" data-toggle="pill">Canceled</a></li>
                    <li><a href="#dispatched" data-toggle="pill">Dispatched</a></li>
                    <li><a href="#payment" data-toggle="pill">Payment</a></li>
                    <li><a href="#paid" data-toggle="pill">Paid</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="billed">

                </div>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
@endsection
