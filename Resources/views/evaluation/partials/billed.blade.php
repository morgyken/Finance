@if(!$billed->isEmpty())
{!! Form::open(['class'=>'form-horizontal', 'route'=>'finance.evaluation.dispatch']) !!}
<table class="table table-stripped">
    <thead>
        <tr>
            <th>#</th>
            <th>Dispatch</th>
            <th>Patient</th>
            <th>Visit</th>
            <th>Company</th>
            <th>Scheme</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $t = 0; ?>
        @foreach($billed as $visit)
        <?php $t+= $visit->unpaid_amount ?>
        <tr>
            <td>{{$visit->id}}</td>
            <td>
                <input onclick="updateAmount({{$visit->unpaid_amount}}, {{$visit->id}})" id="check{{$visit->id}}" type="checkbox" name="visit[]" value="{{$visit->id}}">
            </td>
            <td>{{$visit->patients->full_name}}</td>
            <td>{{(new Date($visit->created_at))->format('dS M y g:i a')}} - Clinic {{$visit->clinics->name}}</td>
            <td>{{$visit->patient_scheme->schemes->companies->name}}</td>
            <td>{{$visit->patient_scheme->schemes->name}}</td>
            <td>
                {{$visit->unpaid_amount}}
                <input type="hidden" name="amount[]" value="{{$visit->unpaid_amount}}">
            </td>
            <td>
                <a href="{{route('finance.evaluation.cancel', $visit->id)}}" class="btn btn-xs btn-danger">
                    <i class="fa fa-times"></i> Cancel</a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><input type="submit" class="btn-primary" value="Dispatch Selected Invoices"></td>
            <td colspan="2">Dispatch Total: <input id="dis_tot" disabled="disabled" size="7" value="0.00"></td>
            <td colspan="2"><!-- Balance: <input id="bal" disabled="disabled" size="7" value=""> --></td>
            <td style="text-align: right">Total Bill:</td>
            <td>
                <input id="sum" disabled="disabled" size="10" value="{{number_format($t,2)}}">
            </td>
        </tr>
    </tfoot>
</table>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
    try {
    $('#bills').dataTable();
    } catch (e) {
    }
    });
    function updateAmount(amount, i) {
    $amount = $('#dis_tot');
    $bal = $('#bal');
    $sum = $('#sum');
    if ($('#check' + i).is(':checked')) {
    $amount.val(parseInt($amount.val(), 10) + amount);
    $bal.val($sum.val());
    } else {
    $amount.val(parseInt($amount.val(), 10) - amount);
    }
    }
</script>
@else
<p>No billed insurance bills</p>
@endif