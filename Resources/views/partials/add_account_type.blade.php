<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="form-group">
            <label class="control-label col-md-4">Name:</label>
            <div class="col-md-8">
                {!! Form::text('name',old('name',$data['group']->name),['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-4">Description:</label>
            <div class="col-md-8">
                {!! Form::textarea('description',old('description',$data['group']->description),['class'=>'form-control','rows'=>3]) !!}
            </div>
        </div>
        <div class="pull-right">
            <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
