<!-- Row start -->
<?php
$who = \Illuminate\Support\Facades\Input::get('who') ?? null;
?>
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Search</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            Insurance Company
                        </label>
                        <div class="col-md-5">
                            {!! Form::select('company3',get_insurance_companies(), $who, ['class' => 'form-control company', 'placeholder' => 'Choose...']) !!}
                            <span class="help-block">Select an insurance company to dispatch or receive payment for invoices.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('select[name=company3]').change(function () {
        if (this.value) {
            window.location = '?who=' + this.value;
        }
    });
</script>
<!-- Row end -->
