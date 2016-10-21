
<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>
@extends('layouts.app')
@section('content_title','Receive bill payment')
@section('content_description','Save bill payment')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Receive payment</h3>
    </div>

    <style>
        label{
            text-align: right;
        }
    </style>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="{{route('finance.bill.pay.save')}}">
                    <input type="hidden" class="form-horizontal" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="hidden" name="id" value="{{$data['bill']->id}}">
                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Mode</label>
                        <div class="col-xs-8">
                            <select required="" id="mode" name="mode" class="form-control">
                                <option value=""></option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                    <!--cheque -->
                    <div id="cheque">

                        <div class="form-group row">
                            <label class="col-xs-4 col-form-label"></label>
                            <div class="col-xs-4">
                                <input name="ChequeName" placeholder="Ac Holder Name" type="text" size=20 maxlength=100/>
                            </div>
                            <div class="col-xs-4">
                                <input name="ChequeDate" placeholder="Date on Cheque Leaf:" type="text"  size=20 class="datepicker"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xs-4 col-form-label"></label>
                            <div class="col-xs-4">
                                <input name="ChequeNumber" placeholder="Cheque Number:" id="" type="text" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xs-4 col-form-label"></label>
                            <div class="col-xs-4">
                                <input name="Bank" placeholder="Bank" type="text" />
                            </div>
                            <div class="col-xs-4">
                                <input type='text' placeholder="Branch" name='Branch' value='' size=20 maxlength=100>
                            </div>
                        </div>
                    </div>
                    <!--End of Cheque -->
                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Amount</label>
                        <div class="col-xs-8">
                            <input type="text" id="amount" value="{{$data['amnt']}}" class="form-control" name = "amount" title = "Enter Amount">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label"></label>
                        <div class="col-xs-8">
                            <button class="form-control btn-primary">Proceed</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#mode").change(function () {
        $(this).find("option:selected").each(function () {
            if ($(this).attr("value") == "cheque") {
                $("#cheque").show();
            } else {
                $("#cheque").hide();
            }
        });
    }).change();
</script>
@endsection
