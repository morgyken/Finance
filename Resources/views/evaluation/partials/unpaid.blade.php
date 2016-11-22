
@if(!$unpaid->isEmpty())
<table class="table table-stripped">
    <thead>
        <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Visit</th>
            <th>Company</th>
            <th>Scheme</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($unpaid as $visit)
        <tr>
            <td>{{$visit->id}}</td>
            <td>{{$visit->patients->full_name}}</td>
            <td>{{(new Date($visit->created_at))->format('dS M y g:i a')}} - Clinic {{$visit->clinics->name}}</td>
            <td>{{$visit->patient_scheme->schemes->companies->name}}</td>
            <td>{{$visit->patient_scheme->schemes->name}}</td>
            <td>{{$visit->unpaid_amount}}</td>
            <td><a href="" class="btn btn-xs btn-primary"><i class="fa fa-usd"></i> Bill</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<br>
<p>No unpaid insurance bills</p>
@endif