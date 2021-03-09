@extends('admin.layouts.master')

@section('content')

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

{!! Form::open(array('files' => true, 'route' => config('coreadmin.route').'.hotdeals.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')) !!}

{{-- <div class="form-group">
    {!! Form::label('voucher_id', 'Voucher*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('voucher_id', old('voucher_id'), array('class'=>'form-control')) !!}
        
    </div>
</div> --}}
<div class="form-group">
    {!! Form::label('category', 'Select Category*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {{-- {!! Form::text('category', old('category'), array('class'=>'form-control')) !!} --}}
        <select class="form-control" name="category">
            @foreach($categories as $k => $v)
                <option value="{{ $v->id }}">{{ $v->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    {!! Form::label('offers', 'Select Offer*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {{-- {!! Form::text('offers', old('offers'), array('class'=>'form-control')) !!} --}}
        <select class="form-control" name="offers">
                <option value="0" class="select0">Select</option>
            @foreach($offer as $k => $v)
                <option value="{{ $v->id }}" class="cat_{{ $v->category }}">{{ $v->title }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    {!! Form::label('vouchers', 'Select Voucher*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {{-- {!! Form::text('vouchers', old('vouchers'), array('class'=>'form-control')) !!} --}}
        <select class="form-control" name="voucher_id">
            <option value="0" class="select0">Select</option>
            @foreach($vouchers as $k => $v)
                <option value="{{ $v->id }}" class="offer_{{ $v->voucher_of }}">{{ $v->title }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    {!! Form::label('banner', 'Banner*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::file('banner') !!}
        
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')) !!}
    </div>
</div>

{!! Form::close() !!}
    @section('javascript')
        <script type="text/javascript">
            $(document).ready(function(){
                $('select[name=category]').change(function(){
                    $('select[name=offers] .select0').attr('selected' , 'selected');
                    $('select[name=voucher_id] .select0').attr('selected' , 'selected');
                    let selectedCategory = $(this).val();

                    $('select[name=offers] option').hide();
                    $('select[name=offers] .cat_'+selectedCategory).show();
                });
                $('select[name=offers]').change(function(){
                    $('select[name=voucher_id] .select0').attr('selected' , 'selected');
                    let selectedCategory = $(this).val();
                    console.log(selectedCategory);

                    $('select[name=voucher_id] option').hide();
                    $('select[name=voucher_id] .offer_'+selectedCategory).show();
                });
            });
        </script>
    @endsection
@endsection