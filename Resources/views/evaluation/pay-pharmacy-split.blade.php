<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 11/4/17
 * Time: 11:27 PM
 */
?>
@if(!empty($split->children))
    {!! Form::open(['route'=>'finance.evaluation.pharmacy.dispense','id'=>'presForm']) !!}
    @if(request('insurance'))
        {{Form::hidden('to_redirect',true)}}
    @endif
    {{Form::hidden('patient',$patient->id)}}
    <table class="table table-condensed" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Drug</th>
            <th>Prescription</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($split->children as $baby)
            <?php
            if(empty($baby->prescriptions)){
                continue;
            }
            $item = $baby->prescriptions;
            $visit = $item->visits;
            ?>
            @if ($item->payment->complete)
                @continue
            @endif
            <tr id="row{{$item->id}}">
                <td>
                    {{$loop->iteration}}
                    <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}"/>
                </td>
                <td>
                    {{$item->drugs->name}}<br>
                    <i>{{ $item->drugs->stocks?$item->drugs->stocks->quantity>0?$item->drugs->stocks->quantity:0:0}}
                        in
                        store</i>
                </td>
                <td>
                    <dl class="dl-horizontal">
                        <dt>Dose:</dt>
                        <dd>{{$item->dose}}</dd>
                        <dt>Date:</dt>
                        <dd>{{smart_date_time($item->created_at)}}</dd>
                        <dt>Prescribed By:</dt>
                        <dd> {{$item->users->profile->full_name}} </dd>
                        <dt>Notes</dt>
                        <dd><em><u>{{$item->notes??'N/A'}}</u></em></dd>
                        <!-- <b>Payment Mode: </b> Cash<br> -->
                    </dl>
                </td>
                <td>
                    {{$item->payment->cost}}
                    <input type="hidden" value="{{$item->payment->cost}}" name="prc{{$item->id}}"
                           id="prc{{$item->id}}">
                </td>
                <td>
                    <input name="qty{{$item->id}}" id="quantity{{$item->id}}"
                           class="qty{{$item->id}}"
                           value="{{$item->payment->quantity}}"
                           size="4"
                           type="text" autocomplete="off"></td>
                <td>
                    <input class="txt" size="10" readonly="" id="total{{$item->id}}" type="text"
                           name="txt"/>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr id="summation">
            <td colspan="4" align="right">
                Sum :
            </td>
            <td>
                <input type="text" id='sum1' name="input"/>
                <input type="hidden" name="visit" value="{{$split->visit}}">
            </td>
            <td>
                <button type="submit" class="btn btn-xs btn-success">
                    <i class="fa fa-hand-o-right"></i>
                    Process and Bill
                </button>
            </td>
        </tr>
        </tfoot>
    </table>
    {!! Form::close()!!}
@else
    <p>No drugs ordered for this patient</p>
@endif
