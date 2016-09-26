<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
$p = $data['pay'];
?>

@extends('layouts.app')
@section('content_title','Invoice Payment Details')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-6 col-lg-6 col-sm-12">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Mode</th>
                    <th>Account Number</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td>{{$p['id']}}</td>
                    <td>{{$p['amount']}}</td>
                    <td>{{$p['mode']}}</td>
                    <td style="text-align: center">
                        @if($p['account'])
                        {{$p['account']}}
                        @else
                        not applicable
                        @endif
                    </td>
                    <td>{{$p['created_at']}}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-12">
            @if($p['grn'])
            <table class="table">
                <tr>
                    <th colspan="2">GRN Details</th>
                </tr>
                <tr>
                    <td>Delivery Id:</td>
                    <td>{{$p->grns->id}}</td>
                </tr>
                <tr>
                    <td>Supplier:</td>
                    <td>{{$p->grns->suppliers->name}}</td>
                </tr>
                <tr>
                    <td>Delivery Date:</td>
                    <td>{{$p->grns->created_at}}</td>
                </tr>
            </table>
            @else
            <table class="table">
                <tr>
                    <th colspan="2">Invoice Details</th>
                </tr>
                <tr>
                    <td>Invoice Number:</td>
                    <td>{{$p->invoices->number}}</td>
                </tr>
                <tr>
                    <td>Creditor:</td>
                    <td>{{$p->invoices->creditors->name}}</td>
                </tr>
                <tr>
                    <td>Delivery Date:</td>
                    <td>{{$p->invoices->created_at}}</td>
                </tr>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection