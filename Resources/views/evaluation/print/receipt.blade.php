<?php
extract($data);
$clinic = get_clinic();
$t = 0;
$thermal = null;
function amount_after_discount($discount, $amount)
{
    try {
        $discounted = $amount - (($discount / 100) * $amount);
        return ceil($discounted);
    } catch (\Exception $e) {
        return $amount;
    }
}

function getAmount($sales)
{
    $total = 0;
    foreach ($sales->goodies as $g) {
        $total += amount_after_discount($g->discount, $g->unit_cost * $g->quantity);
    }
    return $total;
}
?>
<html>
<title>RECEIPT</title>
<body onload="window.print()">
<style>
    body {
        /*font-weight: bold;*/
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th {
        border: 1px solid #eee;
        text-align: left;
        padding: 1px;
        /*font-size: 90%;*/
    }

    /*table tr:nth-child(even){background-color: #f2f2f2}*/

    table tr:hover {
        background-color: #ddd;
    }

    table th {
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: #eee;
        color: black;
        /*font-size: 90%;*/
    }

    /*.left{*/
    /*width: 60%;*/
    /*float: left;*/
    /*}*/
    /*.right{*/
    /*float: left;*/
    /*width: 40%;*/
    /*}*/
    /*.clear{*/
    /*clear: both;*/
    /*}*/
    /*img{*/
    /*width:100%;*/
    /*height: auto;*/
    /*}*/
    /*td{*/
    /*font-size: 90%;*/
    /*}*/
    /*div #footer{*/
    /*font-size: 90%;*/
    /*}*/
    /*th{*/
    /*font-size: 90%;*/
    /*}*/
</style>
<div class="box box-info">
    <?php if (!isset($a4)) { ?>
    <center>
        <h4 class="box-title">{{get_clinic()->name?get_clinic()->name:config('practice.name')}}</h4>
    </center>
    <?php } else { ?>
    <h4 class="box-title">{{get_clinic()->name?get_clinic()->name:config('practice.name')}}</h4>
    <?php } ?>
    @include('finance::evaluation.print.logo')
    <br/>
    @include('finance::evaluation.print.details')
    <div class="box-body">
        @include('finance::evaluation.print.patient_details')
        <div class="col-md-6">
            @if(!$invoice_mode)
                @include('finance::evaluation.payment.details.main_mode')
            @else
                @include('finance::evaluation.payment.details.invoice_mode')
            @endif
        </div>
        <div class="col-md-6">
            <table style="text-align: right">
                <tr>
                    <th colspan="2">Payment Details</th>
                </tr>
                @if(!empty($payment->CashAmount))
                    <tr>
                        <td>Cash:</td>
                        <td>{{number_format($payment->cash->amount,2)}}</td>
                    </tr>
                @endif
                @if(!empty($payment->jambopay))
                    <tr>
                        <td>Jambopay:</td>
                        <td>{{number_format($payment->jambopay->Amount,2)}}</td>
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
                        <td>Cheque:</td>
                        <td>{{number_format($payment->cheque->amount,2)}}</td>
                    </tr>
                @endif

                @if(!empty($payment->card))
                    <tr>
                        <td>Card:</td>
                        <td>{{number_format($payment->card->amount,2)}}</td>
                    </tr>
                @endif
                <tr style="text-align: right">
                    <th style="text-align: right">Total:</th>
                    <th style="text-align: right">Ksh. {{number_format($payment->total,2)}}</th>
                </tr>
            </table>
        </div>
    </div>
    <hr/>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    <br/><br/>
    Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
    <br/><br/>
    <table>
        <tr>
            <td style="text-align: right; font-weight: bold"></td>
        </tr>
    </table>
</div>
</body>
</html>