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
        var JP_BILL_PRINT_URL = '<?=route('finance.evaluation.ins.rcpt.print_jp')?>';
    </script>
    <script src="{{m_asset('finance:js/jambopay.min.js')}}"></script>
</div>
