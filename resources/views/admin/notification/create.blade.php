@extends('admin.layouts.master')

@section('content')
    <style type="text/css">
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){
            width: 82% !important
        }
        .bootstrap-select.btn-group:not(.input-group-btn){
            padding-left: 15px
        }
    </style>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <h1>Create Notification</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {!! Form::open(['route' => 'store.notification', 'class' => 'form-horizontal']) !!}

    <div class="form-group">
        {!! Form::label('message', 'Message', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('message', old('message'), ['class'=>'form-control', 'placeholder'=> "Notification"]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('redirect', 'Redirect To', ['class'=>'col-sm-2 control-label']) !!}
        <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="redirect_url">
            @foreach( $voucher as $k => $v )
                <option data-subtext="{{ $v->voucher_unique_id }} ({{ $v->title }})" value="{{ $v->voucher_unique_id }}">{{ $v->voucher_unique_id }} ({{ $v->title }})</option>
            @endforeach
        </select>
    </div>

{{-- <div class="form-group">
        {!! Form::label('redirect', 'Redirect To', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('redirect', old('redirect'), ['class'=>'form-control', 'placeholder'=> "Notification"]) !!}

        </div>
    </div> --}}
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            {!! Form::submit(trans('coreadmin::admin.users-create-btncreate'), ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection


