@if(!empty($__visits))
    <div class="accordion">
        @foreach($__visits as $visit)
            <h3>{{$visit->created_at->format('dS M y g:i a')}} -
                Clinic {{$visit->clinics->name}}</h3>
            <div id="visit{{$visit->id}}">
                <table class="table table-condensed" id="paymentsTable">
                    <tbody>
                    @if($visit->payment_mode==='insurance')
                        @include('finance::evaluation.payment.main-insurance')
                        @include('finance::evaluation.payment.pharmacy-insurance')
                        @include('finance::evaluation.payment.copay')
                    @else
                        @include('finance::evaluation.payment.main')
                        @include('finance::evaluation.payment.pharmacy')
                    @endif
                    @if(is_module_enabled('Inpatient'))
                        @include('finance::evaluation.payment.inpatient')
                    @endif
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
