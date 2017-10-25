@extends('finance::evaluation.workbench')

@section('tab')
    <?php extract($data); ?>
    @if(!empty($billed))
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
                                            <input type='text' id="date1" placeholder="Date on Cheque"
                                                   name='ChequeDate'>
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
            <?php $t = $n = 0; ?>
            {!! Form::hidden('company',$company->id) !!}
            <!-- Row end -->
            <table class="table table-stripped records" id="payment_table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Select</th>
                    <th>Invoice</th>
                    {{--<th>Patient</th>--}}
                    <th>Visit Date</th>
                    <th>Company</th>
                    <th>Scheme</th>
                    <th>Amount</th>
                    <th>Amount Paid</th>
                    <th>Pay</th>
                </tr>
                </thead>
                <tbody>

                @foreach($billed as $inv)
                    <?php
                    try {
                    $bal = $inv->payment - $inv->paid;
                    $t += $bal;
                    ?>
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            <input id="pay_check{{$inv->id}}"
                                   type="checkbox" name="invoice[]" value="{{$inv->id}}" samd="amount{{$inv->id}}">
                        </td>
                        <td>{{$inv->invoice_no}} </td>
                        {{--                            <td>{{$inv->visits->patients->full_name}}</td>--}}
                        <td>{{$inv->visits->created_at->format('dS M y')}}</td>
                        <td>{{$inv->scheme->companies->name}}</td>
                        <td>{{$inv->scheme->name}}</td>
                        <td>{{$inv->payment}}</td>
                        <td>{{$inv->paid}}</td>
                        <td>
                            <input readonly type="text" size="5" name="amount{{$inv->id}}"
                                   id="pay_amount{{$inv->id}}" value="{{$bal}}">
                            {!! Form::hidden('patient',$inv->visits->patients->id) !!}
                        </td>
                    </tr>
                    <?php
                    } catch (\Exception $e) {

                    }
                    ?>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">
                        <div id="action-scene"></div>
                    </td>
                    <td colspan="2">
                        <strong>Sum:</strong>
                        <input disabled="disabled" size="7" value="{{$t}}"/>
                    </td>
                    <td colspan="2">
                        <strong>Selected Total:</strong>
                        <input id="pay_dis_tot" disabled="disabled" size="7" value="0.00"/>
                    </td>
                    <td colspan="2">
                        <strong>Balance:</strong>
                        <input id="pay_sum" type="hidden" disabled="disabled" size="10">
                        <input id="pay_balance" type="text" disabled="disabled" size="10" value="0.00">
                    </td>
                </tr>
                </tfoot>
            </table>
            {{Form::close()}}
            <script type="text/javascript">
                var mode = 'payment';
                $(function () {
                    var billedIds = [], arrIndex = {};
                    var position = 0;

                    function add_replace_item(object) {
                        var index = arrIndex[object.id];
                        if (index === undefined) {
                            index = position;
                            arrIndex[object.id] = index;
                            position++;
                        }
                        billedIds[index] = object;
                        calc();
                    }

                    function remove_item(id) {
                        billedIds = billedIds.filter(function (obj) {
                            return obj.id !== id;
                        });
                        calc();
                    }

                    var SELECTED_SUM, PAID_AMOUNT = 0;
                    $(".cheque_amount").keyup(function () {
                        PAID_AMOUNT = parseInt(this.value);
                        calc();
                    });


                    function calc() {
                        if (billedIds.length > 0)
                            $("#action-scene").html('<input type="submit" class="btn btn-success" value="Receive Payment" >');
                        else
                            $("#action-scene").html('<span class="label label-danger">Select an Insurance Firm for action</span>');
                        $amount = $('#pay_dis_tot');
                        $sum = $('#pay_sum');
                        $balance = $('#pay_balance');
                        SELECTED_SUM = 0;
                        $('.records tbody').find('input[type=checkbox]').each(function (e) {
                            var control = $('input[name=' + $(this).attr('samd') + ']');
                            if ($(this).is(':checked')) {
                                control.prop('readonly', false);
                                SELECTED_SUM += parseInt(control.val());
                            } else {
                                control.prop('readonly', true);
                            }
                        });
                        $amount.val(SELECTED_SUM);
                        var bal = PAID_AMOUNT - SELECTED_SUM;
                        $balance.val(bal);
                        if (bal < 0) {
                            $balance.css("background-color", "pink");
//                            $("#action-scene").html('<span class="label label-danger">Amount not sufficient</span>');
                        }
                        else {
                            $balance.css("background-color", "");
                        }
                    }

                    $('#payment_table').find('input[type=checkbox]').iCheck({
                        checkboxClass: 'icheckbox_flat-green',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%' // optional
                    });
                    $('#payment_table').find('input[type=checkbox]').on('ifChanged', function (e) {
                        e.stopImmediatePropagation();
                        var the_id = $(this).val();
                        if ($(this).is(':checked')) {
                            add_replace_item({
                                id: the_id
                            });
                        } else {
                            remove_item(the_id);
                        }
                    });

                });
            </script>

        @else
            <p class="text-warning">No dispatched insurance bills for <strong>{{$company->name}}</strong></p>
        @endif
    @else
        <p class="text-warning">It seems you have not selected a company</p>
    @endif
@endsection