<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$visit = $data['visit'];
?>
@extends('layouts.app')
@section('content_title','Receive Payments')
@section('content_description','Receive payments from patients')

@section('content')
    {!! Form::open(['id'=>'payForm','route'=>'finance.evaluation.ins.save.pay','autocomplete'=>'off'])!!}
    <input type="hidden" name="visit" value="{{$visit->id}}">
    <div class="box box-info">
        <div class="box-body">
            <div class="col-md-6">
                <dt>Patient Name:</dt>
                <dd>{{$visit->patients->full_name}}
                </dd>

                <hr/>
                <h4>Bill Details<span class="pull-right" id="total"></span></h4>
                <div class="accordion">
                    <h3>{{(new Date($visit->created_at))->format('dS M y g:i a')}} -
                        Clinic {{$visit->clinics->name}}</h3>
                    <div id="visit{{$visit->id}}">
                        <table class="table table-condensed" id="paymentsTable">
                            <tbody>
                            @foreach($visit->investigations as $item)
                                <tr>
                                    @if($item->is_paid)
                                        <td>
                                            <div class="label label-success">Paid</div>
                                            {{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i>
                                            -
                                            Ksh {{$item->price}}
                                        </td>
                                    @else
                                        <td><input type="checkbox" value="{{$item->id}}"
                                                   name="item{{$item->id}}"/>
                                        <td>{{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i>
                                            -
                                            Ksh <span class="topay">{{$item->price}}</span></td>
                                    @endif
                                </tr>
                            @endforeach

                            <?php
                            $n = 0;
                            $dispensing = $visit->dispensing;
                            ?>
                            @foreach($dispensing as $item)
                                @foreach($item->details as $item)
                                    <tr>
                                        <td>{{$item->drugs->name}}</td>
                                        <td>x {{$item->quantity}} </td>
                                        <td>Ksh <span class="topay">{{$item->amount}}</span></td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                        Unpaid Amount: {{$visit->unpaidamount}}/=
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @include('finance::evaluation.form')
            </div>
        </div>
    </div>
    {!! Form::close()!!}
    <script src="{{m_asset('evaluation:js/payments.js')}}"></script>
    <style type="text/css">
        #visits tbody tr.highlight {
            background-color: #B0BED9;
        }
    </style>
@endsection