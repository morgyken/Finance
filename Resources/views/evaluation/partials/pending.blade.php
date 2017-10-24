@extends('finance::evaluation.workbench')
@section('tab')
    <?php extract($data); ?>
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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="response">
                <?php $n = 0; ?>
                @foreach($pending as $visit)
                    @if($visit->unpaid_amount>0 )
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$visit->id}}</td>
                            <td>{{$visit->patients->full_name}}</td>
                            <td>{{$visit->created_at->format('d/m/y')}} </td>
                            <td>{{$visit->clinics->name}}</td>
                            <td>{{$visit->patient_scheme?$visit->patient_scheme->schemes->companies->name:''}}</td>
                            <td>{{$visit->patient_scheme?$visit->patient_scheme->schemes->name:''}}</td>
                            <td>{{$visit->unpaid_amount}}</td>
                            <td>
                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                        data-target="#info{{$visit->id}}">
                                    View
                                </button>
                                @include('finance::evaluation.partials.visit_charges')
                            </td>
                            <td>
                                @if(patient_has_pharmacy_bill($visit))
                                    <a class="btn btn-success btn-xs"
                                       href="{{route('finance.evaluation.pay.pharmacy',[$visit->patients->id,'insurance'=>true])}}">
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
                    @endif
                @endforeach

                </tbody>
            </table>
            {{--<button type="submit" class="btn btn-primary">Bill Selected Insurance</button>--}}
        </form>
        <script>
            $(function () {
                $('.records').dataTable({
                    dom: 'Bfrtip',
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
        <p>No pending insurance bill</p>
    @endif
@endsection