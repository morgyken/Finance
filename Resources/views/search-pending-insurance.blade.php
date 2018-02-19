<?php extract($data); ?>
@extends('finance::evaluation.workbench')
@section('tab')
    @include('finance::partials.queues.search-insurance')
    @if(!$pending->isEmpty())
        <form method="post" action="{{route('finance.evaluation.bill.many')}}" class="form-horizontal">
            {!! Form::token() !!}
            <table class="table table-stripped pending_table records">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Visit</th>
                    <th>Clinic</th>
                    <th>Company</th>
                    <th>Scheme</th>
                    <th>Amount</th>
                    <th>View</th>
                    <th class="disabled-sorting text-right">Action</th>
                </tr>
                </thead>
                <tbody class="response">
                <?php $n = 0; ?>
                @foreach($pending as $item)
                    <?php
                    try{
                    $visit = $item->visit;
                    $scheme = $visit->patient_scheme->schemes;
                    ?>
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$visit->patients->number}}</td>
                        <td>{{$visit->patients->full_name}}</td>
                        <td>{{$visit->created_at->format('d/m/y')}} </td>
                        <td>{{$visit->clinics->name}}</td>
                        <td>{{@$scheme->companies->name}}</td>
                        <td>{{@$scheme->name}}</td>
                        <td>{{$item->amount}}</td>
                        <td>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                    data-target="#info{{$visit->id}}">
                                View
                            </button>
                            @include('finance::evaluation.partials.visit_charges')
                        </td>
                        <td>
                            @if($item->has_meds)
                                <a class="btn btn-success btn-xs"
                                   href="{{route('finance.evaluation.pay.pharmacy',[$visit->patients->id,'insurance'=>$visit->id])}}">
                                    <i class="fa fa-bolt"></i> Process Meds</a>
                            @endif
                            <a href="{{route('finance.evaluation.prepare.bill', $visit->id)}}"
                               class="btn btn-xs btn-primary">
                                <i class="fa fa-usd"></i> Bill</a>
                            <a href="{{route('finance.change_mode', $visit->id)}}"
                               class="btn btn-xs btn-info">
                                <i class="fa fa-exchange"></i>Change</a>
                        </td>
                    </tr>
                    <?php
                    }catch (\Exception $e) {
                    }?>
                @endforeach

                </tbody>
            </table>
        </form>
        <script>
            $(function () {
                $('.records').dataTable({
                    pageLength: 25,
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Pending Insurance Payments',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: [1, 2, 3, 5, 6, 7]
                            }
                        }, {
                            extend: 'pdf',
                            title: 'Pending Insurance Payments',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: [1, 2, 3, 5, 6, 7]
                            }
                        },

                    ]
                });
            });
        </script>
    @else
        <p>No results found</p>
    @endif
@endsection
