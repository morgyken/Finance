<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Bravo Gidi (bkiptoo@collabmed.com)
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Insurance Billing Workbench')
@section('content_description','Manage insurance bills')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Receive Payment for Insurance Invoices</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li  class="active">
                        <a href="#payment" data-toggle="tab">Payment</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="payment">
                        @include('finance::evaluation.partials.payment')
                    </div>
                </div>
            </div>

        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
@endsection
