<html>
<title>Patient Bill</title>
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
$clinic = \Ignite\Settings\Entities\Clinics::find(session('clinic'));
?>
<div class="box box-info">
    <h1 class="box-title">{{$clinic->practices->name}}</h1>
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
            <h1>Jambopay Bill</h1>
            <br>
        </div>
        <div class="col-md-12">
            <table>
                <tbody>
                <tr>
                    <td>Date</td>
                    <td>{{smart_date($bill->created_at)}}</td>
                </tr>
                <tr>
                    <td>Customer Name</td>
                    <td>{{$bill->patient->full_name}}</td>
                </tr>
                <tr>
                    <td>Bill Number</td>
                    <td>#{{$bill->BillNumber}}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>{{ number_format($bill->Amount,2) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr/>
        <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
        <br/><br/>
        Request by: <u>{{Auth::user()->profile->full_name}}</u>
    </div>
</div>
</html>