@if(!$payment->sale >0)
    <table class="table table-striped">
        @if(!$payment->deposit)
            <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
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
                                x {{$d->investigations->quantity>0?$d->investigations->quantity:1}}
                            </td>
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
                            <td>{{$d->price}}</td>
                        </tr>
                        <?php $bill += $d->price ?>
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
                    <td>{{$item->price*$item->quantity}}</td>
                </tr>
                <?php $bill += $item->price * $item->quantity ?>
            @endforeach
            <?php
            }
            }
            ?>
            @if(!empty($payment->copaid))
                @foreach($payment->copaid as $item)
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>
                            Copay:-{{$item->copay->scheme->companies->name}}({{$item->copay->scheme->name}})
                        </td>
                        <td></td>
                        <td style="text-align: right">{{$item->copay->amount}}</td>
                    </tr>
                    <?php $bill += $item->copay->amount ?>
                @endforeach
            @endif
            </tbody>
            <tfoot>
            <tr style="text-align: right">
                <td></td>
                <td style="text-align: right">Total</td>
                <th>
                    {{$bill}}
                </th>
            </tr>
            @endif
            <tr>
                <td></td>
                <td style="text-align: right">Amount Paid</td>
                <th>
                    {{$payment->total}}
                </th>
            </tr>
            @if(!$payment->deposit)
                @if($payment->total-$bill>0)
                    <tr>
                        <td></td>
                        <td style="text-align: right">Change</td>
                        <th>
                            {{$payment->total-$bill}}
                        </th>
                    </tr>
                @endif
            @else
                <tr>
                    <td></td>
                    <td style="text-align: right">Total Account Balance</td>
                    <th>
                        {{get_patient_balance($payment->patients->id)}}
                    </th>
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
        </tfoot>
    </table>
@endif