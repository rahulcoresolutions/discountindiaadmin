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

{!! Form::open(array('files' => true, 'route' => config('coreadmin.route').'.subcategory.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')) !!}

<div class="form-group">
    {!! Form::label('title', 'Title*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('title', old('title'), array('class'=>'form-control' , 'placeholder' => 'Title')) !!}
        
    </div>
</div>
<div class="form-group">
    {!! Form::label('attachment', 'Attachment*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::file('attachment') !!}
        
    </div>
</div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-2  " style="margin: 0 ; padding: 0" >
                {!! Form::label('offers', 'Select Merchants*', array('class'=>'col-sm-2 control-label labelData')) !!}
            </div>
            <div class="col-md-10">
                <div class="row">
                    @foreach( $offers as $k => $v )
                        <div class="col-md-3">
                            <label><input type="checkbox" class="form-control" name="offers[]" value="{{ $v->id }}" style="width: 50px;padding: 0;margin: 0;float: left;"> {{ $v->title }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection