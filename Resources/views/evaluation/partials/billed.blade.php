@extends('finance::evaluation.workbench')
@section('tab')
    <?php extract($data); ?>

    @if(!$billed->isEmpty())
        {!! Form::open(['class'=>'form-horizontal', 'route'=>'finance.evaluation.dispatch']) !!}
        <table class="table table-stripped records" id="billed_table">
            <thead>
            <tr>
                <th>#</th>
                <th>Select</th>
                <th>Invoice</th>
                <th>Date</th>
                <th>Name</th>
                <th>Company</th>
                <th>Scheme</th>
                <th>Amount</th>
                <th>Status</th>
                <th>View</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="response">
            @foreach($billed as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
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
                    <td>
                        {{$item->created_at->format('d/m/y')}}
                    </td>
                    <td>{{@$item->visits->patients->full_name}}</td>
                    <td>{{@$item->scheme->companies->name}}</td>
                    <td>{{@$item->scheme->name}}</td>
                    <td>
                        {{$item->payment}}
                        <input type="hidden" name="amount[]" value="{{$item->payment}}">
                    </td>
                    <td>{!! $item->nice_status !!}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                                data-target="#info{{$item->visits->id}}">
                            View
                        </button>
                        @include('finance::evaluation.partials.visit_billed_charges',['visit'=>$item->visits,'only'=>'billed'])
                    </td>
                    <td>
                        <div class="btn-group">
                            <a target="blank" href="{{route('finance.evaluation.ins.inv.print_thermal', $item->id)}}"
                               class="btn btn-xs btn-primary">
                                <i class="fa fa-print"></i></a>
                            <button type="button" class="btn btn-primary dropdown-toggle btn-xs"
                                    data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a target="blank"
                                       href="{{route('finance.evaluation.ins.inv.print', $item->id)}}">
                                        Print (A4)</a>
                                </li>
                                @if($item->visits->prescriptions->count())
                                    <li><a class="btn btn-default btn-xs"
                                           href="{{route('evaluation.print.prescription',[$item->visits->id,true])}}"
                                           target="_blank">
                                            Print Prescript (thermal)</a></li>
                                    <li><a class="btn btn-default btn-xs"
                                           href="{{route('evaluation.print.prescription',[$item->visits->id])}}"
                                           target="_blank">
                                            Print Prescript (A5)</a></li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
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
                <td colspan="4"></td>
            </tr>
            </tfoot>
        </table>
        {!! Form::close() !!}

        <script type="text/javascript">
            var mode = 'billing';
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

                function calc() {
                    if (billedIds.length > 0)
                        $("#action-scene").html('<input type="submit" class="btn btn-success" value="Dispatch Selected Invoices" >');
                    else
                        $("#action-scene").html('<span class="label label-danger">Select an Insurance Firm for action</span>');

                }

                $('.records').dataTable({
                    pageLength: 25,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Billed Invoices',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6, 7]
                            }
                        }, {
                            extend: 'pdf',
                            title: 'Billed Invoices',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            className: 'btn btn-default',
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6, 7]
                            }
                        },

                    ]
                });
                $('#billed_table').find('input[type=checkbox]').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
                $('#billed_table').find('input[type=checkbox]').on('ifChanged', function (e) {
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
        <p>No billed insurance bills</p>
    @endif
@endsection