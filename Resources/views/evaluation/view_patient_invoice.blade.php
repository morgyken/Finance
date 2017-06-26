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
@section('content_title','Invoice Details')
@section('content_description','')

@section('content')
    <div class="box box-info">
        <div class="box-header">
            <p>
                <strong>Patient:</strong> {{$invoice->patient->full_name}}
            </p>
            <p>
                <strong>Invoice No.:</strong> 0{{$invoice->id}}
            </p>
            <p>
                <strong>Date:</strong> {{$invoice->created_at}}
            </p>
        </div>
        <div class="box-body">
            @if(!empty($invoice))
                <table class="table table-condensed table-responsive">
                    <tbody>
                    @foreach($invoice->details as $item)
                        <tr id="invoice{{$item->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->item_name}}</td>
                            <td>{{$item->item_type}}</td>
                            <td>{{number_format($item->amount,2)}}</td>
                            <td>{{$item->service_date}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Service Date</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td>
                            <p>
                                <strong>Total Amount:</strong> {{number_format($invoice->total,2)}}
                            </p>
                            <p>
                                <strong>Amount Paid:</strong>
                                {{number_format(get_patient_invoice_paid_amount($invoice->id),2)}}
                            </p>
                            <p>
                                <strong>Amount Pending:</strong>
                                {{number_format(get_patient_invoice_pending_amount($invoice->id),2)}}
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            @else
                <p>Strange! the invoice has no items</p>
            @endif
        </div>
        <div class="box-footer">
            <a href="{{ route('finance.evaluation.pay') }}#invoice" class="btn btn-primary btn-xs">
                <i class="fa fa-money"></i>Payment</a>|
            <a target="_blank" href="{{ route('finance.evaluation.patient_invoice.print', $invoice->id) }}" class="btn btn-primary btn-xs">
                <i class="fa fa-print"></i>Print</a>|
            @if(get_patient_invoice_paid_amount($invoice->id)>0)
                <a disabled="" href="#" title="Invoice has payments" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash"></i> Delete</a>
            @else
                <a href="{{route('finance.evaluation.purge_patient_invoice', $item->id)}}" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash"></i> Delete</a>
            @endif
        </div>
    </div>
@endsection
