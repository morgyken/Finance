
@if(!$payment->sale >0)
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Procedures/Drug</th>
            <th>Discount(%)</th>
            <th>Amount (Ksh.)</th>
        </tr>
    </thead>
    <tbody>
        <?php $n = 0; ?>
        @if(isset($payment->details))
        @foreach($payment->details as $d)
        <tr>
            <td>{{$n+=1}}</td>
            <td>{{$d->investigations->procedures->name}}
                <i class="small">({{$d->investigations->type}})</i>
                x {{$d->investigations->quantity>0?$d->investigations->quantity:1}}
            </td>
            <td>{{$d->investigations->discount}}</td>
            <td>{{$d->investigations->amount>0?$d->investigations->amount:$d->price}}</td>
        </tr>
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
                @endforeach
                <?php
            }
        }
        ?>

    </tbody>

    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th>Total</th>
            <th>
                {{$payment->total}}
            </th>
        </tr>
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
        @foreach($payment->sales->goodies as $item)
        <tr>
            <td>{{$item->products->name}}</td>
            <td>{{$item->quantity}}</td>
            <td>{{ceil($item->unit_cost)}}</td>
            <td>{{$item->discount}}</td>
            <td>{{number_format(ceil($item->total),2)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Total Amount:</th>
            <th></th>
            <th></th>
            <th></th>
            <th>
                {{number_format(ceil($payment->sales->amount),2)}}
            </th>
        </tr>
    </tfoot>
</table>
@endif