@extends('finance::evaluation.workbench')
@section('tab')
<?php extract($data); ?>
@if(!$billed->isEmpty())
{!! Form::open(['class'=>'form-horizontal', 'route'=>'finance.evaluation.ins.save.pay']) !!}
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Cheque Details</h3>
            </div>
            <div class="panel-body">
                <div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name:</label>
                            <div class="col-md-8">
                                {!! Form::text('ChequeName',old('ChequeName'),['class'=>'form-control','placeholder'=>'Ac Holder Name']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Date:</label>
                            <div class="col-md-8">
                                <input type='text' id="date1" placeholder="Date on Cheque" name='ChequeDate'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Amount:</label>
                            <div class="col-md-8">
                                {!! Form::text('ChequeAmount',old('ChequeAmount'),['class'=>'form-control cheque_amount','placeholder'=>'Amount','required'=>'required']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Bank:</label>
                            <div class="col-md-8">
                                {!! Form::text('ChequeBank',old('ChequeBank'),['class'=>'form-control','placeholder'=>'Bank']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Branch:</label>
                            <div class="col-md-8">
                                {!! Form::text('ChequeBankBranch',old('ChequeBankBranch'),['class'=>'form-control','placeholder'=>'Branch']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Cheque Number:</label>
                            <div class="col-md-8">
                                {!! Form::text('ChequeNumber',old('ChequeNumber'),['class'=>'form-control','placeholder'=>'Cheque Number','required'=>'required']) !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Row end -->


<table class="table table-stripped" id="payment_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Patient</th>
            <th>Visit Date</th>
            <th>Company</th>
            <th>Amount</th>
            <th>Amount Paid</th>
            <th>Pay</th>
        </tr>
    </thead>
    <tbody class="response" id="rows">
        <?php $t = $n = 0; ?>
        @foreach($billed as $inv)
        <?php
        $t+= $inv->visits->unpaid_amount;
        $bal = $inv->payment - $inv->paid;
        ?>
        <tr>
            <td>{{$n+=1}}</td>
            <td>
                <input onclick="updateAmount({{$bal}}, {{$inv->id}})" id="pay_check{{$inv->id}}" type="checkbox" name="invoice[]" value="{{$inv->id}}">
                {{$inv->invoice_no}}
            </td>
            <td>{{$inv->visits->patients->full_name}}</td>
            <td>{{(new Date($inv->visits->created_at))->format('dS M y')}}</td>
            <td>{{$inv->visits->patient_scheme->schemes->companies->name}}:
                {{$inv->visits->patient_scheme->schemes->name}}</td>
            <td>{{$inv->payment}}</td>
            <td>{{$inv->paid}}</td>
            <td>
                <input readonly="" type="text" size="5" name="amount{{$inv->id}}" id="pay_amount{{$inv->id}}" value="{{$bal}}">
                {!! Form::hidden('patient',$inv->visits->patients->id) !!}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <div id="action-scene"></div>
            </td>
            <td colspan="2"><strong>Total:</strong> <input id="pay_dis_tot" disabled="disabled" size="7" value="0.00"></td>
            <td style="text-align: right"><strong>Balance:</strong></td>
            <td colspan="2">
                <input id="pay_sum" type="hidden" disabled="disabled" size="10" value="{{number_format($t,2)}}">
                <input id="pay_balance" type="text" disabled="disabled" size="10" value="0.00">
            </td>
        </tr>
    </tfoot>
</table>
</form>
<script type="text/javascript">
    var mode = 'payment';
</script>
@else
<p>No billed insurance bills</p>
@endif
@endsection