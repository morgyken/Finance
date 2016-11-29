@extends('finance::evaluation.workbench')
@section('tab')
<?php extract($data); ?>
@if(!$dispatched->isEmpty())
<table class="table table-stripped" id="disp_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Dispatch Date</th>
            <th>Dispatch Number</th>
            <th>Company</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="response">
        <?php $n = 0; ?>
        @foreach($dispatched as $item)
        <tr>
            <td>{{$n+=1}}</td>
            <td>{{(new Date($item->created_at))->format('dS M y g:i a')}}</td>
            <td>{{'00'.$item->id}}</td>
            <td>
                {{$item->invoice->visits->patient_scheme->schemes->companies->name}}::
                {{$item->invoice->visits->patient_scheme->schemes->name}}
            </td>
            <td>{{$item->amount}}</td>
            <td>
                <a href="{{route('finance.evaluation.payment')}}" class="btn btn-xs btn-primary">
                    <i class="fa fa-money"></i> Receive Payment</a>

                <a href="" class="btn btn-xs btn-warning">
                    <i class="fa fa-print"></i>Print</a>

                <a href="" class="btn btn-xs btn-danger">
                    <i class="fa fa-trash"></i> Cancel Dispatch</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<br>
<p>No dispatched insurance bills</p>
@endif
@endsection