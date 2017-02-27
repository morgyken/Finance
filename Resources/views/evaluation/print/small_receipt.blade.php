<!doctype html>
<?php
extract($data);
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Receipt:{{$payment->receipt}}</title>

        <style>
            .invoice-box{
                max-width:800px;
                margin:auto;
                border:1px solid #eee;
                box-shadow:0 0 10px rgba(0, 0, 0, .15);
                font-size:16px;
                line-height:24px;
                font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color:#555;
            }

            .invoice-box table{
                width:100%;
                text-align:left;
            }

            .invoice-box table td{
                padding:5px;
                vertical-align:top;
            }

            .invoice-box table tr td:nth-child(2){
                text-align:right;
            }

            .invoice-box table tr.top table td{
                padding-bottom:20px;
            }

            .invoice-box table tr.top table td.title{
                font-size:45px;
                line-height:45px;
                color:#333;
            }

            .invoice-box table tr.information table td{
                padding-bottom:0px;
            }

            .invoice-box table tr.heading td{
                background:#eee;
                border-bottom:1px solid #ddd;
                font-weight:bold;
            }



            .invoice-box table tr.item td{
                border-bottom:1px solid #eee;
            }

            .invoice-box table tr.item.last td{
                border-bottom:none;
            }

            .invoice-box table tr.total td:nth-child(2){
                border-top:2px solid #eee;
                font-weight:bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td{
                    width:100%;
                    display:block;
                    text-align:center;
                }

                .invoice-box table tr.information table td{
                    width:100%;
                    display:block;
                    text-align:center;
                }
            }
        </style>
    </head>

    <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td colspan="3">
                        <h2 style="text-align:center">{{config('practice.name')}}.</h2>
                    </td>
                </tr>
                <tr class="information">
                    <td colspan="3">
                        <table>
                            <tr>
                                <td>
                                    {{config('practice.building')}}.<br>
                                    {{config('practice.street')?config('practice.street').',':''}}
                                    {{config('practice.town')}}<br>
                                    {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                @if(isset($payment))
                <tr class="details">
                    <td colspan="3">
                        <strong>Name:</strong><span class="content"> {{$payment->patients->full_name}}</span><br/>
                        Receipt#: {{$payment->receipt}}<br>
                        Date: {{(new Date($payment->created_at))->format('j/m/Y H:i')}}
                    </td>
                </tr>
                <?php if (!$payment->sale > 0) { ?>
                    <tr>
                        <th>#</th>
                        <th>Procedures/Drug</th>
                        <th>Cost (Ksh.)</th>
                    </tr>

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
                        <?php $pos_amount+=$item->amount ?>
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
                    <tr>
                        <td colspan="2">Total Bill</td>
                        <td>{{$inv_amount+$disp_amount+$pos_amount}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Amount Paid</td>
                        <td>{{$payment->total}}</td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                    @foreach($payment->sales->goodies as $item)
                    <tr>
                        <td>{{$item->products->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->price*$item->quantity}}</td>
                    </tr>
                    @endforeach
                    <tr class="heading">
                        <td colspan="3">Total:</td>

                        <td>
                            {{number_format($payment->sales->amount,2)}}
                        </td>
                    </tr>
                <?php } ?>

                <tr class="details">
                    <td colspan="3">
                        <br>
                        Payment Confirmed By: <u>{{Auth::user()->profile->full_name}}</u>
                    </td>
                </tr>
                @endif
            </table>

        </div>
    </body>
</html>