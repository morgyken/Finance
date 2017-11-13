<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 11/2/17
 * Time: 1:45 PM
 */
extract($data);
$patient_schemes = get_patient_schemes($visit->patients->id);
?>
@extends('layouts.app')
@section('content_title','Billing Management')
@section('content_description','Transfer Bills to Another Insurance Company')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Transfer Bills to Another Insurance Company <code>Patient: {{$visit->patients->full_name}}</code></h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                {{Form::open(['route'=>['finance.evaluation.split',$visit->id],'id'=>'inv'])}}
                <table class="table table-condensed" id="panda">
                    <tbody>
                    @foreach($visit->investigations as $item)
                        <?php
                        $is_paid = $item->invoiced;
                        $in_cash = transferred2cash($item->id);
                        $split = split_to_schemex($item->id);
                        if ($is_paid || $in_cash ||$split) {
                            continue;
                        }
                        ?>
                        <tr id="p{{$item->id}}">
                            <td><input type="checkbox" name="investigation{{$item->id}}" vprice="{{$item->amount}}"></td>
                            <td>{{$item->procedures->name}}</td>
                            <td>{{ucfirst($item->type)}}</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->price,2)}}</td>
                            <td style="text-align: right">{{$item->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->amount,2)}}</td>
                        </tr>
                    @endforeach

                    @foreach($visit->prescriptions as $item)
                        <?php
                        $is_paid = $item->is_paid;
                        $in_cash = transferred2cash($item->id, true);
                        $split = split_to_schemex($item->id,true);

                        if ($item->is_paid || $in_cash || $split || !$item->payment->complete) {
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
                        </tr>

                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="text-align: right">Price</th>
                        <th style="text-align: right">Units</th>
                        <th style="text-align: right">Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Total:</th>
                        <th style="text-align: right"><span id="thesum">0.00</span></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="4"></th>
                        <th colspan="3">
                            <div class="pull-right form-group {{ $errors->has('scheme') ? ' has-error' : '' }}" id="schemes">
                                {!! Form::label('scheme', 'Transfer to:',['class'=>'control-label col-md-4']) !!}
                                <div class="col-md-8">
                                    <select class="form-control" id="scheme" name="scheme">
                                        <option selected="selected" value="">Choose...</option>
                                        @foreach($patient_schemes as $scheme)
                                            <option value="{{$scheme->id}}">{{$scheme->schemes->companies->name}}
                                                - {{$scheme->schemes->name}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('scheme', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <div class="form-group">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary" id="swap2cash">
                        <i class="fa fa-exchange"></i> Split
                    </button>
                </div>
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
        });
    </script>
@endsection