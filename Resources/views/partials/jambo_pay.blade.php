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
        <button type="button" class="btn btn-xs btn-primary" id="JPWstatus">Check Bill Status</button>
    </div>
    <style>
        .swal-overlay {
            background-color: rgba(30, 30, 30, 0.9);
            /*background-color: red;*/
        }
    </style>
    <script>
        $(function () {
            var $create = $('button#JPWcreate');
            var $bill = $('button#JPWbill');
            var $billStatus = $('button#JPWstatus');
            var PIN = null;
            $create.click(function () {
                $create.prop('disabled', true);
                swal({
                    text: 'Enter the desired Jambopay wallet PIN',
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "Enter the walllet PIN",
                            type: "text"
                        }
                    },
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
            $bill.click(function () {
                var JPAmount = $('input[name=JPAmount]').val();
                if (!JPAmount) {
                    alertify.error("Please enter amount to bill");
                    return;
                }
                $bill.hide();
                $.ajax({
                    url: '<?=route('api.finance.wallet.post', $patient->id)?>',
                    dataType: 'JSON',
                    type: 'POST',
                    data: {
                        amount: parseInt(JPAmount)
                    },
                    success: function (response) {
                        if (response.success) {
                            $billStatus.show();
                            $bill.hide();
                            swal({
                                title: "Bill Posted to Jambopay!",
                                text: "Please request the customer to complete transaction via USSD or app",
                                button: "Nice",
                                icon: "info",
                                timer: 10000
                            });
                        } else {
                            swal(
                                {
                                    title: 'Oh No!',
                                    text: "Cannot reach Jambopay server, please check connection",
                                    icon: 'error'
                                }
                            );
                        }
                    }
                    ,
                    error: function (data) {
                        swal(
                            {
                                title: 'Oh No!',
                                text: data,
                                icon: 'error'
                            }
                        );
                    }
                })
                ;
            });
            $billStatus.click(function () {
                swal({
                    icon: 'warning',
                    text: 'Bill is still pending',
                    title: "Pending Still"
                });
                /*  $.ajax({
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
                    },
                    error: function (data) {
                        swal(
                            {
                                title: 'Oh No!',
                                text: data,
                                icon: 'error'
                            }
                        );
                    }
                });*/
            });
            $create.hide();
            $bill.hide();
            $billStatus.hide();
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
                },
                error: function (data) {
                    swal(
                        {
                            title: 'Oh No!',
                            text: data,
                            icon: 'error'
                        }
                    );
                }
            });
        });
    </script>
</div>
