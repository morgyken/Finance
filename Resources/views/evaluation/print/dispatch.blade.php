<html>
<title>DISPATCH</title>
<style>
    body {
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th {
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
        font-size: 90%;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2
    }

    table tr:hover {
        background-color: #ddd;
    }

    table th {
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: black;
        font-size: 90%;
    }

    .left {
        width: 60%;
        float: left;
    }

    .right {
        float: left;
        width: 40%;
    }

    .clear {
        clear: both;
    }

    img {
        width: 100%;
        height: auto;
    }

    td {
        font-size: 90%;
    }

    div #footer {
        font-size: 90%;
    }

    th {
        font-size: 90%;
    }
</style>
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
            <h1>DISPATCH</h1>
            <br>
            <div><span>DATE:</span> {{smart_date($dispatch->created_at)}}</div>
            <div><span>Company:</span> {{$dispatch->details->first()->invoice->scheme->companies->name}}</div>
            <br/><br/>
        </div>
        <div class="col-md-6">


            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th style="text-align: left;">Invoice</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php $amount = 0; ?>
                @foreach($dispatch->details as $item)
                    <?php $amount += $item->amount ?>
                    <tr class="products">
                        <td>{{$loop->iteration}}</td>
                        <td style="text-align: left;">{{$item->invoice->invoice_no}}</td>
                        <td>{{$item->amount}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td style="text-align: right;" colspan="2" class="grand total">Total Amount</td>
                    <td class="grand total"><u>{{ number_format($amount,2) }}</u></td>
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