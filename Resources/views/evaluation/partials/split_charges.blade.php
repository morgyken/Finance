<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 11/2/17
 * Time: 4:51 PM
 */
?>
<div class="modal modal-default fade" id="info{{$visit->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bill Information</h4>
            </div>
            <div class="modal-body">
                <?php $TOTAL = 0;$PAID = 0;$UNPAID = 0;?>
                <table class="table table-condensed">
                    <tbody>
                    @foreach($item->children as $item)
                        <?php
                        if(empty($item->investigations)){
                            continue;
                        }
                        $TOTAL += $item->investigations->amount;
                        $is_paid = $item->investigations->invoiced || $item->investigations->is_paid;
                        if ($is_paid) {
                            $PAID += $item->amount;
                        } else {
                            $UNPAID += $item->amount;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->investigations->procedures->name}}</td>
                            <td>{{ucfirst($item->investigations->type)}}</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->investigations->price,2)}}</td>
                            <td style="text-align: right">{{$item->investigations->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->investigations->amount,2)}}</td>
                        </tr>
                        <?php
                        if(empty($item->prescriptions)){
                            continue;
                        }
                        $TOTAL += $item->prescriptions->payment->total;
                        $is_paid = $item->prescriptions->is_paid;
                        if ($is_paid) {
                            $PAID += $item->prescriptions->payment->total;
                        } else {
                            $UNPAID += $item->prescriptions->payment->total;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->prescriptions->drugs->name}}</td>
                            <td>Drug</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->prescriptions->payment->price,2)}}</td>
                            <td style="text-align: right">{{$item->prescriptions->payment->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->prescriptions->payment->total,2)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="text-align: right">Price</th>
                        <th style="text-align: right">Units</th>
                        <th style="text-align: right">Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">TOTAL:</th>
                        <th style="text-align: right">{{ number_format($TOTAL,2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Processed Amount:</th>
                        <th style="text-align: right">{{ number_format($PAID,2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Pending:</th>
                        <th style="text-align: right">{{ number_format($UNPAID,2) }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->