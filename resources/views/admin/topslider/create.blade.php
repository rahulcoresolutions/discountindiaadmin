@extends('admin.layouts.master')

@section('content')
<style>
    ul{
        list-style: none;
    }
</style>
<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1>{{ trans('coreadmin::templates.templates-view_create-add_new') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                </ul>
        	</div>
        @endif
    </div>
</div>

{!! Form::open(array('files' => true, 'route' => config('coreadmin.route').'.topslider.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')) !!}

<div class="form-group">
    {!! Form::label('attachment', 'Attachment*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::file('attachment') !!}
        
    </div>
</div><div class="form-group">
    {!! Form::label('active', 'Active*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        <ul>
            <li>
                <label id="yes">{!! Form::radio('active', '1', true ) !!} &nbsp;&nbsp;&nbsp;Yes </label>
            </li>
            <li>
                <label id="no">{!! Form::radio('active', '0', false) !!} &nbsp;&nbsp;&nbsp;No</label>
            </li>
        </ul>
        
        
        
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection