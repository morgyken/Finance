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
@section('content_description','View patient account history')

@section('content')

    <div class="row">
        <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">

            <a class="btn btn-primary btn-xs" href="{{route('finance.evaluation.pay',['patient'=>$patient->id,'invoice'=>false])}}">
                <i class="fa fa-send"></i> Make a Deposit</a>
        </div>
    </div>

    <div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">{{$patient->last_name}}'s Account</h3>
    </div>
    <div class="box-body">
        <dl class="dl-horizontal">
            <dt>Name:</dt><dd>{{$patient->full_name}}</dd>
            <dt>Phone:</dt><dd>{{$patient->mobile}}</dd>
        </dl>
        @if(!$payments->isEmpty())
            <table class="table table-condensed table-responsive table-striped" id="patients">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Receipt</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Payment Mode(s)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr id="payment{{$payment->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>
                            <a href="{{route('finance.evaluation.payment_details', $payment->id)}}">
                                {{$payment->receipt}}</a>
                        </td>
                        <td>{{smart_date_time($payment->created_at)}}</td>
                        <td>{{$payment->total}}</td>
                        <td>{{$payment->modes}}</td>
                        <td><a href="{{route('finance.evaluation.payment_details', $payment->id)}}"> <i class="fa fa-eye"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th colspan="2" style="text-align: right">Total payments ever received:</th>
                    <th>{{number_format(total_patient_payments($patient->id),2)}}</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="2" style="text-align: right">Overall Consumed Service Cost:</th>
                    <th>
                        {{number_format(overall_patient_service_cost($patient->id),2)}}
                    </th>
                    <th></th>
                    <th></th>
                </tr>


                <tr>
                    <th></th>
                    <th colspan="2" style="text-align: right">Unpaid Amount:</th>
                    <th>
                        {{number_format(get_patient_unpaid($patient->id),2)}}
                    </th>
                    <th></th>
                    <th></th>
                </tr>

                <tr>
                    <th></th>
                    <th colspan="2" style="text-align: right">Balance:</th>
                    <th>
                        @if(get_patient_balance($patient->id)<0)
                            <span style="color: red">
                                {{number_format(get_patient_balance($patient->id),2)}}
                            </span>
                        @else
                            {{number_format(get_patient_balance($patient->id),2)}}
                        @endif
                    </th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        @else
        <p class="text-info"><i class="fa fa-info-circle"></i> This patient has no payment or billing record</p>
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