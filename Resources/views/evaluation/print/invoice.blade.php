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
                    <th style="text-align:right">Unit Price</th>
                    <th style="text-align:right">Units</th>
                    <th style="text-align:right">Cost (Ksh.)</th>
                </tr>
                </thead>
                <tbody>
                <?php $n = 0;  $TOTAL = 0; ?>
                @foreach($bill->investigations as $item)
                    <tr class="products">
                        <td>{{$n+=1}}</td>
                        <td>{{$item->procedures->name}}</td>
                        <td style="text-align:right">{{number_format($item->price,2)}}</td>
                        <td style="text-align:right">{{$item->quantity}}</td>
                        <td style="text-align:right">{{number_format($item->amount,2)}}</td>
                    </tr>
                    @php
                        $TOTAL+=$item->amount;
                    @endphp
                @endforeach
                @foreach($bill->prescriptions as $item)
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$item->prescription->drugs->name}}</td>
                        <td style="text-align:right">{{number_format($item->price,2)}}</td>
                        <td style="text-align:right">{{$item->quantity}}</td>
                        <td style="text-align:right">{{number_format($item->total,2)}}</td>
                    </tr>
                    @php
                        $TOTAL+=$item->total;
                    @endphp
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td style="text-align: right;" colspan="4" class="grand total">TOTAL:</td>
                    <td class="grand total" style="text-align:right">{{ number_format($TOTAL,2) }}</td>
                </tr>
                @if($bill->copaid)
                    <tr>
                        <th style="text-align: right;" colspan="4" class="grand total">Copay:</th>
                        <th style="text-align: right">{{ number_format($bill->copaid->amount,2) }}</th>
                    </tr>
                    <?php $TOTAL -= $bill->copaid->amount; ?>
                    <tr>
                        <th style="text-align: right;" colspan="4" class="grand total">Billed Amount:
                        </th>
                        <th style="text-align: right">{{ number_format($TOTAL,2) }}</th>
                    </tr> @endif
                </tfoot>
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