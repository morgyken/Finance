<!-- Row start -->
<?php
use \Illuminate\Support\Facades\Input;
$_get = (object)Input::get();
?>
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <i class="icon-calendar"></i>
                <h3 class="panel-title">Search</h3>
            </div>

            <div class="panel-body">
                <form class="form-horizontal" action="#">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">
                                    Insurance Company
                                </label>
                                <div class="col-md-8">
                                    {!! Form::select('company',get_insurance_companies(), $_get->company?? null, ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="scheme">
                                <label class="control-label col-md-4">
                                    Scheme
                                </label>
                                <div class="col-md-8">
                                    {!! Form::select('scheme',[''=>'Choose insurance company'], null, ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">
                                    Start Date
                                </label>
                                <div class="col-md-8">
                                    <div>
                                        <input type='text' id="date1" placeholder="Start Date" name='date1'
                                               class="form-control" value="{{$_get->date1??null}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">
                                    End Date
                                </label>
                                <div class="col-md-8">
                                    <input type='text' id="date2" placeholder="End Date"
                                           name='date2' class="form-control" value="{{$_get->date2??null}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var THE_SCHEME = "{{$_get->scheme?? null}}";
</script>
<!-- Row end -->
