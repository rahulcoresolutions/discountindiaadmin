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

{{-- {!! Form::open(array('route' => 'get.voucher.details', 'id' => 'form-with-validation', 'class' => 'form-horizontal')) !!} --}}
<form id='form-with-validation' class ='form-horizontal' method="GET" action="{{ route('get.voucher.details') }}">

    <div class="form-group">
        {!! Form::label('customer_unique_id', 'Customer Id*', array('class'=>'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!! Form::text('customer_unique_id', old('customer_unique_id'), array('class'=>'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('voucher_unique_id', 'Voucher Id*', array('class'=>'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!! Form::text('voucher_unique_id', old('voucher_unique_id'), array('class'=>'form-control')) !!}
        </div>
    </div>
    
    {{-- <div class="form-group">
        {!! Form::label('status', 'Status*', array('class'=>'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
            {!! Form::text('status', old('status'), array('class'=>'form-control')) !!}
            
        </div>
    </div> --}}
    
    <input type="hidden" name="status" value="1">

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <button type="submit" class="getVoucherDetails">Get Details</button>
        </div>
    </div>
{!! Form::close() !!}
@section('javascript')
{{-- <script type="text/javascript">
    $(document).ready(function(){
        $('.getVoucherDetails').click(function(){
            $.ajax({
                url : "{{ route('get.voucher.details') }}",
                type : "GET",
                data : {id : $('input[name=voucher_unique_id]').val()},
                success : function(res){
                    console.log(res);
                }
            });
        });
    });

    
</script> --}}
@endsection
@endsection