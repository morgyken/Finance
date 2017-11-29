<h4>Jambopay</h4>
<div>
    <div id="wallet_op"></div>
    <div class="form-group">
        <label class="col-md-4 control-label">Amount</label>
        <div class="col-md-8">
            {!! Form::text('JPAmount',old('JPAmount'),['class'=>'form-control','placeholder'=>'Jambopay Amount']) !!}
            {!! Form::hidden('JPid') !!}
        </div>
    </div>
    <div class="pull-right">
        {{--<button type="button" class="btn btn-xs btn-primary" id="JPWcreate">Create Wallet</button>--}}
        <button type="button" class="btn btn-xs btn-primary" id="JPWbill">Post Bill</button>
        <button type="button" class="btn btn-xs btn-primary" id="JPWstatus">Finalize Bill</button>
        <a href="#" class="btn btn-xs btn-default" id="JPWprint"
           target="_blank"><i class="fa fa-print"></i> Print Bill
        </a>
        <div class="loader" id="jpLoader"></div>
    </div>
    <div class="clearfix"></div>
    <br/><br/>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>Pending bills</h4>
        </div>
        <div class="panel-body">
            <table class="table table-responsive table-stripped" id="JPbills">
                <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Bill Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <style>
        .swal-overlay {
            background-color: rgba(30, 30, 30, 0.9);
            /*background-color: red;*/
        }
    </style>
    <script>
        var JP_POST_BILL_URL = '<?=route('api.finance.wallet.post', $patient->id)?>';
        var JP_CREATE_WALLET_URL = '<?=route('api.finance.wallet.create', $patient->id)?>';
        var JP_WALLET_EXIST_URL = '<?=route('api.finance.wallet.check', $patient->id)?>';
        var JP_BILL_STATUS_URL = '<?=route('api.finance.wallet.status', $patient->id)?>';
        var JP_PENDING_BILLS_URL = '<?=route('api.finance.wallet.pending', $patient->id)?>';
        var JP_BILL_PRINT_URL = '<?=route('finance.evaluation.ins.rcpt.print_jp')?>';
    </script>
    <script src="{{m_asset('finance:js/jambopay.js')}}"></script>
</div>
