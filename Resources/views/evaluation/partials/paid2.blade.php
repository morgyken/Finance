@extends('finance::evaluation.workbench')
@section('tab')
<?php extract($data); ?>
<!-- Row start -->
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Fully Paid Invoices</h3>
            </div>
            <div class="panel-body">
                @if(!$payment->isEmpty())
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th style="text-align: center">Receipt Number</th>
                            <th>Cheque Number</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="response">
                        @foreach($payment as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->created_at}}</td>
                            <td style="text-align: center">00{{$item->id}}</td>
                            <td>{{$item->number}}</td>
                            <td>{{$item->amount}}</td>
                            <td>
                                <small>
                                    <a target="blank" href="{{route('finance.evaluation.ins.rcpt.print', $item->id)}}" class="btn btn-xs btn-primary">
                                        <i class="fa fa-print"></i> Print Receipt</a>
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <br>
                <p>No payments received yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Row end -->

@endsection


