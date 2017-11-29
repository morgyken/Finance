var JP_PAID = false;

function show_information() {
    function calculate_cost_array() {
        var total = 0;
        $('#bloodyMoves').find('tr').each(function () {
            if ($(this).find('input:checkbox').is(':checked')) {
                total += parseInt($(this).find('span.topay').html());
            }
        });
        return total;
    }

    function sumPayments() {
        function parser(j) {
            return parseInt(j) || 0;
        }

        // var cash = parser($('input[name=CashAmount]').val());
        // var mpesa = parser($('input[name=MpesaAmount]').val());
        // var cheque = parser($('input[name=ChequeAmount]').val());
        // var card = parser($('input[name=CardAmount]').val());
        var cash = parser($('#cash_amount').val());
        var mpesa = parser($('#mpesa_mount').val());
        var cheque = parser($('#cheque_amount').val());
        var card = parser($('#card_amount').val());
        var jp = 0;
        if (JP_PAID)
            jp = parser($('input[name=JPAmount]').val());
        return (cash + mpesa + cheque + card + jp);
    }


    var selected_payments = calculate_cost_array();
    var to_pay = sumPayments();
    var needed = selected_payments - to_pay;
    $('#total').html("Total: Ksh " + selected_payments);
    $('#all').html("Total Payments: <strong>Ksh " + to_pay + "</strong>");
    $('#balance').html('');
    $('#saver').prop('disabled', false);
    if (needed > 0) {
        $('#balance').html("Balance: <strong style='color:red;'>Ksh " + needed + "</strong>");
        $('#saver').prop('disabled', true);
    } else {
        $('#balance').html("Change: <strong style='color:blue;'>Ksh " + (-needed) + "</strong>");
    }
}

$(function () {
    $('#payForm').find('input').keyup(function () {
        show_information();
    });


    $('input').on('ifChanged', function () {
        show_information();
    });


    $('#paymentsTable').find('input:radio, input:checkbox').prop('checked', false);
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-blue',
        increaseArea: '20%'
    });
    $('#saver').prop('disabled', true);
    $(".accordion").accordion({
        heightStyle: "content"
    });
    $('.datepicker').datepicker({maxDate: 0, changeMonth: true});
});
