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
            <h1>INVOICE</h1><br>
            <div><span>INVOICE NO:</span> 0{{$invoice->id}}</div><br>
            <div><span>DATE:</span> {{smart_date($invoice->created_at)}}</div>
            <div><span>PATIENT:</span> {{$invoice->patient->full_name}}</div>
            <br/><br/>
        </div>
        <div class="col-md-6">
            @if(!empty($invoice))
                <table class="table table-condensed table-responsive">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Service Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice->details as $item)
                        <tr id="invoice{{$item->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->item_name}}</td>
                            <td>{{number_format($item->amount,2)}}</td>
                            <td>{{$item->service_date}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <p>
                                <strong>Total Amount:</strong> {{number_format($invoice->total,2)}}
                            </p>
                            <p>
                                <strong>Amount Paid:</strong>
                                {{number_format(get_patient_invoice_paid_amount($invoice->id),2)}}
                            </p>
                            <p>
                                <strong>Amount Pending:</strong>
                                {{number_format(get_patient_invoice_pending_amount($invoice->id),2)}}
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            @else
                <p>Strange! the invoice has no items</p>
            @endif
        </div>
        <div class="col-md-6">
        </div>
        <hr/>
        <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

        <br/><br/>
        Issued by: <u>{{Auth::user()->profile->full_name}}</u>
    </div>
</html>