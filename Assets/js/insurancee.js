$(function () {
    $("#action-btn").hide();
    $('#scheme').hide();
    $("#action-scene").html('<span class="label label-danger">Select an Insurance Firm for action</span>');

    $("select[name=company]").change(function () {
        if (!this.value) {
            $('#scheme').hide();
            return;
        }
        $.ajax({
            url: SCHEMES_URL,
            data: {'id': this.value},
            success: function (data) {
                var options = null;
                $.each(data, function (key, value) {
                    options += '<option value="' + key + '">' + value + '</option>';
                });
                $("select[name=scheme]").html(options);
                $('#scheme').show();
            }
        });
    });

    function getInvs(id) {
        get_invoices(id);
        if (mode === 'payment') {
            $("#action-scene").html('<input type="submit" class="btn-primary" id="action-btn" value="Receive Payment">');
        } else {
            $("#action-scene").html('<input type="submit" class="btn-primary" value="Dispatch Selected Invoices" >');
        }
    }

    $(".cheque_amount").keyup(function () {
        $('#pay_balance').val(this.value);
    });

    $("#cheque_no").keyup(function () {
        $('#paycheck_no').val(this.value);
    });


    $("#payment_table").mouseover(function () {
        //$('#pay_balance').val($(".cheque_amount").val());
    });

    $("#date1").datepicker({
        dateFormat: 'yy-mm-dd', onSelect: function (date) {
            $("#date2").datepicker('option', 'minDate', date);
        }
    });
    $("#date2").datepicker({
        dateFormat: 'yy-mm-dd'
    });


    function get_invoices() {
        //initialize
        var mode = $('#mode').val();
        var firm = $('select[name=company]').val();
        var scheme = $('#scheme').val();
        var date1 = $('#date1').val();
        var date2 = $('#date2').val();
        $.ajax({
            type: 'get',
            url: "{{route('api.finance.evaluation.firm.invoices')}}",
            data: {firm: firm, mode: mode, date1: date1, date2: date2, scheme: scheme},
            success: function (response) {
                $('.response').html(response);
            }
        }); //ajax
    }

    function updateAmount(amount, i) {
        $amount = $('#pay_dis_tot');
        $sum = $('#pay_sum');
        $balance = $('#pay_balance');
        if ($('#pay_check' + i).is(':checked')) {
            $amount.val(parseInt($amount.val(), 10) + amount);
            $balance.val(parseInt($balance.val(), 10) - amount);
        } else {
            $amount.val(parseInt($amount.val(), 10) - amount);
            $balance.val(parseInt($balance.val(), 10) + amount);
        }
    }

});