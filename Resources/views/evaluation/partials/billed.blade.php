@extends('finance::evaluation.workbench')
@section('tab')
<?php extract($data); ?>

@if(!$billed->isEmpty())
{!! Form::open(['class'=>'form-horizontal', 'route'=>'finance.evaluation.dispatch']) !!}
<table class="table table-stripped" id="billed_table">
    <thead>
        <tr>
            <th>#</th>
            <th></th>
            <th>Invoice</th>
            <th>Patient</th>
            <th>Company::Scheme</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="response">
        <?php $t = $n = 0; ?>
        @foreach($billed as $item)
        <?php $t+= $item->visits->unpaid_amount ?>
        <tr>
            <td>{{$n+=1}}</td>
            <td>
                @if($item->status ==0)
                <input  id="check{{$item->id}}" type="checkbox" name="bill[]" value="{{$item->id}}">
                @else
                <i class="fa fa-check" aria-hidden="true"></i>
                @endif
            </td>
            <td>
                {{$item->invoice_no}}
            </td>
            <td>{{$item->visits->patients->full_name}}</td>
            <td>{{$item->visits->patient_scheme->schemes->companies->name}}::{{$item->visits->patient_scheme->schemes->name}}</td>
            <td>
                {{$item->payment}}
                <input type="hidden" name="amount[]" value="{{$item->payment}}">
            </td>
            <td>
                @if($item->status ==0)
                <!--billed-->
                <span  class="btn-default btn-xs">
                    <small>
                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                        billed
                    </small></span>
                @elseif($item->status ==1)
                <!--dispatched -->
                <span  class="btn-info btn-xs">
                    <small>
                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                        dispatched
                    </small>
                </span>
                @elseif($item->status ==2)
                <!--paid in part-->
                <span  class="btn-primary btn-xs">
                    <small>
                        <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                        partially paid
                    </small>
                </span>
                @elseif($item->status ==3)
                <!--fully paid -->
                <span  class="btn-success btn-xs">
                    <small>
                        <i class="fa fa-hourglass" aria-hidden="true"></i>
                        fully paid
                    </small>
                </span>
                @elseif($item->status ==4)
                <!--overpaid paid -->
                <span  class="btn-warning btn-xs">
                    <small>
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        overpaid
                    </small>
                </span>
                @elseif($item->status ==5)
                <!--canceled -->
                <span  class="btn-default btn-xs">
                    <small><i style="color:red" class="fa fa-trash"></i>cancelled</small></span>
                @endif

            </td>
            <td>
                <small>
                    <a href="{{route('finance.evaluation.ins.inv.print', $item->id)}}" class="btn btn-xs btn-primary">
                        <i class="fa fa-print"></i> Print</a>
                </small>
                @if($item->status <2)
                <small>
                    <a href="{{route('finance.evaluation.cancel', $item->id)}}" class="btn btn-xs btn-danger">
                        <i class="fa fa-times"></i> Cancel</a>
                </small>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <div id="action-scene"></div>
            </td>
            <td colspan="3"><!-- Dispatch Total:<input id="dis_tot" disabled="disabled" size="7" value="0.00"> --></td>
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