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
        <?php try { ?>
            @if($sales->removed_bills->isEmpty)
            <input type="checkbox" value="{{$sales->id}}"name="item{{$sales->id}}" />
            @else
            <input type="checkbox" disabled="" value="{{$sales->id}}"name="item{{$sales->id}}" />
            <small style="color:red">Bill was removed</small>
            @endif
        <?php } catch (Exception $ex) { ?>
            <input type="checkbox" value="{{$sales->id}}"name="item{{$sales->id}}" />
        <?php } ?>
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
            <td>
                {{number_format($total,2)}}<br>
                <?php try { ?>
                    @if($sales->removed_bills->isEmpty)
                    <a href="#" onclick="remove_bill('sale', <?php echo $sales->id; ?>, null)" class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash"></i>remove</a>
                    @else
                    <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>was removed</a>
                    <a href="#" onclick="undo_remove_bill('sale', <?php echo $sales->id; ?>, null)" class="btn btn-primary btn-xs"><i class="fa fa-undo"></i>Undo</a>
                    @endif
                <?php } catch (Exception $ex) { ?>
                    <a href="#" onclick="remove_bill('sale', <?php echo $sales->id; ?>, null)" class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash"></i>remove</a>
                <?php } ?>
            </td>
        </tr>
    </table>
    <script type="text/javascript">
        function remove_bill(type, id, visit) {
            $.ajax({
                type: 'get',
                url: "{{route('api.finance.evaluation.bill.remove')}}",
                data: {type: type, id: id, visit: visit},
                success: function (response) {
                    location.reload();
                }
            }); //ajax
        }


        function undo_remove_bill(type, id, visit) {
            $.ajax({
                type: 'get',
                url: "{{route('api.finance.evaluation.bill.undoremove')}}",
                data: {type: type, id: id, visit: visit},
                success: function (response) {
                    location.reload();
                }
            }); //ajax
        }
    </script>
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