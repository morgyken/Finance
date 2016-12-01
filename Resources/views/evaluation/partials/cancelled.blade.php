@extends('finance::evaluation.workbench')
@section('tab')
<?php extract($data); ?>
@if(!$canceled->isEmpty())
<table class="table table-stripped cancel_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Visit</th>
            <th>Company</th>
            <th>Scheme</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="response">
        @foreach($canceled as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->visits->patients->full_name}}</td>
            <td>{{(new Date($item->visits->created_at))->format('dS M y g:i a')}} - Clinic {{$item->visits->clinics->name}}</td>
            <td>{{$item->visits->patient_scheme->schemes->companies->name}}</td>
            <td>{{$item->visits->patient_scheme->schemes->name}}</td>
            <td>{{$item->visits->unpaid_amount}}</td>
            <td><a href="{{route('finance.evaluation.undo.cancel', $item->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-undo"></i>Undo</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<br>
<p>No cancelled insurance bills</p>
@endif
@endsection