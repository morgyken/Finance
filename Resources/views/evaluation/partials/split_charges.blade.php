<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 11/2/17
 * Time: 4:51 PM
 */
?>
<div class="modal modal-default fade" id="info_split{{$_item->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bill Information</h4>
            </div>
            <div class="modal-body">
                <?php $TOTAL_S = 0;$PAID_S = 0;$UNPAID_S = 0;?>
                <table class="table table-condensed">
                    <tbody>
                    @foreach($_item->children as $__item)
                        <?php
                        if(empty($__item->investigations)){
                            continue;
                        }
                        $TOTAL_S += $__item->investigations->amount;
                        $is_paid = $__item->investigations->invoiced || $__item->investigations->is_paid;
                        if ($is_paid) {
                            $PAID_S += $__item->amount;
                        } else {
                            $UNPAID_S += $__item->amount;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$__item->investigations->procedures->name}}</td>
                            <td>{{ucfirst($__item->investigations->type)}}</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($__item->investigations->price,2)}}</td>
                            <td style="text-align: right">{{$__item->investigations->quantity}}</td>
                            <td style="text-align: right">{{number_format($__item->investigations->amount,2)}}</td>
                        </tr>
                        <?php
                        if(empty($__item->prescriptions)){
                            continue;
                        }
                        $TOTAL_S += $__item->prescriptions->payment->total;
                        $is_paid = $__item->prescriptions->is_paid;
                        if ($is_paid) {
                            $PAID_S += $__item->prescriptions->payment->total;
                        } else {
                            $UNPAID_S += $__item->prescriptions->payment->total;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$__item->prescriptions->drugs->name}}</td>
                            <td>Drug</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($__item->prescriptions->payment->price,2)}}</td>
                            <td style="text-align: right">{{$__item->prescriptions->payment->quantity}}</td>
                            <td style="text-align: right">{{number_format($__item->prescriptions->payment->total,2)}}</td>
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
                        <th style="text-align: right">{{ number_format($TOTAL_S,2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Processed Amount:</th>
                        <th style="text-align: right">{{ number_format($PAID_S,2) }}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Pending:</th>
                        <th style="text-align: right">{{ number_format($UNPAID_S,2) }}</th>
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