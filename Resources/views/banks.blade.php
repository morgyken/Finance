<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Kiptoo Bravo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>


@extends('layouts.app')
@section('content_title','Banks')
@section('content_description','manage banks')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">

        <div class="row">
            <div class="col-md-8">
                <center>
                    <form method="post" <?php if (isset($data['editMode'])) { ?> action="{{route('finance.gl.bank.edit', $data['bank']->id)}}" <?php } else { ?> action="{{route('finance.gl.banks')}}"<?php } ?> >
                        <?php if (isset($data['editMode'])) { ?>
                            <input type="hidden" name="id"<?php if (isset($data['bank'])) { ?> value="{{$data['bank']->id}}" <?php } ?>>
                        <?php } ?>
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <label class="control-label col-md-4">Bank Name</label>
                        <div class="col-md-8">
                            <input required="" placeholder="Bank name i.e. KCB" type="text" name="bank" <?php if (isset($data['bank'])) { ?> value="{{$data['bank']->name}}" <?php } ?> class="form-control">
                            <br>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div><br>
                    </form>
                </center>
            </div>
        </div>

        <div class="col-md-12">
            @if($data['banks']->isEmpty())
            <p class="text-info"><i class="fa fa-info"></i> No banks have been added yet!</p>
            @else
            <table class="table table-responsive">
                <tbody>
                    <?php $n = 0 ?>
                    @foreach($data['banks'] as $b)
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$b->name}}</td>
                        <td>
                            <a href="{{route('finance.gl.bank.edit',$b->id)}}">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('finance.gl.banks.del',$b->id)}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Edit</th>
                        <th>Trash</th>
                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
