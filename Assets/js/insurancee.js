$(function () {
    $("#action-btn").hide();
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
                var options = '<option value="">Select scheme</option>';
                $.each(data, function (key, value) {
                    options += '<option value="' + key + '">' + value + '</option>';
                });
                $("select[name=scheme]").html(options);
                $('#scheme').show();
                $("select[name=scheme]").val(THE_SCHEME);
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

    $("select[name=company]").change();
});