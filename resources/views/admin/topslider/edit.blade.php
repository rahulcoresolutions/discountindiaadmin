@extends('admin.layouts.master')

@section('content')

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

{!! Form::model($topslider, array('files' => true, 'class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('coreadmin.route').'.topslider.update', $topslider->id))) !!}

<div class="form-group">
    {!! Form::label('attachment', 'Attachment', array('class'=>'col-sm-2 control-label')) !!}
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
      {!! Form::submit(trans('coreadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')) !!}
      {!! link_to_route(config('coreadmin.route').'.topslider.index', trans('coreadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection