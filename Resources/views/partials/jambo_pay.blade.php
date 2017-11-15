<h4>Jambopay</h4>
<div>
    <div class="form-group">
        <label class="col-md-4 control-label">Amount</label>
        <div class="col-md-8">
            {!! Form::text('JPAmount',old('JPAmount'),['class'=>'form-control','placeholder'=>'Jambopay Amount']) !!}
        </div>
    </div>
    <div class="pull-right">
        <button type="button" class="btn btn-xs btn-primary" id="JPWcreate">Create Wallet</button>
        <button type="button" class="btn btn-xs btn-primary" id="JPWbill">Post Bill</button>
    </div>
    <script>
        $(function () {
            var $create = $('button#JPWcreate');
            var $bill = $('button#JPWbill');
            var PIN = null;
            $create.click(function () {
                $create.prop('disabled', true);
                swal({
                    text: 'Enter the desired Jambopay wallet PIN',
                    content: "input",
                    button: {
                        text: "Create Wallet",
                        closeModal: false
                    }
                }).then(function (name) {
                    if (!name) throw null;
                    PIN = name;
                    return fetch("<?=route('api.finance.wallet.create', $patient->id)?>?pin=" + name);
                }).then(function (results) {
                    return results.json();
                }).then(function (result) {
                    if (result.success) {
                        swal({
                            title: "Wallet created",
                            text: "Jambopay wallet has been created with pin " + PIN + ", go ahead to post bill",
                            icon: "success"
                        });
                        $create.hide();
                        $bill.show();
                    }
                    else {
                        swal("Oh no!", "There is an issue with your network", "error");
                    }
                }).catch(function (err) {
                    if (err) {
                        swal("Oh no!", "There is an issue with your network", "error");
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                });
            });
            $create.hide();
            $bill.hide();
            $.ajax({
                url: '<?=route('api.finance.wallet.check', $patient->id)?>',
                dataType: 'JSON',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        if (response.exist) {
                            $bill.show();
                        } else {
                            $create.show();
                        }
                    } else {
                        alertify.log('Cannot communicate with Jambopay. Check network');
                    }
                }
            });
        });
    </script>
</div>
