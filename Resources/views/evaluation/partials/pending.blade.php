@extends('finance::evaluation.workbench')
@section('tab')
<?php extract($data); ?>
@if(!$pending->isEmpty())
<form method="post" action="{{route('finance.evaluation.bill.many')}}" class="form-horizontal">
    {!! Form::token() !!}
    <table class="table table-stripped pending_table">
        <thead>
            <tr>
                <th>#</th>
                <th>Bill?</th>
                <th>Patient ID</th>
                <th>Patient</th>
                <th>Visit</th>
                <th>Company</th>
                <th>Scheme</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="response">
            <?php $n = 0; ?>
            @foreach($pending as $visit)
            <?php try { ?>
                @if($visit->unpaid_amount>0)
                <tr>
                    <td>{{$n+=1}}</td>
                    <td>
                        @if($visit->status ==null)
                        <input type="checkbox" name="visit[]" value="{{$visit->id}}">
                        @endif
                        <input type="hidden" name="amount[]" value="{{$visit->unpaid_amount}}"
                    </td>
                    <td>{{$visit->id}}</td>
                    <td>{{$visit->patients->full_name}}</td>
                    <td>{{(new Date($visit->created_at))->format('dS M y g:i a')}} - Clinic {{$visit->clinics->name}}</td>
                    <td>{{$visit->patient_scheme?$visit->patient_scheme->schemes->companies->name:''}}</td>
                    <td>{{$visit->patient_scheme?$visit->patient_scheme->schemes->name:''}}</td>
                    <td>{{$visit->unpaid_amount}}</td>
                    <td>
                        @if($visit->unpaid_amount>0)
                        <a href="{{route('finance.evaluation.bill', $visit->id)}}" class="btn btn-xs btn-primary">
                            <i class="fa fa-usd"></i> Bill</a>
                        @endif
                        <a href="{{route('finance.evaluation.tocash', $visit->id)}}" class="btn btn-xs btn-info">
                            <i class="fa fa-money"></i>Change to Cash</a>
                    </td>
                </tr>
                @endif

                <?php
            } catch (\Exception $e) {

            }
            ?>
            @endforeach
        <tfoot>
            <tr>
                <th colspan="9"><input type="submit" value="Bill Selected Insurance"></th>
            </tr>
        </tfoot>
        </tbody>
    </table>
</form>
@else
<p>No pending insurance bill</p>
@endif
@endsection