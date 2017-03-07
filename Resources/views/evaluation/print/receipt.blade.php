<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
/*
  $payment = $data;
  //dd($payment);
  $patient = Ignite\Reception\Entities\Patients::find($payment->patient);
  $pays = paymentFor($payment); */
extract($data);
$t = 0;
?>

<style>
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
    }

    table tr:nth-child(even){background-color: #f2f2f2}

    table tr:hover {background-color: #ddd;}

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: white;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
    }
    .clear{
        clear: both;
    }
    img{
        width:50%;
        height: 50%/*auto*/;
        float: right;
    }
    td{
        font-size: 70%;
    }
    div #footer{
        font-size: 70%;
    }
    th{
        font-size: 80%;
    }
</style>
<div class="box box-info">
    <img src="{{realpath(base_path('/public/logo.png'))}}"/>
    <div class="box-header with-border">
        <h3 class="box-title">{{config('practice.name')}}</h3>
        {{config('practice.building')?config('practice.building').',':''}}
        {{config('practice.street')?config('practice.street').',':''}}
        {{config('practice.town')}}<br>
        {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br>

    </div>
    <div class="box-body">
        <div class="col-md-12">
            <br>
            <strong>Name:</strong><span class="content"> {{$payment->patients->full_name}}</span><br/>
            <strong>Date:</strong><span class="content"> {{(new Date($payment->created_at))->format('j/m/Y H:i')}}</span><br/>
            <strong>Receipt No: </strong><span>{{$payment->receipt}}</span><br/><br/>
        </div>
        <div class="col-md-6">
            @if(isset($payment))
            <?php if (!$payment->sale > 0) { ?>
                <table class="table table-striped" id="items">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Procedures/Drug</th>
                            <th>Cost (Ksh.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($payment->details))
                        @foreach($payment->details as $d)
                        <?php $t+=$d->price ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{substr($d->investigations->procedures->name,0,40)}} <i
                                    class="small">({{$d->investigations->type}})</i></td>

                            <td>{{$d->price}}</td>
                        </tr>

                        @foreach($d->visits->dispensing as $item)
                        @foreach($item->details as $drg)
                        <?php $t+=ceil($drg->price - ($drg->discount / 100 * $drg->price)); ?>
                        <tr id="drg_{{$d->visits->id}}">
                            <td>#</td>
                            <td>
                                {{$drg->drug->name}}
                                <small>x {{$drg->quantity}}</small>
                                (drug)
                            </td>
                            <td>{{ceil($drg->price-($drg->discount/100*$drg->price))}}</td>
                        </tr>
                        @endforeach
                        @endforeach

                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan='2'>Total Bill</th>
                            <th>{{$t}}</th>
                        </tr>
                        <tr>
                            <th colspan='2'>Amount Paid</th>
                            <th>{{$payment->total}}</th>
                        </tr>
                    </tfoot>
                </table>
            <?php } else { ?>


                <table class="table table-striped" id="items">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Discount(%)</th>
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
                            <td>{{ceil($item->price*$item->quantity-(($item->discount/100)*$item->price*$item->quantity))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total Amount</th>
                            <th>
                                {{$payment->sales->amount}}
                            </th>
                        </tr>
                    </tfoot>
                </table>


            <?php } ?>
            @endif
        </div>
        <div class="col-md-6">
            <h4>Payment Details</h4>
            @if(!empty($payment->CashAmount))
            Cash Payment: Ksh. {{$payment->cash->amount}}
            <br/>
            @endif
            @if(!empty($payment->MpesaAmount))
            MPESA Ref: {{$payment->mpesa->reference}}<br/>
            Amount: Ksh {{$payment->mpesa->amount}}
            <br/>
            @endif
            @if(!empty($payment->ChequeAmount))
            <h4>Cheque Payment</h4>
            Amount: Ksh {{$payment->cheque->amount}}
            <br/>
            @endif
            @if(!empty($payment->CardAmount))
            <h4>Card Payment</h4>
            Amount: Ksh {{$payment->card->amount}}
            <br/>
            @endif
        </div>
    </div>
    <hr/>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

    <br/><br/>
    Payment Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
</div>