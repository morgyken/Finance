<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 6/26/17
 * Time: 3:30 PM
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Manage Patient Invoices')
@section('content_description','')

@section('content')

    <div class="row">
        <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
            <a href="{{ route('finance.evaluation.pay') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                <i class="fa fa-pencil"></i> New Invoice
            </a>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Patient Invoices</h3>
        </div>
        <div class="box-body">
            @if($invoices->count()>0)
                <table class="table table-condensed table-responsive">
                    <tbody>
                    @foreach($invoices as $item)
                        <tr id="invoice{{$item->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->patient->full_name}}</td>
                            <td>0{{$item->id}}</td>
                            <td>{{number_format($item->total,2)}}</td>
                            <td>{{number_format(get_patient_invoice_paid_amount($item->id),2)}}</td>
                            <td>{{number_format(get_patient_invoice_pending_amount($item->id),2)}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->status}}</td>
                            <td>
                                <a href="{{route('finance.evaluation.patient_invoices', $item->id)}}" class="btn btn-primary btn-xs">
                                    <i class="fa fa-eye"></i></a>|
                                <a href="{{ route('finance.evaluation.pay') }}#invoice" class="btn btn-primary btn-xs">
                                    <i class="fa fa-money"></i></a>|
                                <a target="_blank" href="{{ route('finance.evaluation.patient_invoice.print', $item->id) }}" class="btn btn-primary btn-xs">
                                        <i class="fa fa-print"></i>
                                </a>|
                                @if(get_patient_invoice_paid_amount($item->id)>0)
                                <a disabled="" href="#" title="Invoice has payments" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"></i></a>
                                    @else
                                    <a href="{{route('finance.evaluation.purge_patient_invoice', $item->id)}}" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Invoice Number</th>
                        <th>Amount Invoiced</th>
                        <th>Amount Paid</th>
                        <th>Balance</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            @else
                <p>No patient invoices have been created so far!</p>
            @endif
        </div>
        <div class="box-footer"></div>
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
