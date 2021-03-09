@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <h1>{{ trans('coreadmin::admin.users-edit-edit_user') }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        {!! implode('', $errors->all('
                        <li class="error">:message</li>
                        ')) !!}
                    </ul>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['route' => ['users.update', $user->id], 'class' => 'form-horizontal', 'method' => 'PATCH']) !!}
    <div class="form-group">
        {!! Form::label('name', trans('coreadmin::admin.users-edit-name'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('name', old('name', $user->name), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-name_placeholder')]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('email', trans('coreadmin::admin.users-edit-email'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::email('email', old('email', $user->email), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-email_placeholder')]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('password', trans('coreadmin::admin.users-edit-password'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::password('password', ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-password_placeholder')]) !!}
        </div>
    </div>
    
    <div class="form-group">
        {!! Form::label('role_id', trans('coreadmin::admin.users-edit-role'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('role_id', $roles, $user->role_id, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('plan_id', 'Plan', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <select name="plan_id" class='form-control'>
                <option value="0">Select Plan</option>
                @if( $plan != null )

                    @foreach($plan->toArray() as $k => $v)
                        <option {{ ($user->plan_id == $k ) ? 'selected' : ''}} value="{{ $k }}">
                            {{ $v }}
                        </option>
                    @endforeach
                @endif
            </select>
            {{-- {!! Form::select('plan_id', $plan, old('plan_id', $user->plan_id), ['class'=>'form-control']) !!} --}}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('belongs_to', 'Belongs To', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            <select name="belongs_to" class='form-control'>
                <option value="0">Select belongs to</option>
                @if( $plan != null )

                    @foreach($offers as $k => $v)
                        <option {{ ($user->offerId == $v->id ) ? 'selected' : ''}} value="{{ $v->id }}">
                            {{ $v->title }}
                        </option>
                    @endforeach
                @endif
            </select>
            {{-- {!! Form::select('plan_id', $plan, old('plan_id', $user->plan_id), ['class'=>'form-control']) !!} --}}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('mobile', 'Mobile', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('mobile', old('mobile', $user->mobile), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-name_placeholder')]) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            {!! Form::submit(trans('coreadmin::admin.users-edit-btnupdate'), ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    
    {!! Form::close() !!}
@endsection