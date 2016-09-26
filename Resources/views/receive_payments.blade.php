<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$patient = $data['patient'];
$__visits = $patient->visits; //->where('payment_status', 'pending');
?>
@extends('layouts.app')
@section('content_title','Receive Payments')
@section('content_description','Receive payments from patients')


@section('content')
<div class="box box-info">
    <div class="box-body">
        {!! Form::open(['id'=>'payForm'])!!}
        <div class="col-md-6">
            Patient Name: <strong>{{$patient->full_name}}</strong>
            <hr/>
            <h4>Billing Information<span class="pull-right" id="total"></span></h4>
            @if(!empty($patient->visits))
            <div id="accordion">
                @foreach($__visits as $visit)
                <h3>{{(new Date($visit->created_at))->format('dS M y g:i a')}} -  Clinic {{$visit->clinics->name}}</h3>
                <div id="visit{{$visit->visit_id}}">
                    <table class="table table-condensed">
                        <tbody>
                            @foreach($visit->treatments as $item)
                            <tr>
                                @if($item->is_paid)
                                <td><input type="checkbox" disabled/></td>
                                <td>
                                    <div class="label label-success">Paid</div>
                                    {{$item->procedures->name}} <i class="small">(Treatment)</i> - Ksh {{$item->price*$item->no_performed}}
                                </td>
                                @else
                                <td><input type="checkbox" value="{{$item->procedure}}" name="pay[{{$item->test}}]" class="group"/>
                                    <input type="hidden" name="payVisit[{{$item->procedure}}]" value="{{$visit->visit_id}}"></td>
                                <td>{{$item->procedures->name}} <i class="small">(Treatment)- Ksh <span class="topay">{{$item->price*$item->no_performed}}</span></td>
                                @endif
                            </tr>
                            @endforeach
                            @foreach($visit->investigations as $item)
                            <tr>
                                @if($item->is_paid)
                                <td><input type="checkbox" disabled/></td>
                                <td>
                                    <div class="label label-success">Paid</div>
                                    {{$item->procedures->name}} <i class="small">({{$item->type}})</i> - Ksh {{$item->price}}
                                </td>
                                @else
                                <td><input type="checkbox" value="{{$item->test}}" name="pay[{{$item->test}}]" class="group"/>
                                    <input type="hidden" name="payVisit[{{$item->test}}]" value="{{$visit->visit_id}}"></td>
                                <td>{{$item->procedures->name}} <i class="small">({{$item->type}})</i> - Ksh <span class="topay">{{$item->price}}</span></td>
                                @endif
                            </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info">
                <i class="fa fa-info"></i> This patient has not been billed.
                Click <a href="{{route('finance.receive_payments')}}">here </a> for a list of patient with pending bills.
            </div>
            @endif
        </div>
        <div class="col-md-6">
            @include('finance.partials.payment_form')
        </div>
        {!! Form::close()!!}
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var costArray = 0;
        var SUM = 0;
        $('#payForm input').keyup(function () {
            sumPayments();
        });
        function sumPayments() {
            function parser(j) {
                return parseInt(j) || 0;
            }
            var insurance = parser($('input[name=InsuranceAmount]').val());
            var cash = parser($('input[name=CashAmount]').val());
            var mpesa = parser($('input[name=MpesaAmount]').val());
            var cheque = parser($('input[name=ChequeAmount]').val());
            var card = parser($('input[name=CardAmount]').val());
            SUM = insurance + cash + mpesa + cheque + card;
            $('#all').html("Total: <strrong>Ksh " + SUM + "</strong>");
        }
        $('#accordion').accordion({heightStyle: "content"});
        $('#payForm').submit(function (e) {
            e.preventDefault();
            if (SUM === 0) {
                alert('Please enter payment amount details');
                return;
            }
            if (SUM !== costArray) {
                alert('Payment does not match the cost for tselected procedures');
                return;
            }
            $('#payForm').unbind().submit();
        });
        $('.group').click(function () {
            if ($(this).is(':checked'))
                costArray += parseInt($(this).parent().parent().find('span').html());
            else
                costArray = costArray - parseInt($(this).parent().parent().find('span').html());
            $('#total').html("Total: <strrong>Ksh " + costArray + "</strong>");
        });
        $('#total').html("Total: <strrong>Ksh " + costArray + "</strong>");
        $('#all').html("Total: <strrong>Ksh " + SUM + "</strong>");
    });

</script>
<style type="text/css">
    #visits tbody tr.highlight { background-color: #B0BED9; }
</style>
@endsection-