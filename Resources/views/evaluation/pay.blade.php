<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$__visits = $patient->visits;
?>
@extends('layouts.app')
@section('content_title','Receive Payment')
@section('content_description','Receive payment from patient')

@section('content')
{!! Form::open(['id'=>'payForm','route'=>'finance.evaluation.pay.save','autocomplete'=>'off'])!!}
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-6">
            Patient Name: <strong>{{$patient->full_name}}</strong>
            <hr/>
            <h4>Select items for payment<span class="pull-right" id="total"></span></h4>
            @if(!$invoice_mode)
            @include('finance::evaluation.payment.investigation_mode')
            @else
            @include('finance::evaluation.payment.invoice_mode')
            @endif
        </div>
        <div class="col-md-6">
            @include('finance::evaluation.form')
        </div>
    </div>
</div>
{!! Form::close()!!}
<script type="text/javascript">
    function remove_bill(type, id, visit) {
        $.ajax({
            type: 'get',
            url: "{{route('api.finance.evaluation.bill.remove')}}",
            data: {type: type, id: id, visit: visit},
            success: function (response) {
                location.reload();
            }
        }); //ajax
    }

    function undo_remove_bill(type, id, visit) {
        $.ajax({
            type: 'get',
            url: "{{route('api.finance.evaluation.bill.undoremove')}}",
            data: {type: type, id: id, visit: visit},
            success: function (response) {
                location.reload();
            }
        }); //ajax
    }
</script>

<script src="{{m_asset('evaluation:js/payments.min.js')}}"></script>
<style type="text/css">
    #visits tbody tr.highlight {
        background-color: #B0BED9;
    }
</style>
@endsection