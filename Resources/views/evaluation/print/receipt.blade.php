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
?>
<style>
    #items {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #items td, #items th {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
    }

    #items tr:nth-child(even){background-color: #f2f2f2}

    #items tr:hover {background-color: #ddd;}

    #items th {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: white;
    }
</style>
<div class="box box-info">
    <center><img width="80px" height="100px" src="{{realpath(base_path('/public/img/image.jpg'))}}"/></center>
    <div class="box-header with-border">
        <center><h3 class="box-title">{{config('practice.name')}}</h3></center>
        <h5><center>{{get_clinic_name(config('practice.clinic'))}} Clinic</center></h5>
        <h6><center>P.O BOX {{config('practice.address')}}, {{config('practice.town')}}</center></h6>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <strong>Name:</strong><span class="content"> {{$payment->patients->full_name}}</span><br/>
            <strong>Date:</strong><span class="content"> {{(new Date($payment->created_at))->format('j/m/Y H:i')}}</span><br/>
            <strong>Receipt No: </strong><span>{{$payment->receipt}}</span><br/><br/>

        </div>
        <div class="col-md-6">
            @if(isset($payment))
            <table class="table table-striped" id="items">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Procedures/Drug</th>
                        <th>Cost (Ksh.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment->details as $pay)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$pay->investigations->procedures->name}}
                            <i class="small">({{$pay->investigations->type}})</i></td>
                        <td>{{$pay->price}}</td>
                    </tr>
                    @endforeach
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
                        <th>Total</th>
                        <th></th>
                        <th>{{$payment->details->sum('price')+$disp_amount}}</th>
                    </tr>
                </tfoot>
            </table>
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
            <strong>Total Paid: {{$payment->total}}</strong>
        </div>
    </div>
    <hr/>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

    <br/><br/>
    Payment Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
</div>