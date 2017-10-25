@extends('finance::evaluation.workbench')
@section('tab')
    <?php extract($data); ?>
    @if(!$payment->isEmpty())
        <table class="table table-stripped  records">
            <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Visit</th>
                <th>Company</th>
                <th>Scheme</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody class="response">
            @foreach($payment as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->visits->patients->full_name}}</td>
                    <td>{{$item->visits->created_at->format('dS M y')}}</td>
                    <td>{{$item->scheme->companies->name}}</td>
                    <td>{{$item->scheme->name}}</td>
                    <td>{{$item->payment}}</td>
                    <td>{!! $item->nice_status !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <script>
            $(function () {
                $('.records').dataTable({
                    pageLength: 25,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Cancelled Invoices',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            }
                        }, {
                            extend: 'pdf',
                            title: 'Cancelled Invoices',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            }
                        },

                    ]
                });
            });
        </script>
    @else
        <br>
        <p>No cancelled insurance bills</p>
    @endif
@endsection