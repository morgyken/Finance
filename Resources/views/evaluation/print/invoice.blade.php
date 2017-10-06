<html>
<title>INVOICE</title>
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
<?php $bill_amount = 0;
$clinic = \Ignite\Settings\Entities\Clinics::find($bill->visits->clinic);?>
<div class="box box-info">
    <h1 class="box-title">{{$clinic->name}}</h1>
    <?php
    $logo = get_logo();
    ?>
    @if($logo)
        <img style="width:100; height:auto; float: right" src="{{realpath(base_path(get_logo()))}}"/>
    @endif
    <div class="box-header with-border">
        <p style="font-size: 90%; <?php if (!isset($a4)) { ?> text-align: center<?php } ?>">
            P.O Box {{$clinic->address}}, {{$clinic->town}}.<br/>
            Visit us: {{$clinic->location}}<br>
            {{$clinic->street}}<br>
            Email: {{$clinic->email}}<br>
            Call Us: {{$clinic->mobile}}
            <br/> {{$clinic->telephone?$clinic->telephone:''}}<br>
        </p>
    </div>
    <div class="box-body">
        <div class="col-md-12" style="text-align: center;">
            <h1>INVOICE</h1>
            <br>
            <div><span>DATE:</span> {{smart_date($bill->created_at)}}</div>
            <div><span>Patient:</span> {{$bill->visits->patients->full_name}}</div>
            <div><span>Patient No:</span> {{m_setting('reception.patient_id_abr')}}{{$bill->visits->patients->id}}</div>
            <div><span>Invoice Number:</span> #{{$bill->invoice_no}}</div>
            <br/><br/>
        </div>
        <div class="col-md-6">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th  style="text-align:right">Unit Price</th>
                    <th  style="text-align:right">Units</th>
                    <th  style="text-align:right">Cost (Ksh.)</th>
                </tr>
                </thead>
                <tbody>
                <?php $n = 0;  $TOTAL = 0; ?>
                @foreach($bill->visits->investigations as $item)
                    <tr class="products">
                        <td>{{$n+=1}}</td>
                        <td  style="text-align:right">{{$item->procedures->name}}</td>
                        <td  style="text-align:right">{{number_format($item->price,2)}}</td>
                        <td  style="text-align:right">{{$item->quantity}}</td>
                        <td  style="text-align:right">{{number_format($item->amount,2)}}</td>
                    </tr>
                    @php
                        $TOTAL+=$item->amount;
                    @endphp
                @endforeach
                @foreach($bill->visits->prescriptions as $item)
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$item->drugs->name}}</td>
                        <td style="text-align:right">{{number_format($item->payment->price,2)}}</td>
                        <td style="text-align:right">{{$item->payment->quantity}}</td>
                        <td style="text-align:right">{{number_format($item->payment->total,2)}}</td>
                    </tr>
                    @php
                        $TOTAL+=$item->payment->total;
                    @endphp
                @endforeach
                <tr>
                    <td style="text-align: right;" colspan="4" class="grand total">TOTAL:</td>
                    <td class="grand total">{{ number_format($TOTAL,2) }}</td>
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
</div>
</html>