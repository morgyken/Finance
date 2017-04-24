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
@section('content_title','Receive Payments')
@section('content_description','Receive payments from patients')

@section('content')
{!! Form::open(['id'=>'payForm','route'=>'finance.evaluation.pay.save','autocomplete'=>'off'])!!}
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-6">
            Patient Name: <strong>{{$patient->full_name}}</strong>
            <hr/>
            <h4>Select items for payment<span class="pull-right" id="total"></span></h4>
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
                                @if($item->is_paid)
                                <td>
                                    <input type="checkbox" disabled/>
                                </td>
                                <td>
                                    <div class="label label-success">Paid</div>
                                    {{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i> -
                                    Ksh {{$item->price}}
                                </td>
                                @else
                                <td>
                                    <?php try { ?>
                                        @if($item->removed_bills->isEmpty)
                                        <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
                                        @else
                                        <input disabled="" type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
                                        @endif
                                    <?php } catch (Exception $ex) { ?>
                                        <input type="checkbox" value="{{$item->id}}" name="item{{$item->id}}" />
                                    <?php } ?>
                                    <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}" />
                                <td>
                                    {{$item->procedures->name}}
                                    <i class="small">({{ucwords($item->type)}})</i> - Ksh <span class="topay">{{$item->price}}</span>



                                    <?php try { ?>
                                        @if($item->removed_bills->isEmpty)
                                        <a href="#" onclick="remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                                            <i class="fa fa-trash"></i>remove</a>
                                        @else
                                        <a href="#" onclick="#" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>bill has been removed</a>

                                        <a href="#" onclick="undo_remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-trash"></i>Undo</a>

                                        @endif
                                    <?php } catch (Exception $ex) { ?>
                                        <a href="#" onclick="remove_bill('investigation', <?php echo $item->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                                            <i class="fa fa-trash"></i>remove</a>
                                    <?php } ?>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            <!-- pharmacy queue -->
                            @foreach($visit->dispensing as $disp)
                        <input type="hidden" name="dispensing{{$disp->id}}" value="{{$disp->id}}">
                        @foreach($disp->details as $item)
                        <tr>
                            @if($item->status==1)
                            <td><input type="checkbox" disabled/></td>
                            <td>
                                <div class="label label-success">Paid</div>
                                {{$item->drug->name}} <i class="small">(dispensed drug)</i>
                                Ksh {{$item->price*$item->quantity}}
                            </td>
                            @else
                            <td>
                                <input type="hidden" name="disp[]" value="{{$item->id}}">
                                <input type="hidden" name="dispensing[]" value="{{$disp->id}}">

                                <input type="hidden" value="{{$visit->id}}" name="visits{{$item->id}}" />

                                <?php try { ?>
                                    @if($disp->removed_bills->isEmpty)
                                    <input type="checkbox" value="{{$item->id}}"name="dispense[]" />
                                    @else
                                    <input type="checkbox" disabled="" />
                                    @endif
                                <?php } catch (Exception $ex) { ?>
                                    <input type="checkbox" value="{{$item->id}}"name="dispense[]" />
                                <?php } ?>

                            </td>
                            <td>
                                {{$item->drug->name}}
                                <i class="small">
                                    (dispensed drug) - {{$item->price*$item->quantity}}</i>
                                <br>
                                <small>
                                    {{$item->discount}}% discount ({{($item->discount/100)*$item->price*$item->quantity}})</small>
                                Ksh <span class="topay">{{ceil($item->price*$item->quantity-($item->discount/100)*$item->price*$item->quantity)}}</span>

                                <?php try { ?>
                                    @if($disp->removed_bills->isEmpty)
                                    <a href="#" onclick="remove_bill('dispensing', <?php echo $disp->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                                        <i class="fa fa-trash"></i>remove</a>
                                    @else
                                    <a href="#" onclick="#" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i>bill has been removed</a>

                                    <a href="#" onclick="undo_remove_bill('dispensing', <?php echo $disp->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-primary btn-xs">
                                        <i class="fa fa-trash"></i>Undo</a>

                                    @endif
                                <?php } catch (Exception $ex) { ?>
                                    <a href="#" onclick="remove_bill('dispensing', <?php echo $disp->id; ?>, <?php echo $visit->id; ?>)" class="btn btn-danger btn-xs pull-right">
                                        <i class="fa fa-trash"></i>remove</a>
                                <?php } ?>


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
            @include('finance::evaluation.form')
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