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
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Patient Account</h3>
    </div>
    <div class="box-body">
        <dl class="dl-horizontal">
            <dt>Name:</dt><dd>{{$patient->full_name}}</dd>
            <dt>Phone:</dt><dd>{{$patient->mobile}}</dd>
        </dl>
        @if(!$payments->isEmpty())

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