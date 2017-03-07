<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$t = 0;
$last_visit = 0;
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
            @if(!$payment->sale >0)
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
                    @if(isset($payment->details))
                    @foreach($payment->details as $d)
                    <?php $t+=$d->price ?>
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$d->investigations->procedures->name}} <i
                                class="small">({{$d->investigations->type}})</i></td>
                        <td>{{$d->price}}</td>
                    </tr>

                    @foreach($d->visits->dispensing as $item)
                    @foreach($item->details as $drg)
                    <tr id="drg_{{$d->visits->id}}">
                        <td>{{$d->visits->id}}</td>
                        <td>
                            {{$drg->drug->name}}
                            <small>x {{$drg->quantity}}</small>
                            (drug)
                        </td>
                        <td>{{$drg->price*$drg->quantity}}</td>
                    </tr>
                    @endforeach
                    @endforeach

                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Bill</th>
                        <th></th>
                        <th>
                            {{$t}}
                        </th>
                    </tr>
                </tfoot>
            </table>
            @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment->sales->goodies as $item)
                    <tr>
                        <td>{{$item->products->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->discount}}</td>
                        <td>{{$item->price*$item->quantity-(($item->discount/100)*$item->price*$item->quantity)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Amount</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            {{$payment->sales->amount}}
                        </th>
                    </tr>
                </tfoot>
            </table>

            @endif
        </div>
        <div class="col-md-6">
            @if(!empty($payment->cash))
            <h4>Cash Payment</h4>
            Amount: Ksh {{$payment->cash->amount}}
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
            <strong>Total Amount Paid: Ksh {{$payment->total}}</strong>
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

<script type="text/javascript">

    $(function () {
        $('[id]').each(function () {
            //$('[id="' + this.id + '"]:gt(0)').remove();
        });

    });
</script>
@endsection
