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
        <div class="box-header with-border">
        <h2 class="box-title">{{config('practice.name')}}</h2>
    <h5><img style="width:100; height:auto;" src="{{realpath(base_path('/public/reciept.jpg'))}}"/></h5>    
    </div>
    <div class="box-body">
<table>
    <tbody>
        <tr>
        <td>
            <p style="font-size: 90%;">
            {{config('practice.building')?config('practice.building').',':''}}
            {{config('practice.street')?config('practice.street').',':''}}
            {{config('practice.town')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br>
        </p>

        </td>    


      <!--   <td>
            <img  src="{{realpath(base_path('/public/reciept.jpg'))}}" alt="Company Logo">
        

        </td> -->    
        </tr>
    </tbody>
</table>


        
    <table class="row">
        <div class="col-md-6 col-lg-6">
        <h2 class="box-title">RECIEPT</h2>
            <br>
            <strong>Name:</strong><span class="content"> {{$payment->patients?$payment->patients->full_name:'Walkin Patient'}}</span><br/>
            <strong>Date:</strong><span class="content"> {{(new Date($payment->created_at))->format('j/m/Y H:i')}}</span><br/>
            <strong>Receipt No: </strong><span>{{$payment->receipt}}</span><br/><br/>
        </div>


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
                            <td>{{$d->investigations->procedures->name}} <i
                                    class="small">({{$d->investigations->type}})</i></td>
                            <td>{{$d->price}}</td>
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
                                    <td>{{amount_after_discount($item->discount, $item->price*$item->quantity)}}</td>
                                </tr>
                                @endforeach
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align:right" colspan='2'>Amount Paid</th>
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
                            <td>{{$item->unit_cost}}</td>
                            <td>{{$item->discount}}</td>
                            <td>{{number_format(amount_after_discount($item->discount, $item->unit_cost*$item->quantity),2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th>
                                {{number_format(getAmount($payment->sales),2)}}
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