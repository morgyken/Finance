
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RECEIPT</title>

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

function amount_after_discount($discount, $amount) {
    try {
        $discounted = $amount - (($discount / 100) * $amount);
        return ceil($discounted);
    } catch (\Exception $e) {
        return $amount;
    }
}

function getAmount($sales) {
    $total = 0;
    foreach ($sales->goodies as $g) {
        $total += amount_after_discount($g->discount, $g->unit_cost * $g->quantity);
    }
    return $total;
}
?>

<style>
    body{
        font-weight: bold;
    }
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
        font-size: 90%;
    }

    /*table tr:nth-child(even){background-color: #f2f2f2}*/

    table tr:hover {background-color: #eee;}

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #eee;
        color: black;
        font-size: 90%;
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
        width:100%;
        height: auto;
    }
    td{
        font-size: 90%;
    }
    div #footer{
        font-size: 90%;
    }
    th{
        font-size: 90%;
    }
</style>
<div class="box box-info" style="text-align: center;">
        <div class="box-header with-border" style="text-align: center">
            <h1 class="box-title">{{get_clinic()->name?get_clinic()->name:config('practice.name')}}</h1>
            @include('finance::evaluation.print.logo')
        </div>
    <div class="box-body">
    @include('finance::evaluation.print.details')
    <table class="row">
        @include('finance::evaluation.print.patient_details')
    </table>
        <div class="col-md-6">
            @if(isset($payment))
            <?php if (!$payment->sale > 0) { ?>
                <table class="table table-striped" id="items">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Cost (Ksh.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($payment->details))
                        @foreach($payment->details as $d)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><small>{{$d->item_desc}}</small></td>
                            <td style="text-align: right">{{$d->price}}</td>
                        </tr>
                        @endforeach
                        @endif

                        <?php
                        if (isset($disp)) {
                            foreach ($disp as $key => $value) {
                                $__dispensing = \Ignite\Evaluation\Entities\DispensingDetails::whereId($value)->get();
                                ?>
                                @foreach($__dispensing as $item)
                                <tr>
                                    <td></td>
                                    <td>
                                        {{$item->drug->name}}
                                        <small>{{$item->price}} x {{$item->quantity}}</small>
                                        (drug)
                                        Discount (%) :{{$item->discount}}
                                    </td>
                                    <td style="text-align: right">{{amount_after_discount($item->discount, $item->price*$item->quantity)}}</td>
                                </tr>
                                @endforeach
                                <?php
                            }
                        }
                        ?>
                    </tbody>
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
                            <td>{{$item->unit_cost}}</td>
                            <td>{{$item->discount}}</td>
                            <td style="text-align: right">{{number_format(amount_after_discount($item->discount, $item->unit_cost*$item->quantity),2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: right">Total</td>
                            <td style="text-align: right">
                                {{number_format(getAmount($payment->sales),2)}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php } ?>
            @endif
        </div>
        <div class="col-md-6">

            <table style="text-align: right">
                <tr>
                    <th colspan="2">Payment Details</th>
                </tr>
                @if(!empty($payment->CashAmount))
                    <tr>
                        <td>Cash Payment:</td>
                        <td>{{number_format($payment->cash->amount,2)}}</td>
                    </tr>
                @endif

                @if(!empty($payment->mpesa))
                    <tr>
                        <td>Mpesa {{$payment->mpesa->reference?'('.$payment->mpesa->reference.')':''}}:</td>
                        <td>{{number_format($payment->mpesa->amount,2)}}</td>
                    </tr>
                @endif

                @if(!empty($payment->cheque))
                    <tr>
                        <td>Cheque Payment:</td>
                        <td>{{number_format($payment->cheque->amount,2)}}</td>
                    </tr>
                @endif

                @if(!empty($payment->card))
                    <tr>
                        <td>Card Payment:</td>
                        <td>{{number_format($payment->card->amount,2)}}</td>
                    </tr>
                @endif
                <tr style="text-align: right">
                    <th style="text-align: right">Total Amount Paid:</th>
                    <th style="text-align: right">Ksh. {{number_format($payment->total,2)}}</th>
                </tr>
            </table>
        </div>
    </div>
    <hr/>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    <br/><br/>
    Payment Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
</div>