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
                <ul class="nav nav-tabs">
                    <li  class="active">
                        <a href="#pending" data-toggle="tab">Pending</a>
                    </li>
                    <li><a href="#billed" data-toggle="tab">Billed</a></li>
                    <li><a href="#canceled" data-toggle="tab">Canceled</a></li>
                    <li><a href="#dispatched" data-toggle="tab">Dispatched</a></li>
                    <li><a href="#payment" data-toggle="tab">Payment</a></li>
                    <li><a href="#paid" data-toggle="tab">Paid</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="pending">
                        @include('finance::evaluation.partials.pending')
                    </div>

                    <div class="tab-pane" id="billed">
                        @include('finance::evaluation.partials.billed')
                    </div>
                    <div class="tab-pane" id="canceled">
                        @include('finance::evaluation.partials.canceled')
                    </div>
                    <div class="tab-pane" id="dispatched">
                        @include('finance::evaluation.partials.dispatched')
                    </div>

                    <div class="tab-pane" id="payment">
                        @include('finance::evaluation.partials.unpaid')
                    </div>
                    <div class="tab-pane" id="paid">
                        @include('finance::evaluation.partials.paid')
                    </div>
                </div>
            </div>

        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
@endsection
