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


@extends('layouts.app')
@section('content_title','General Ledger Account')
@section('content_description','General ledger accounts')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">
        @include('finance::partials.add_account')
        <div class="col-md-12">
            @if($data['groups']->isEmpty())
            <p class="text-info"><i class="fa fa-info"></i> No groups added!</p>
            @else
            <table class="table table-responsive">
                <tbody>
                    @foreach($data['groups'] as $group)
                    <tr>
                        <td>{{$group->id}}</td>
                        <td>{{$group->name}}</td>
                        <td>{{$group->groups->name}}</td>
                        <td><a href="{{route('finance.gl.accounts',$group->id)}}">
                                <i class="fa fa-edit"></i> Edit
                            </a></td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th></th>

                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
