@if(!empty($__visits))
<div class="accordion">
    @foreach($__visits as $visit)
    <h3>{{(new Date($visit->created_at))->format('dS M y g:i a')}} -
        Clinic {{$visit->clinics->name}}</h3>
    <div id="visit{{$visit->id}}">
        <table class="table table-condensed" id="paymentsTable">
            <tbody>
                @include('finance::evaluation.payment.main')
            </tbody>
        </table>
        <table class="table table-condensed" id="paymentsTable">
            <tbody>
                @include('finance::evaluation.payment.pharm')
            </tbody>
        </table>
    </div>
    @endforeach
</div>
@else
<div class="alert alert-info">
    <i class="fa fa-info"></i> This patient has not been billed.
    Click <a href="{{route('finance.receive_payments')}}">here </a> for a list of patient with
    pending bills.
</div>
@endif
