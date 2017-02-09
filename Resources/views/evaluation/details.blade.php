<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Payment Details')
@section('content_description','Payment from patients')


@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Payment Details</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-6">
                <dl class="dl-horizontal">
                    <dt>Name:</dt><dd>{{$payment->patients->full_name}}</dd>
                    <dt>Receipt:</dt><dd>#{{$payment->receipt}}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="dl-horizontal">
                    <dt>Cashier:</dt><dd>{{$payment->users->profile->full_name}}</dd>
                    <dt>Date:</dt><dd>{{smart_date_time($payment->created_at)}}</dd>
                </dl>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Procedures/Drug</th>
                        <th>Cost (Ksh.)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $inv_amount = 0; ?>
                    @if(isset($payment->visits->investigations))
                    @foreach($payment->visits->investigations as $i)
                    <?php $inv_amount+=$i->price ?>
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$i->procedures->name}} <i
                                class="small">({{$i->type}})</i></td>
                        <td>{{$i->price}}</td>
                    </tr>
                    @endforeach
                    @endif
                    <!--Drugs Dispensed -->
                    <?php
                    $disp_amount = 0;
                    if (isset($payment->visits->dispensing)) {
                        ?>
                        @foreach($payment->visits->dispensing as $item)
                        <?php $disp_amount+=$item->amount ?>
                        @foreach($item->details as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->drug->name}} <i
                                    class="small">(x{{$item->quantity}})</i></td>
                            <td>{{$item->price}}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        <?php
                    }
                    ?>
                    <!--POS -->
                    <?php
                    $pos_amount = 0;
                    if (isset($payment->visits->drug_purchases)) {
                        ?>
                        @foreach($payment->visits->drug_purchases as $item)
                        <?php
                        $pos_amount+=$item->amount;
                        ?>
                        @foreach($item->details as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->drugs->name}} <i
                                    class="small">(x{{$item->quantity}})</i></td>
                            <td>{{$item->price}}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Bill</th>
                        <th></th>
                        <th>
                            {{$inv_amount+$disp_amount+$pos_amount}}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-6">
            @if(!empty($payment->cash))
            <h4>Cash Payment</h4>
            Amount Paid: Ksh {{$payment->cash->amount}}
            <hr/>
            @endif

            @if(!empty($payment->mpesa))
            <h4>Mpesa Payment</h4>
            MPESA Ref: {{$payment->mpesa->reference}}<br/>
            Amount: Ksh {{$payment->mpesa->amount}}
            <hr/>
            @endif
            @if(!empty($payment->cheque))
            <h4>Cheque Payment</h4>
            Amount: Ksh {{$payment->cheque->amount}}
            <hr/>
            @endif
            @if(!empty($payment->card))
            <h4>Card Payment</h4>
            Amount: Ksh {{$payment->card->amount}}
            <hr/>
            @endif
            <strong>Total: Ksh {{$payment->total}}</strong>
            <hr/>


        </div>
    </div>
    <div class="box-footer">
        {!! Form::open(['route'=>'finance.evaluation.normal.rcpt.print','target'=>'_blank'])!!}
        {!! Form::hidden('payment',$payment->id) !!}
        <button class="btn btn-primary" type="submit">
            <i class="fa fa-file-pdf-o"></i> Print Receipt</button>
        {{Form::close()}}
    </div>
</div>
@endsection
