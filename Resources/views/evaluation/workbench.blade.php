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
                    <li
                    <?php
                    if (isset($pending_mode)) {
                        $mode = 'pending'
                        ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.pending')}}">Pending</a></li>
                    <li <?php
                    if (isset($bill_mode)) {
                        $mode = 'billing'
                        ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.billed')}}">Billed</a></li>
                    <li <?php
                    if (isset($cancel_mode)) {
                        $mode = 'cancelled'
                        ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.cancelled')}}">Canceled</a></li>
                    <li <?php
                    if (isset($dispatch_mode)) {
                        $mode = 'dispatched'
                        ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.dispatched')}}">Dispatched</a></li>
                    <li <?php
                    if (isset($payment_mode)) {
                        $mode = 'payment'
                        ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.payment')}}">Payment</a></li>
                    <li <?php
                    if (isset($paid_mode)) {
                        $mode = 'paid'
                        ?>class="active"<?php } ?>><a href="{{route('finance.evaluation.paid')}}">Paid</a></li>
                </ul>
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
    $(document).ready(function () {

        function get_invoices(firm) {
            //initialize
            var mode = $('#mode').val();
            $.ajax({
                type: 'get',
                url: "{{route('api.finance.evaluation.firm.invoices')}}",
                data: {firm: firm, mode: mode},
                success: function (response) {
                    $('.response').html(response);
                }
            }); //ajax
        }

        $("#action-btn").hide();
        $("#action-scene").html('<span class="label label-danger">Select an Insurance Firm for action</span>');
        $(".company").change(function () {
            get_invoices(this.value);
            if (mode === 'payment') {
                $("#action-scene").html('<input type="submit" class="btn-primary" id="action-btn" value="Receive Payment">');
            } else {
                $("#action-scene").html('<input type="submit" class="btn-primary" value="Dispatch Selected Invoices" >');
            }
        });

        $("#cheque_amount").keyup(function () {
            $('#pay_balance').val(this.value);
            $('#paycheque_amnt').val(this.value);
        });

        $("#cheque_no").keyup(function () {
            $('#paycheck_no').val(this.value);
        });

        $("#payment_table").mouseover(function () {
            $('#paycheck_no').val($("#cheque_no").val());
            $('#paycheque_amnt').val($("#cheque_amount").val());
        });



        $('.table').dataTable();
    });
    function updateAmount(amount, i) {
        $amount = $('#pay_dis_tot');
        $sum = $('#pay_sum');
        $balance = $('#pay_balance').val();
        //var bal = 0;
        if ($('#pay_check' + i).is(':checked')) {
            $amount.val(parseInt($amount.val(), 10) + amount);
            //$balance -= amount;
            //alert($balance);
        } else {
            $amount.val(parseInt($amount.val(), 10) - amount);
        }
    }
</script>
@endsection
