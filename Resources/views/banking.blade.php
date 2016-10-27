<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Kiptoo Bravo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>


@extends('layouts.app')
@section('content_title','Banking')
@section('content_description','manage banking transactions')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Create</h3>
    </div>

    <div class="row">
        <div class="col-md-8">
            <center>
                <form method="post" action="{{route('finance.gl.banking')}}">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <label class="control-label col-md-4">Bank</label>
                    <div class="col-md-8">
                        <select required="" name="bank" id="bank" class="form-control">
                            <option value=""></option>
                            @foreach($data['banks'] as $b)
                            <option value="{{$b->id}}">{{$b->name}}</option>
                            @endforeach
                        </select>
                        <br>
                    </div>

                    <label class="control-label col-md-4">Account</label>
                    <div class="col-md-8">
                        <select required="" id="account" name="account" class="form-control">
                        </select>
                        <br>
                    </div>

                    <label class="control-label col-md-4">Type</label>
                    <div class="col-md-8">
                        <select required="" id="type" name="type" class="form-control">
                            <option value=""></option>
                            <option value="deposit">Deposit</option>
                            <option value="widthrawal">Widthrawal</option>
                        </select>
                        <br>
                    </div>

                    <label class="control-label col-md-4">Amount</label>
                    <div class="col-md-8">
                        <input type="text" required="" autocomplete="off" id="amount" name="amount" <?php if (isset($data['banking'])) { ?> value="{{$data['banking']->amount}}" <?php } ?> class="form-control">
                        <div id="response"></div>
                        <br>
                    </div>

                    <label class="control-label col-md-4">Mode</label>
                    <div class="col-md-8">
                        <select required="" id="mode" name="mode" class="form-control">
                            <option value=""></option>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                        </select>
                        <br>
                    </div>

                    <!--cheque -->
                    <div id="cheque">
                        <div class="element atStart">
                            <table class="table">
                                <tr>
                                    <td></td>
                                    <td width="20%">Ac Holder Name: </td>
                                    <td width="30%"><input name="ChequeName" type="text" size=20 maxlength=100/></td>
                                    <td width="20%">Date on Cheque Leaf: </td>
                                    <td width="30%"><input name="ChequeDate" type="text"  size=20 class="datepicker"/></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <!--
                                    <td width="20%">Amount: </td>
                                    <td width="30%"><input name="ChequeAmount" type="text" /></td>
                                    -->
                                    <td width="20%">Cheque Number: </td>
                                    <td width="30%"><input name="ChequeNumber" id="ChequeAmount" type="text" /></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td>Bank</td>
                                    <td><input name="Bank" type="text" /></td>
                                    <td>Branch:</td>
                                    <td><input type='text' name='Branch' value='' size=20 maxlength=100></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!--End of Cheque -->

                    <div class="pull-right">
                        <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                    </div><br>
                </form>
            </center>
        </div>
    </div>

    <div class="box-body">
        <div class="col-md-12">
            @if($data['bankings']->isEmpty())
            <p class="text-info"><i class="fa fa-info"></i> No bankings yet!</p>
            @else
            <table class="table table-responsive">
                <tbody>
                    @foreach($data['bankings'] as $b)
                    <tr>
                        <td>{{$b->id}}</td>
                        <td>{{$b->banks->name}}</td>
                        <td>{{$b->accounts->number}}</td>
                        <td>{{$b->amount}}</td>
                        <td>{{$b->type}}</td>
                        <td>{{$b->mode}}</td>
                        <td><a href="{{route('finance.gl.banking.trash',$b->id)}}">
                                <i class="fa fa-trash"></i>
                            </a></td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bank</th>
                        <th>Account</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Mode</th>

                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#mode").change(function () {
            $(this).find("option:selected").each(function () {
                if ($(this).attr("value") == "cheque") {
                    $("#cheque").show();
                } else {
                    $("#cheque").hide();
                }
            });
        }).change();

        $('#amount').keyup(function () {
            var amount = this.value;
            var type = $('#type').val();
            var account_type = 'bank';
            var account_id = $('#account').val();
            if (type === 'widthrawal') {
                //check bogus widthraw
                $.ajax({
                    type: 'get',
                    url: "{{route('api.finance.widthraw.bogus')}}",
                    data: {amount: amount, type: type, account_type: account_type, account_id: account_id},
                    success: function (response) {
                        $('#response').html(response);
                    }
                });//ajax
            }
        });

        function get_bank_accounts(that) {
            //initialize
            $("#account").empty();
            var options = "";

            $.ajax({
                url: "{{route('api.finance.accounts')}}",
                data: {'bank': that},
                success: function (data) {
                    $.each(data, function (key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';
                    });
                    console.log(options);
                    $("#account").html(options);
                }});
        }

        $("#bank").change(function () {
            get_bank_accounts(this.value);
        });

    });
</script>
@endsection
