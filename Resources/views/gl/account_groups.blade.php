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
@section('content_title','General Ledger Account Groups')
@section('content_description','General ledger account groups')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <div class="box-body">
        @include('finance::partials.add_group')
        <div class="col-md-12">
            @if($data['groups']->isEmpty())
            <p class="text-info"><i class="fa fa-info"></i> No accounts added!</p>
            @else
            <table class="table table-responsive">
                <tbody>
                    @foreach($data['groups'] as $group)
                    <tr>
                        <td>{{$group->id}}</td>
                        <td>{{$group->name}}</td>
                        <td>{{$group->types->name}}</td>
                        <td><a href="{{route('finance.gl.account_groups',$group->id)}}">
                                <i class="fa fa-edit"></i> Edit
                            </a></td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Group</th>
                        <th></th>

                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
