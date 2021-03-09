@extends('admin.layouts.master')

@section('content')
<style>
    .labelData{
        width: 100%;
        text-align: right;
        padding: 0;
        margin: 0;
    }
</style>
<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1>{{ trans('coreadmin::templates.templates-view_edit-edit') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                </ul>
        	</div>
        @endif
    </div>
</div>

{!! Form::model($subcategory, array('files' => true, 'class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('coreadmin.route').'.subcategory.update', $subcategory->id))) !!}

<div class="form-group">
    {!! Form::label('title', 'Title', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('title', old('title',$subcategory->title), array('class'=>'form-control')) !!}
        
    </div>
</div>
<div class="form-group">
    {!! Form::label('attachment', 'Attachment', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::file('attachment') !!}
        
    </div>
</div>

@php
    $selectedOffers = json_decode($subcategory->offers);
@endphp


<div class="form-group">
    <div class="row">
        <div class="col-md-2  " style="margin: 0 ; padding: 0" >
            {!! Form::label('offers', 'Select Merchants*', array('class'=>'col-sm-2 control-label labelData')) !!}
        </div>
        <div class="col-md-10">
            <div class="row">
                @foreach( $offers as $k => $v )
                    <div class="col-md-3">
                        @if( in_array( $v->id , $selectedOffers ) )
                            <label><input type="checkbox" class="form-control" checked name="offers[]" value="{{ $v->id }}" style="width: 50px;padding: 0;margin: 0;float: left;"> {{ $v->title }}</label>
                        @else
                            <label><input type="checkbox" class="form-control" name="offers[]" value="{{ $v->id }}" style="width: 50px;padding: 0;margin: 0;float: left;"> {{ $v->title }}</label>
                        @endif
                        
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit(trans('coreadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')) !!}
      {!! link_to_route(config('coreadmin.route').'.subcategory.index', trans('coreadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection