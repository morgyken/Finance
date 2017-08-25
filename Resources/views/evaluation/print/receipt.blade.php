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
$clinic =get_clinic();
$t = 0;
$thermal = null;

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
<html>
    <title>RECEIPT</title>
    <style>
        body{
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
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

        table tr:nth-child(even){background-color: #f2f2f2}

        table tr:hover {background-color: #ddd;}

        table th{
            padding-top: 1px;
            padding-bottom: 1px;
            background-color: /*#4CAF50*/ #BBBBBB;
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
    <div class="box box-info">
        <?php if (!isset($a4)) { ?>
            <center>
                <h1 class="box-title">{{get_clinic()->name?get_clinic()->name:config('practice.name')}}</h1>
            </center>
        <?php } else { ?>
            <h1 class="box-title">{{get_clinic()->name?get_clinic()->name:config('practice.name')}}</h1>
        <?php } ?>

        @if(isset($a4))
                <?php try{ ?>
                <img style="width:100; height:auto; float: right" src="{{realpath(base_path(get_logo()))}}"/>
                <?php
                }catch(\Exception $e){
                    ?>
                    <img style="width:100; height:auto; float: right" src=""/>
                <?php
                }
                ?>
        @else
        <center>
            <?php try{ ?>
            <img style="width:100; height:auto; float: right" src="{{realpath(base_path(get_logo()))}}"/>
            <?php
            }catch(\Exception $e){
                ?>
                <img style="width:100; height:auto; float: right" src=""/>
                <?php
            }
            ?>
        </center>
        @endif
        <div class="box-header with-border">
            <p style="font-size: 90%; <?php if (!isset($a4)) { ?> text-align: center<?php } ?>">
                @if($clinic->address !==''||$clinic->town!=='')
                P.O Box {{$clinic->address}}, {{$clinic->town}}.<br/>
                Visit us: {{$clinic->location}}<br>
                {{$clinic->street}}<br>
                Email: {{$clinic->email}}<br>
                Call Us: {{$clinic->mobile}}
                <br/> {{$clinic->telephone?"Or: ".$clinic->telephone:''}}<br>
                @else
                P.O Box {{config('practice.address')}}, {{config('practice.town')}}.<br/>
                Visit us: {{config('practice.building')?config('practice.building').',':''}}<br>
                {{config('practice.street')?config('practice.street').',':''}}<br><br>
                Email: {{config('practice.email')}}<br>
                {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br>
                @endif
            </p>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <?php if (!isset($a4)) { ?>
                    <center>
                        <h1>RECEIPT</h1>
                    </center>
                <?php } else { ?>
                    <h1>RECEIPT</h1>
                <?php } ?>
                <br>
                <strong>Name:</strong><span class="content"> {{$payment->patients?$payment->patients->full_name:'Walkin Patient'}}</span><br/>
                <strong>Date:</strong><span class="content"> {{(new Date($payment->created_at))->format('j/m/Y H:i')}}</span><br/>
                <strong>Receipt No: </strong><span>{{$payment->receipt}}</span><br/><br/>
            </div>
            <div class="col-md-6">
                @if(!$invoice_mode)
                @include('finance::evaluation.payment.details.main_mode')
                @else
                @include('finance::evaluation.payment.details.invoice_mode')
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
        Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
        <br/><br/>
        <table>
            <tr>
                <td style="text-align: right; font-weight: bold">
                </td>
            </tr>
        </table>
    </div>
</html>