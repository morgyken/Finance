<?php
$copaid = false;
if ($visit->patient_scheme->schemes->type == 3) {
    $copaid = true;
    $copay = $visit->patient_scheme->schemes->amount;
}
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
                    @foreach($visit->investigations as $item)
                        <?php
                        $is_paid = $item->invoiced;
                        if ($is_paid) {
                            $TOTAL += $item->amount;
                            $PAID += $item->amount;
                        } else {
                            if ($only == 'billed') {
                                continue;
                            }
                            $UNPAID += $item->amount;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->procedures->name}}</td>
                            <td>{{ucfirst($item->type)}}</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->price,2)}}</td>
                            <td style="text-align: right">{{$item->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->amount,2)}}</td>
                        </tr>
                    @endforeach

                    @foreach($visit->prescriptions as $item)
                        <?php
                        $is_paid = $item->is_paid;
                        if ($is_paid) {
                            $TOTAL += $item->payment->total;
                            $PAID += $item->payment->total;
                        } else {
                            if ($only == 'billed') {
                                continue;
                            }
                            $UNPAID += $item->payment->total;
                        }
                        ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->drugs->name}}</td>
                            <td>Drug</td>
                            <td>{!! $is_paid?'<span class="label label-success">Invoiced</span>':'<span class="label label-warning">Pending</span>'!!}</td>
                            <td style="text-align: right">{{number_format($item->payment->price,2)}}</td>
                            <td style="text-align: right">{{$item->payment->quantity}}</td>
                            <td style="text-align: right">{{number_format($item->payment->total,2)}}</td>
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
                    @if($copaid)
                        <tr>
                            <th style="text-align: right;" colspan="6" class="grand total">Copay:</th>
                            <th style="text-align: right">{{ number_format($copay,2) }}</th>
                        </tr>
                        <?php $PAID -= $copay; ?>
                    @endif
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">Billed Amount:</th>
                        <th style="text-align: right">{{ number_format($PAID,2) }}</th>
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