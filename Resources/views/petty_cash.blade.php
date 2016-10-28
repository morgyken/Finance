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
@section('content_title','Petty Cash')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">

        <div class="row">

            <?php
            if (isset($data['petty'])) {
                ?>
                <div class="col-md-6">
                    <h4>Petty Cash Status</h4>
                    <table class="table">
                        <tr>
                            <td>Balance</td>
                            <td>{{$data['petty']->amount}}</td>
                        </tr>
                        <tr>
                            <td>Last Update</td>
                            <td>{{$data['petty']->updated_at}}</td>
                        </tr>
                    </table>
                </div>
            <?php } else { ?>
                <div class="col-md-6">
                    <p>The petty cash amount has not been set</p>
                </div>
            <?php } ?>


            <div class="col-md-6">
                <h4>Update Balance</h4>
                <form method="post" action="{{route('finance.gl.pettycash')}}">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <label class="control-label col-md-4">Type</label>
                    <div class="col-md-8">
                        <select required id='type' name="type" class="form-control">
                            <option value="">select update type</option>
                            <option value="deposit">Deposit</option>
                            <option value="widthraw">Widthrawal</option>
                            <option value="new">New Value</option>
                        </select>
                        <br>
                    </div>
                    <label class="control-label col-md-4">New Amount</label>
                    <div class="col-md-8">
                        <input required="" id="amount" autocomplete="off" type="text" name="amount" class="form-control">
                        <div id="response"></div>
                        <br>
                    </div>
                    <label class="control-label col-md-4">Description</label>
                    <div class="col-md-8">
                        <textarea name="reason" class="form-control"></textarea>
                        <br>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                    </div><br>
                </form>
            </div>

        </div><br/>

        <div class="col-md-12">
            @if($data['petty_updates']->isEmpty())
            <p class="text-info"><i class="fa fa-info"></i> No update records found!</p>
            @else
            <table id="updates" class="table table-responsive">
                <tbody>
                    <?php $n = 0; ?>
                    @foreach($data['petty_updates'] as $p)
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$p->users->username}}</td>
                        <td>{{$p->amount}}</td>
                        <td>{{$p->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th colspan="5">Petty Cash Pot Updates</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#updates').dataTable();
        } catch (e) {
        }

        $('#amount').keyup(function () {
            var amount = this.value;
            var type = $('#type').val();
            var account_type = 'petty';
            if (type === 'widthraw') {
                //check bogus widthraw
                $.ajax({
                    type: 'get',
                    url: "{{route('api.finance.widthraw.bogus')}}",
                    data: {amount: amount, type: type, account_type: account_type},
                    success: function (response) {
                        $('#response').html(response);
                    }
                });//ajax
            }
        });

    });
</script>
@endsection
