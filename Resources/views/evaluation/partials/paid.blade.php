@extends('finance::evaluation.workbench')
@section('tab')
<?php extract($data); ?>
<!-- Row start -->
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Fully Bills</h3>
            </div>
            <div class="panel-body">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Visit</th>
                            <th>Company</th>
                            <th>Scheme</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="response">
                        @foreach($paid as $item)
                        <tr>
                            <td>{{$item->visits->id}}</td>
                            <td>{{$item->visits->patients->full_name}}</td>
                            <td>{{(new Date($item->created_at))->format('dS M y g:i a')}}</td>
                            <td>{{$item->visits->patient_scheme->schemes->companies->name}}</td>
                            <td>{{$item->visits->patient_scheme->schemes->name}}</td>
                            <td>{{$item->visits->unpaid_amount}}</td>
                            <td></td>
                        </tr>
                        @endforeach

                        @foreach($overpaid as $item)
                        <tr>
                            <td>{{$item->visits->id}}</td>
                            <td>{{$item->visits->patients->full_name}}</td>
                            <td>{{(new Date($item->created_at))->format('dS M y g:i a')}}</td>
                            <td>{{$item->visits->patient_scheme->schemes->companies->name}}</td>
                            <td>{{$item->visits->patient_scheme->schemes->name}}</td>
                            <td>{{$item->visits->unpaid_amount}}</td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
@include('finance::evaluation.partials.partpaid')

@endsection


