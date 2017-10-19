<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$mode = '';
?>
@extends('layouts.app')
@section('content_title','Insurance and Credit Clients Workbench')
@section('content_description','')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Manage insurance billing</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li
                            <?php
                            if (isset($pending_mode)) {
                            $mode = 'pending'
                            ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.pending')}}">Pending</a>
                        </li>
                        <li <?php
                            if (isset($bill_mode)) {
                            $mode = 'billing'
                            ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.billed')}}">Billed</a>
                        </li>
                        <li <?php
                            if (isset($cancel_mode)) {
                            $mode = 'cancelled'
                            ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.cancelled')}}">Cancelled</a>
                        </li>
                        <li <?php
                            if (isset($dispatch_mode)) {
                            $mode = 'dispatched'
                            ?>class="active"<?php } ?>><a
                                    href="{{route('finance.evaluation.dispatched')}}">Dispatched</a>
                        </li>
                        <li <?php
                            if (isset($payment_mode)) {
                            $mode = 'payment'
                            ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.payment')}}">Payment</a>
                        </li>
                        <li <?php
                            if (isset($paid_mode)) {
                            $mode = 'paid'
                            ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.paid')}}">Paid</a>
                        </li>
                        <li <?php
                            if (isset($stmt_mode)) {
                            $mode = 'stmt_mode'
                            ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.company.stmt')}}">Company
                                Statements</a>
                        </li>
                    </ul>
                    <br/>
                    <input type="hidden" id="mode" value="{{$mode}}">
                    @if($mode=='payment')
                        @include('finance::evaluation.partials.payment_search')
                    @else
                        @include('finance::evaluation.partials.search')
                    @endif
                    <div class="tab-content">
                        @yield('tab')
                    </div>
                </div>

            </div>
            <div class="box-footer">
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var SCHEMES_URL = "{{route('api.settings.get_schemes')}}";
    </script>
    <script src="{{m_asset('finance:js/insurancee.js')}}"></script>
    <style>
        .disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>
@endsection
