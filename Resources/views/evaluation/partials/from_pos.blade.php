<?php

function amount_after_discount($discount, $amount) {
    try {
        $discounted = $amount - (($discount / 100) * $amount);
        return ceil($discounted);
    } catch (\Exception $e) {
        return $amount;
    }
}
?>
<table class="table table-condensed" id="paymentsTable">
    <tbody><!-- From pos -->
        <tr>
    <input type="hidden" name="sale" value="{{$sales->id}}">
    @if($sales->paid===1)
    <td>
        <input type="checkbox" disabled=""/> <span class="label label-primary">Paid</span>
    </td>
    <?php show_sales($sales) ?>
    @else
    <input type="hidden" name="batch[]" value="{{$sales->id}}">
    <td>
        <input type="checkbox" value="{{$sales->id}}"name="item{{$sales->id}}" />
    </td>
    <td>
        <strong>
            Total Amount:
            <span style="font-weight: bold" class="topay">
                {{getAmount($sales)}}
            </span>
        </strong>
    </td>
    <?php show_sales($sales) ?>
    @endif
</tr>
</tbody>
</table>
<?php

function show_sales($sales) {
    ?>
    <table class="table">
        <tr>
            <th>#</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Discount(%)</th>
            <th>Amount</th>
        </tr>
        <?php
        $n = 0;
        $total = 0;
        foreach ($sales->goodies as $g) {
            $total += amount_after_discount($g->discount, $g->unit_cost * $g->quantity);
            ?>
            <tr>
                <td>{{$n+=1}}</td>
                <td>{{$g->products->name}}</td>
                <td>{{$g->quantity}}</td>
                <td>{{$g->unit_cost}}</td>
                <td>{{$g->discount}}</td>
                <td> {{number_format(amount_after_discount($g->discount, $g->unit_cost*$g->quantity),2)}}</td>
            </tr>
        <?php } ?>
        <tr style="font-weight: bold">
            <td></td>
            <td style="text-align: right" colspan="4">Total</td>
            <td>{{number_format($total,2)}}</td>
        </tr>
    </table>
    <?php
}

function getAmount($sales) {
    $total = 0;
    foreach ($sales->goodies as $g) {
        $total += amount_after_discount($g->discount, $g->unit_cost * $g->quantity);
    }
    return $total;
}
?>