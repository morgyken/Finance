<?php extract($data);?>
@extends('layouts.app')
@section('content_title','Billing Management')
@section('content_description','Manage items to invoice')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Manage items to invoice</h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                {{Form::open(['route'=>['finance.evaluation.bill',$visit->id,],'id'=>'inv'])}}
                <table class="table table-condensed" id="panda">
                    <tbody>
                    @foreach($visit->investigations as $item)
                        <?php
                        $is_paid = $item->invoiced;
                        $in_cash = transferred2cash($item->id);
                        if ($is_paid || $in_cash) {
                            continue;
                        }
                        ?>
                        <tr id="p{{$item->id}}">
                            <td><input type="checkbox" name="procedures.p{{$item->id}}" vprice="{{$item->amount}}"></td>
                            <td>{{$item->procedures->name}}</td>
                            <td>{{ucfirst($item->type)}}</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->price,2)}}</td>
                            <td style="text-align: right">{{$item->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->amount,2)}}</td>
                            <td>
                                <button class="btn btn-xs btn-danger cancel" type="button" xs="p{{$item->id}}">
                                    <i class="fa fa-ban" title="Cancel"></i></button>
                            </td>
                        </tr>
                    @endforeach

                    @foreach($visit->prescriptions as $item)
                        <?php
                        $is_paid = $item->is_paid;
                        $in_cash = transferred2cash($item->id, true);
                        if ($item->is_paid || $in_cash || !$item->payment->complete) {
                            continue;
                        }
                        ?>
                        <tr id="d{{$item->id}}">
                            <td>
                                <input type="checkbox" name="drugs.d{{$item->id}}" vprice="{{$item->payment->total}}"/>
                            </td>
                            <td>{{$item->drugs->name}}</td>
                            <td>Drug</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->payment->price,2)}}</td>
                            <td style="text-align: right">{{$item->payment->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->payment->total,2)}}</td>
                            <td>
                                <button class="btn btn-xs btn-danger cancel" type="button" xs="d{{$item->id}}">
                                    <i class="fa fa-ban"
                                       title="Cancel"></i></button>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>?</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="text-align: right">Price</th>
                        <th style="text-align: right">Units</th>
                        <th style="text-align: right">Amount</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Total:</th>
                        <th style="text-align: right"><span id="thesum">0.00</span></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" id="swap2cash">
                        <i class="fa fa-exchange"></i> Change to Cash
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-money"></i> Bill Selected Items
                    </button>
                </div>
                <input type="hidden" name="total" id="amount_send"/>
                {{Form::close()}}
            </div>
        </div>

    </div>
    <script>
        $(function () {
            var MY_TOTAL = 0;
            $('#panda').find('input').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            $('#panda').find('input').on('ifChanged', function () {
                if ($(this).is(':checked')) {
                    MY_TOTAL += parseInt($(this).attr('vprice'));
                } else {
                    MY_TOTAL -= parseInt($(this).attr('vprice'));
                }
                $('#thesum').html(MY_TOTAL.toFixed(2));
                $('#amount_send').val(MY_TOTAL);
            });
            $(document).on('click', '.cancel', function () {
                $('tr#' + $(this).attr('xs')).remove();
            });
            $('#swap2cash').click(function () {
                $url = "{{route('finance.evaluation.swap.mode',$visit->id)}}";
                $('form#inv').attr('action', $url).submit();
            });
        });
    </script>
@endsection