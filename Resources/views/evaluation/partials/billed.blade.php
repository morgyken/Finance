@extends('finance::evaluation.workbench')
@section('tab')
    <?php extract($data); ?>

    @if(!$billed->isEmpty())
        {!! Form::open(['class'=>'form-horizontal', 'route'=>'finance.evaluation.dispatch']) !!}
        <table class="table table-stripped records" id="billed_table">
            <thead>
            <tr>
                <th>#</th>
                <th></th>
                <th>Invoice</th>
                <th>Patient</th>
                <th>Company::Scheme</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="response">
            <?php $t = $n = 0; ?>
            @foreach($billed as $item)
                <?php try { ?>
                <?php $t += $item->visits->unpaid_amount ?>
                <tr>
                    <td>{{$n+=1}}</td>
                    <td>
                        @if($item->status ==0)
                            <input id="check{{$item->id}}" type="checkbox" name="bill[]" value="{{$item->id}}">
                        @else
                            <i class="fa fa-check" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td>
                        {{$item->invoice_no}}
                    </td>
                    <td>{{$item->visits->patients->full_name}}</td>
                    <td>{{$item->visits->patient_scheme?$item->visits->patient_scheme->schemes->companies->name:''}}
                        ::{{$item->visits->patient_scheme?$item->visits->patient_scheme->schemes->name:''}}</td>
                    <td>
                        {{$item->payment}}
                        <input type="hidden" name="amount[]" value="{{$item->payment}}">
                    </td>
                    <td>
                        @if($item->visits->prescriptions->count())
                            <small><a class="btn btn-default btn-xs"
                                      href="{{route('evaluation.print.prescription',[$item->visits->id,true])}}"
                                      target="_blank">
                                    <i class="fa fa-file"></i> Print Pres</a></small>
                        @endif
                        <small>
                            <a target="blank" href="{{route('finance.evaluation.ins.inv.print', $item->id)}}"
                               class="btn btn-xs btn-primary">
                                <i class="fa fa-print"></i> Print Invoice</a>
                        </small>
                        @if($item->status <2)
                            {{--<small>--}}
                            {{--<a href="{{route('finance.evaluation.cancel', $item->id)}}"--}}
                            {{--class="btn btn-xs btn-danger">--}}
                            {{--<i class="fa fa-times"></i> Cancel</a>--}}
                            {{--</small>--}}
                        @endif
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
                <td colspan="3">
                    <!-- Dispatch Total:<input id="dis_tot" disabled="disabled" size="7" value="0.00"> --></td>
                <td style="text-align: right"></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        {!! Form::close() !!}

        <script type="text/javascript">
            var mode = 'billing';
        </script>
    @else
        <p>No billed insurance bills</p>
    @endif
@endsection