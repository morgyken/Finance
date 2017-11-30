@extends('layouts.app')
@section('content_title','Deposit Funds')
@section('content_description','Receive payment from patient')

@section('content')
{!! Form::open(['id'=>'payForm','route'=>'finance.evaluation.pay.save','autocomplete'=>'off'])!!}
<input type="hidden" name="deposit" value="1">
<div class="box box-info">
    <div class="panel panel-info">
        <div class="panel-heading">
            <i class="fa fa-user"></i> {{ $patient->full_name }}
            <span class="pull-right">Balance (Kshs):
                <span id="all"><b>{{ $patient->account ?$patient->account->balance : 0}}</b></span>
            </span>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    @include('finance::evaluation.form')
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close()!!}
<script type="text/javascript">
    function remove_bill(type, id, visit) {
        $.ajax({
            type: 'get',
            url: "{{route('api.finance.evaluation.bill.remove')}}",
            data: {type: type, id: id, visit: visit},
            success: function (response) {
                location.reload();
            }
        }); //ajax
    }

    function undo_remove_bill(type, id, visit) {
        $.ajax({
            type: 'get',
            url: "{{route('api.finance.evaluation.bill.undoremove')}}",
            data: {type: type, id: id, visit: visit},
            success: function (response) {
                location.reload();
            }
        }); //ajax
    }
</script>

<script src="{{m_asset('evaluation:js/payments.js')}}"></script>
<style type="text/css">
#visits tbody tr.highlight {
    background-color: #B0BED9;
}
</style>
@endsection