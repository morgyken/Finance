<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$__visits = $patient->visits;
?>
@extends('layouts.app')
@section('content_title','Invoice Patient')
@section('content_description','Create invoice for billed items')

@section('content')
{!! Form::open(['id'=>'payForm','autocomplete'=>'off'])!!}
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-6">
            Patient Name: <strong>{{$patient->full_name}}</strong>
            <hr/>
            <h4>Select items to proceed</h4>
            @if(!empty($__visits))
            <div class="accordion">
                @foreach($__visits as $visit)
                <h3>{{(new Date($visit->created_at))->format('dS M y g:i a')}} -
                    Clinic {{$visit->clinics->name}}</h3>
                <div id="visit{{$visit->id}}">
                    <table class="table table-condensed" id="paymentsTable">
                        <tbody>
                            @foreach($visit->investigations as $item)
                            <tr>
                                @if($item->is_paid || $item->invoiced)
                                <td>
                                    <input type="checkbox" disabled/>
                                </td>
                                <td>
                                    @if($item->is_paid)
                                    <div class="label label-success">Paid</div>
                                    @elseif($item->invoiced)
                                    <div class="label label-warning">Invoiced</div>
                                    @endif
                                    {{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i> -
                                    Ksh {{$item->amount>0?$item->amount:$item->price}}
                                </td>
                                @else
                                <td>
                                    <input type="checkbox" value="{{$item->procedures->id}}" name="item{{$item->id}}" />
                                    <input type="hidden" value="{{$item->id}}" name="investigation{{$item->id}}" />
                                    <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}" />

                                    <input type="hidden" value="{{$item->procedures->name}}" name="inv_name{{$item->id}}" />
                                    <input type="hidden" value="procedure" name="inv_type{{$item->id}}" />
                                    <input type="hidden" value="{{$item->amount>0?$item->amount:$item->price}}" name="inv_amount{{$item->id}}" />
                                    <input type="hidden" value="{{$item->created_at}}" name="service_date{{$item->id}}" />
                                <td>
                                    {{$item->procedures->name}}
                                    <i class="small">({{ucwords($item->type)}})</i> - Ksh <span class="topay">{{$item->amount>0?$item->amount:$item->price}}</span>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            <!-- pharmacy queue -->
                            @foreach($visit->dispensing as $disp)
                        <input type="hidden" name="dispensing{{$disp->id}}" value="{{$disp->id}}">
                        @foreach($disp->details as $item)
                        <tr>
                            @if($item->status==1 || $item->invoiced)
                            <td><input type="checkbox" disabled/></td>
                            <td>
                                @if($item->status==1)
                                <div class="label label-success">Paid</div>
                                @elseif($item->invoiced)
                                <div class="label label-warning">Invoiced</div>
                                @endif
                                {{$item->drug->name}} <i class="small">(dispensed drug)</i>
                                Ksh {{$item->price*$item->quantity}}
                            </td>
                            @else
                            <td>
                                <input type="hidden" name="disp[]" value="{{$item->id}}">
                                <input type="hidden" name="dispensing[]" value="{{$disp->id}}">
                                <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}" />

                                <input type="checkbox" value="{{$item->drug->id}}" name="item{{$item->id}}" />
                                <input type="hidden" value="{{$item->drug->name}}" name="inv_name{{$item->id}}" />
                                <input type="hidden" value="drug dispensed" name="inv_type{{$item->id}}" />
                                <input type="hidden" value="{{ceil($item->price*$item->quantity-($item->discount/100)*$item->price*$item->quantity)}}" name="inv_amount{{$item->id}}" />
                                <input type="hidden" value="{{$item->created_at}}" name="service_date{{$item->id}}" />
                            </td>
                            <td>
                                {{$item->drug->name}}
                                <i class="small">
                                    (dispensed drug) - {{$item->price*$item->quantity}}</i>
                                <br>
                                <small>
                                    {{$item->discount}}% discount ({{($item->discount/100)*$item->price*$item->quantity}})</small>
                                Ksh <span class="topay">{{ceil($item->price*$item->quantity-($item->discount/100)*$item->price*$item->quantity)}}</span>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach

            </div>
            @else
            <div class="alert alert-info">
                <i class="fa fa-info"></i> This patient has not been billed.
                Click <a href="{{route('finance.receive_payments')}}">here </a> for a list of patient with
                pending bills.
            </div>
            @endif
        </div>
        <div class="col-md-6">
            @include('finance::evaluation.invoice_form')
        </div>
    </div>
</div>
{!! Form::close()!!}


<script type="text/javascript">
    function remove_bill(type, id, visit) {
        $.ajax({
            type: 'get',
            url: "{{route('api.finance.evaluation.bill.remove')}}",
            data: {type: type, id: id, visit: visit},
            success: function (response) {
                location.reload();
            }
        }); //ajax
    }

    function undo_remove_bill(type, id, visit) {
        $.ajax({
            type: 'get',
            url: "{{route('api.finance.evaluation.bill.undoremove')}}",
            data: {type: type, id: id, visit: visit},
            success: function (response) {
                location.reload();
            }
        }); //ajax
    }
</script>

<script src="{{m_asset('evaluation:js/payments.min.js')}}"></script>
<style type="text/css">
    #visits tbody tr.highlight {
        background-color: #B0BED9;
    }
</style>
@endsection