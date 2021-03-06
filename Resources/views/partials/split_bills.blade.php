<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 11/2/17
 * Time: 4:27 PM
 */
?>
@foreach(get_split_bills() as $_item)
    <?php 
    $_visit = $_item->visit;
    ?>
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$_visit->id}}</td>
        <td>{{$_visit->patients->full_name}} (*Split)</td>
        <td>{{$_item->created_at->format('d/m/y')}} </td>
        <td>{{$_visit->clinics->name}}</td>
        <td>{{$_item->_scheme->schemes->companies->name}}</td>
        <td>{{$_item->_scheme->schemes->name}}</td>
        <td>{{$_item->unpaid_amount}}</td>
        <td>
            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                    data-target="#info_split{{$_item->id}}">
                View
            </button>
            @include('finance::evaluation.partials.split_charges')
        </td>
        <td>
            @if(patient_has_pharmacy_bill($_visit))
                <a class="btn btn-success btn-xs"
                   href="{{route('finance.evaluation.pay.pharmacy',[$_visit->patients->id,'insurance'=>true,'split'=>$_item->id])}}">
                    <i class="fa fa-bolt"></i> Process Meds</a>
            @endif

            <a href="{{route('finance.evaluation.prepare.bill', ['id'=>$_visit->id,'split'=>$_item->id])}}"
               class="btn btn-xs btn-primary">
                <i class="fa fa-usd"></i> Bill</a>

            <a href="{{route('finance.change_mode', ['id'=>$_visit->id,'split'=>$_item->id])}}"
               class="btn btn-xs btn-info">
                <i class="fa fa-exchange"></i>Change</a>

            <a href="{{route('finance.split_bill', ['id'=>$_visit->id,'split'=>$_item->id])}}"
               class="btn btn-xs btn-success">
                <i class="fa fa-scissors"></i>Split</a>
        </td>
    </tr>
@endforeach
