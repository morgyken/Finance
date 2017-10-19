<!-- Row start -->
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Search</h3>
            </div>

            <div class="panel-body">
                <form class="form-horizontal" action="#">
                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            Insurance Company
                        </label>
                        <div class="col-md-5">
                            {!! Form::select('company',get_insurance_companies(), null, ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        </div>
                    </div>
                    <div class="form-group" id="scheme">
                        <label class="col-md-2 control-label">
                            Scheme
                        </label>
                        <div class="col-md-5">
                            {!! Form::select('scheme',[], null, ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                            <span class="help-block">Select an insurance company for action.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            Time Period
                        </label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-xs-3">
                                    <input type='text' id="date1" placeholder="Date 1" name='date1'>
                                </div>
                                <div class="col-xs-4 col-md-3">
                                    <input type='text' id="date2" style="float: right" placeholder="Date 2"
                                           name='date2'>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
