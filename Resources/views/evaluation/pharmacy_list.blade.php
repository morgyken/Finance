<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);

function amount_after_discount($discount, $amount)
{
    try {
        $discounted = $amount - (($discount / 100) * $amount);
        return ceil($discounted);
    } catch (\Exception $e) {
        return $amount;
    }
}

?>
@extends('layouts.app')
@section('content_title','Pending Payments')
@section('content_description','Pending Payments for pharmacy')

@section('content')
    <div class="box box-info">
        <div class="box-body">
            <div class="form-horizontal">
                <table class="table table-striped table-condensed table-responsive" id="patients">
                    <tbody>
                    @foreach($patients as $patient)
                        <tr id="patient{{$patient->patient_id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$patient->full_name}}</td>
                            <td>{{$patient->id_no}}</td>
                            <td>{{$patient->mobile}}</td>
                            <td>
                                <a class="btn btn-primary btn-xs"
                                   href="{{route('finance.evaluation.pay.pharmacy',['patient'=>$patient->id])}}">
                                    <i class="fa fa-hand-lizard-o"></i> Receive Payment</a>
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
            </div>
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