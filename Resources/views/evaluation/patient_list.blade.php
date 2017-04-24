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
@section('content_description','View patient accounts')

@section('content')
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Patient</h3>
    </div>
    <div class="box-body">
        @if($patients->count()>0)
        <table class="table table-striped table-condensed table-responsive" id="patients">
            <tbody>
                @foreach($patients as $patient)
                <tr id="patient{{$patient->patient_id}}">
                    <td>{{$loop->iteration}}</td>
                    <td>{{$patient->full_name}}</td>
                    <td>{{$patient->id_no}}</td>
                    <td>{{$patient->mobile}}</td>
                    <td>
                        <!--   <a class="btn btn-primary btn-xs" href="{{route('finance.evaluation.pay',$patient->id)}}">
                               <i class="fa fa-hand-lizard-o"></i> Receive Payments</a>-->
                        <a class="btn btn-success btn-xs" href="{{route('finance.evaluation.individual_account',$patient->id)}}">
                            <i class="fa fa-eye-slash"></i> View Account</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Mobile</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
        @else
        <div class="alert alert-info">
            <p><i class="fa fa-info-circle"></i> No patients with pending payments. Looks good!</p>
        </div>
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