<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
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
            <table class="table table-striped">
                <tbody>
                    @foreach($transactions as $t)
                    <tr>
                        <td>{{$t->id}}</td>
                        <td>{{$t->created_at}}</td>
                        <td>{{$t->type}}</td>
                        <td>{{$t->amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tfoot>
                <tr>
                    <th colspan="3" style="text-align: right">Balance</th>
                    <th>{{number_format(get_patient_balance($patient->id),2)}}</th>
                </tr>
                </tfoot>
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

