<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$patient = $data['patient'];
?>
@extends('layouts.app')
@section('content_title','Patient Account')
@section('content_description','View patient account ')

@section('content')
<div class="row">
    <div class="box box-info">
        <div class="box-body">
            <div class="box-body">
                <p>Individual Account for <strong>{{$patient->full_name}}</strong></p>
            </div>
            @if(!$data['payments']->isEmpty())
            <table class="table">
                <tbody>

                </tbody>
                <thead>
                    <tr>
                        <th>REF</th>
                        <th>Type</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Mode</th>
                    </tr>
                </thead>
            </table>
            @else
            <div class="alert alert-info">
                <h4>No records</h4>
                <p><i class="fa fa-warning"></i> This account has neither been debited nor credited.</p>
            </div>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('table').DataTable();
    });
</script>
@endsection

