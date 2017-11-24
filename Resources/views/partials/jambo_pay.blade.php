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
        <button type="button" class="btn btn-xs btn-primary" id="JPWstatus">Check Bill Status</button>
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
        $(function () {
            var $loader = $('#jpLoader');
            var ACTIVE_BILL = null;
            var $create = $('button#JPWcreate');
            var $bill = $('button#JPWbill');
            var $print = $('a#JPWprint');
            var $billStatus = $('button#JPWstatus');
            var PIN = null;
            var JamboPay = {
                init: function () {
                    $create.hide();
                    $bill.hide();
                    $print.hide();
                    $billStatus.hide();
                    this.checkWalletExists();
                },
                createWallet: function () {
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
                },
                postBill: function () {
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
                                $print.show();
                                $billStatus.show();
                                $bill.hide();
                                ACTIVE_BILL = response.bill.BillNumber;
                                $print.attr('href', "{{route('finance.evaluation.ins.rcpt.print_jp')}}?bill=" + ACTIVE_BILL);
                                swal({
                                    title: "Bill Posted!",
                                    text: "Request the customer to complete transaction. " +
                                    "Bill ID is " + ACTIVE_BILL,
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
                },
                checkBillStatus: function () {
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
//                            JP_PAID = true;
                                alertify.success("Bill stated: " + response.status.PaymentStatusName);
                                if (response.status.PaymentStatus == '1') {
                                    JP_PAID = true;
                                }
                                if (JP_PAID) {
                                    $billStatus.hide();
                                    $('input[name=JPAmount]').prop('readonly', true);
                                    $('input[name=JPid]').val(ACTIVE_BILL);
                                    show_information();
                                }
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
                },
                checkWalletExists: function () {
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
                                if (!response.exist) {
                                    $('#wallet_op').html("<p class='text-warning'><i class='fa fa-info'></i> Patient has no jambopay wallet</p>");
//                            $create.show();
                                }
                                $bill.show();
                            } else {
                                alertify.log(response.error);
                            }
                        },
                        error: function () {
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
                }
            };
            $create.click(function () {
                JamboPay.createWallet();
            });
            $bill.click(function () {
                JamboPay.postBill();
            });
            $billStatus.click(function () {
                JamboPay.checkBillStatus();
            });
            JamboPay.init();
        });
    </script>
</div>
