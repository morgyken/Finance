@if(!$payment->sale >0)
    <table class="table table-striped">
        @if(!$payment->deposit)
            <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Discount(%)</th>
                <th>Amount (Ksh.)</th>
            </tr>
            </thead>
            <tbody>
            <?php $n = $bill = 0; ?>
            @if(isset($payment->details))
                @foreach($payment->details as $d)
                    @if(!empty($d->investigations))
                        <tr>
                            <td>{{$n+=1}}</td>
                            <td>{{$d->item_desc}}
                                <i class="small">({{$d->investigations->type}})</i>
                                x {{$d->investigations->quantity>0?$d->investigations->quantity:1}}
                            </td>
                            <td>{{$d->investigations->discount}}</td>
                            <td>{{$d->price}}</td>
                        </tr>
                        <?php $bill += $d->investigations->amount > 0 ? $d->investigations->amount : $d->price ?>
                    @endif
                    @if(!empty($d->pharmacy))
                        <tr>
                            <td>{{$n+=1}}</td>
                            <td>{{$d->item_desc}}
                                <i class="small">(Drugs)</i>
                                x {{$d->pharmacy->payment->quantity}} units
                            </td>
                            <td>0</td>
                            <td>{{$d->price}}</td>
                        </tr>
                        <?php $bill +=  $d->price ?>
                    @endif
                @endforeach
            @endif

            <?php
            if (isset($disp)) {
            foreach ($disp as $key => $value) {
            $__dispensing = \Ignite\Evaluation\Entities\DispensingDetails::whereId($value)->get();
            ?>
            @foreach($__dispensing as $item)
                <tr>
                    <td>{{$n+=1}}</td>
                    <td>
                        {{$item->drug->name}}
                        <small>{{$item->price}} x {{$item->quantity}}</small>
                        (drug)
                    </td>
                    <td></td>
                    <td>{{$item->price*$item->quantity}}</td>
                </tr>
                <?php $bill += $item->price * $item->quantity ?>
            @endforeach
            <?php
            }
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>
                    {{$bill}}
                </td>
            </tr>
            @endif
            <tr>
                <td></td>
                <td></td>
                <td>Amount Paid</td>
                <td>
                    {{$payment->total}}
                </td>
            </tr>
            @if(!$payment->deposit)
                @if($payment->total-$bill>0)
                <tr>
                    <td></td>
                    <td></td>
                    <td>Balance</td>
                    <td>
                        {{$payment->total-$bill}}
                    </td>
                </tr>
                @endif
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total Account Balance</td>
                    <td>
                        {{get_patient_balance($payment->patients->id)}}
                    </td>
                </tr>
            @endif
            </tfoot>

    </table>
@else
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Discount</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $topay = 0; ?>
        @foreach($payment->sales->goodies as $item)
            <tr>
                <td>{{$item->products->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{ceil($item->unit_cost)}}</td>
                <td>{{$item->discount}}</td>
                <td>{{number_format(ceil($item->total),2)}}</td>
            </tr>
            <?php $topay += $item->total ?>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Total:</th>
            <th>
                {{number_format(ceil($topay),2)}}
            </th>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Payment:</th>
            <th>
                {{number_format(ceil($payment->total),2)}}
            </th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Change:</th>
            <th>
                {{number_format(ceil($payment->total-$topay),2)}}
            </th>
        </tr>
        </tfoot>
    </table>
@endif