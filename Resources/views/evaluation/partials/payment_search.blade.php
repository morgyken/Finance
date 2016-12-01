<!-- Row start -->

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
                            {!! Form::select('company',get_insurance_companies(), null, ['class' => 'form-control company', 'placeholder' => 'Choose...']) !!}
                            <span class="help-block">Select an insurance company to dispatch or receive payment for invoices.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
