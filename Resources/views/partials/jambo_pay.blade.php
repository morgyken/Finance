<h4>Jambopay</h4>
<div>
    <div id="wallet_op">
        <div class="form-group">
            <label class="col-md-4 control-label">Amount</label>
            <div class="col-md-8">
                {!! Form::text('JPAmount',old('JPAmount'),['class'=>'form-control','placeholder'=>'Jambopay Amount']) !!}
            </div>
        </div>

    </div>

    <div class="pull-right">
        {{--<button type="button" class="btn btn-xs btn-primary" id="JPWcreate">Create Wallet</button>--}}
        <button type="button" class="btn btn-xs btn-primary" id="JPWbill">Post Bill</button>
        <button type="button" class="btn btn-xs btn-primary" id="JPWstatus">Check Bill Status</button>
        <div class="loader" id="jpLoader"></div>
    </div>

    <style>
        .swal-overlay {
            background-color: rgba(30, 30, 30, 0.9);
            /*background-color: red;*/
        }
    </style>
    <script>
        $(function () {
            var $loader = $('#jpLoader');
            var ACTIVE_BILL = null;
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
                    beforeSend: function () {
                        $loader.show();
                    },
                    success: function (response) {
                        $loader.hide();
                        if (response.success) {
                            $billStatus.show();
                            $bill.hide();
                            var obj = JSON.parse(response.bill);
                            ACTIVE_BILL = obj.BillNumber;
                            swal({
                                title: "Bill Posted!",
                                text: "Request the customer to complete transaction. " +
                                "Bill ID is " + obj.BillNumber,
                                button: "Nice",
                                icon: "info",
                                timer: 10000
                            });
                        } else {
                            swal(
                                {
                                    title: 'Oh No!',
                                    text: response.error,
                                    icon: 'error'
                                }
                            );
                        }
                    }
                    ,
                    error: function () {
                        swal(
                            {
                                title: 'Oh No!',
                                text: "Network issue",
                                icon: 'error'
                            }
                        );
                    }
                })
                ;
            });
            $billStatus.click(function () {
                $.ajax({
                    url: '<?=route('api.finance.wallet.status', $patient->id)?>',
                    dataType: 'JSON',
                    type: 'POST',
                    data: {
                        bill: ACTIVE_BILL
                    },
                    beforeSend: function () {
                        $billStatus.hide();
                        $loader.show();
                    },
                    success: function (response) {
                        $billStatus.show();
                        $loader.hide();
                        if (response.success) {
                            alertify.success("Bill stated: " + response.status.PaymentStatusName);
                        } else {
                            alertify.log(response.error);
                        }
                    },
                    error: function () {
                        swal(
                            {
                                title: 'Oh No!',
                                text: "Network issues",
                                icon: 'error'
                            }
                        );
                    }
                });
            });
            $create.hide();
            $bill.hide();
            $billStatus.hide();
            $.ajax({
                url: '<?=route('api.finance.wallet.check', $patient->id)?>',
                dataType: 'JSON',
                type: 'GET',
                beforeSend: function () {
                    $loader.show();
                },
                success: function (response) {
                    $loader.hide();
                    if (response.success) {
                        if (response.exist) {
                            $bill.show();
                        } else {
                            $('#wallet_op').html("<span class='text-warning'>Patient has no jambopay wallet</span>");
                            $create.show();
                        }
                    } else {
                        alertify.log(response.error);
                    }
                },
                error: function (data) {
                    $('#wallet_op').html("<span class='text-warning'>Cannot contact jambopay for wallet information</span>");
                    swal(
                        {
                            title: 'Oh No!',
                            text: "Network error",
                            icon: 'error'
                        }
                    );
                }
            });
        });
    </script>
</div>
