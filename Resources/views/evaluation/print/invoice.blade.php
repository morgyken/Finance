<html>
    <title>INVOICE</title>
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
    <?php $bill_amount = 0; ?>
    <div class="box box-info">
        <h1 class="box-title">{{config('practice.name')}}</h1>
        <img style="width:100; height:auto; float: right" src="{{realpath(base_path('/public/logo.jpg'))}}"/>

        <div class="box-header with-border">
            <p style="font-size: 90%;">
                <?php try { ?>
                    {{config('practice.address')?"P.O Box". config('practice.address'):''}}, {{config('practice.town')}}.<br/>
                    Visit us: {{config('practice.building')?config('practice.building').',':''}}<br>
                    {{config('practice.street')?config('practice.street').',':''}}<br><br>
                    Email: {{config('practice.email')}}<br>
                    {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br>
                    <?php
                } catch (\Exception $e) {

                }
                ?>
            </p>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <h1>INVOICE</h1>
                <br>
                <div><span>DATE:</span> {{smart_date($bill->created_at)}}</div>
                <div><span>Patient:</span> {{$bill->visits->patients->full_name}}</div>
                <br/><br/>
            </div>
            <div class="col-md-6">

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th style="text-align:center">Number Performed</th>
                            <th style="text-align:center">Discount(%)</th>
                            <th>Cost (Ksh.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 0; ?>
                        @foreach($bill->visits->investigations as $item)
                        <?php
                        $bill_amount+=$item->amount > 0 ? $item->amount : $item->price;
                        ?>
                        <tr class="products">
                            <td>{{$n+=1}}</td>
                            <td style="text-align: left;">{{$item->procedures->name}}</td>
                            <td style="text-align:center">{{$item->quantity}}</td>
                            <td style="text-align:center">{{$item->discount}}</td>
                            <td>{{$item->amount>0?$item->amount:$item->price}}</td>
                        </tr>
                        @endforeach

                        @foreach($bill->visits->dispensing as $item)
                        @foreach($item->details as $item)
                        <?php
                        $bill_amount+=$item->price;
                        ?>
                        <tr>
                            <td>{{$n+=1}}</td>
                            <td>{{$item->drug->name}}</td>
                            <td style="text-align:center">{{$item->quantity}}</td>
                            <td style="text-align:center">{{$item->discount}}</td>
                            <td>{{$item->price}}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        <tr>
                            <td style="text-align: right;" colspan="4" class="grand total">TOTAL: </td>
                            <td class="grand total">{{ number_format($bill_amount,2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
            </div>
            <hr/>
            <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

            <br/><br/>
            Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
        </div>
</html>