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
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->created_at->format('dS M y')}}</td>
                    <td>{{'00'.$item->id}}</td>
                    <td>
                        {{$item->scheme->companies->name}}::
                        {{$item->scheme->name}}
                    </td>
                    <td>{{number_format($item->payment, 2)}}</td>
                    <td>
                        <a target="blank" href="{{route('finance.evaluation.payment')}}" class="btn btn-xs btn-primary">
                            <i class="fa fa-money"></i> Receive Payment</a>

                        <a target="blank" href="{{route('finance.evaluation.print_dispatch', $item->id)}}"
                           class="btn btn-xs btn-warning">
                            <i class="fa fa-print"></i>Print</a>

                        <a href="{{route('finance.evaluation.purge_dispatch', $item->id)}}"
                           class="btn btn-xs btn-danger">
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