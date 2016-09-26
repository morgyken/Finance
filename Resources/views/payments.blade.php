<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo (bkiptoo@gmail.com)
 *
 * =============================================================================
 */
$count = 0;
?>
@extends('layouts.app')
@section('content_title','Payments')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Payments</h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['pay']->isEmpty())
                <table class="table table-responsive table-striped" id="payments">
                    <tbody>
                        <?php $n = 0; ?>
                        @foreach($data['pay'] as $p)
                        <tr>
                            <td>{{$n+=1}}</td>
                            <td>{{$p->amount}}</td>
                            <td>{{$p->users->username}}</td>
                            <td>
                                @if($p->mode =='petty')
                                Petty Cash
                                @endif
                            </td>
                            <td>{{$p->accounts['number']}}</td>
                            <td>{{$p->created_at}}</td>
                            <td></td>
                            <td>
                    <center>
                        <a href="{{route('finance.gl.payment.details', $p->id)}}"> <i class="fa fa-plus-square-o"></i></a>
                    </center>
                    </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>User</th>
                            <th>Payment Mode</th>
                            <th>Account Number</th>
                            <th>Time</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No payments have been made yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#payments').dataTable();
        } catch (e) {
        }
    });
</script>
@endsection