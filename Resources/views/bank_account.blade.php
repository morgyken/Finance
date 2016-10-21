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
@section('content_title','Bank Accounts')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <center>
                    <form method="post"
                    <?php if (isset($data['edit_mode'])) { ?>
                              action="{{route('finance.gl.bank.account.edit', $data['account']->id)}}"
                          <?php } ?>
                          action="{{route('finance.gl.bank.accounts')}}"
                          >
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <label class="control-label col-md-4">Bank</label>
                        <div class="col-md-8">
                            <select required="" type="text" name="bank" class="form-control">
                                @foreach($data['banks'] as $b)
                                <option value="{{$b->id}}">{{$b->name}}</option>
                                @endforeach
                            </select>
                            <br>
                        </div>

                        <label class="control-label col-md-4">Account Name</label>
                        <div class="col-md-8">
                            <input required="" type="text" name="name" <?php if (isset($data['account'])) { ?> value="{{$data['account']->name}}" <?php } ?> class="form-control">
                            <br>
                        </div>

                        <label class="control-label col-md-4">Account Number</label>
                        <div class="col-md-8">
                            <input required="" type="text" name="number" <?php if (isset($data['account'])) { ?> value="{{$data['account']->number}}" <?php } ?> class="form-control">
                            <br>
                        </div>

                        <label class="control-label col-md-4">Balance</label>
                        <div class="col-md-8">
                            <input type="text" placeholder="Optional" name="balance" <?php if (isset($data['account'])) { ?> value="{{$data['account']->balance}}" <?php } ?> class="form-control">
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
            @if($data['accounts']->isEmpty())
            <p class="text-info"><i class="fa fa-info"></i> No accounts added!</p>
            @else
            <table class="table table-responsive">
                <tbody>
                    @foreach($data['accounts'] as $a)
                    <tr>
                        <td>{{$a->id}}</td>
                        <td>{{$a->name}}</td>
                        <td>{{$a->number}}</td>
                        <td>{{$a->banks->name}}</td>
                        <td>{{$a->balance}}</td>
                        <td>
                            <a href="{{route('finance.gl.bank.account.edit',$a->id)}}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </td>
                        <td>
                            <a href="{{route('finance.gl.bank.account.del',$a->id)}}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Bank</th>
                        <th>Balance</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
