@extends('admin.layouts.master')

@section('content')
<style type="text/css">
    .image_template{
        width: 50%;
        padding: 10px
    }
    .template1 , .template2 , .template3 , .template4 , .template5{
        display: none;
    }

   	.template h2{
        font-size: 24px;
	    margin-top: 27px;
   	}
    .template1{
        display: block;
        clear: both;
    }
    .template1 .terms , .template1 .valid_date{
        padding-left: 20px;
        color: white;
        clear:both;
    }
    .template{
        height: 207px;
        background-size: 444px;
        background-repeat: no-repeat;
        max-width: 445px;

    }

    .template1{
        background-image: url({{ asset('images/1.png') }})
    }
    .template2{
        background-image: url({{ asset('images/2.png') }})
    }
    .template3{
        background-image: url({{ asset('images/3.png') }})
    }
    .template4{
        background-image: url({{ asset('images/4.png') }})
    }
    .template5{
        background-image: url({{ asset('images/Untitled-1-02.jpg') }})
    }
    .template1 .catType_icon .icon {
        float: left;
        width: 17%;
    }
    .template1 .catType_icon .title{
        padding-top: 75px
    }
    .template1 .catType_icon .icon img{
        width: 55%;
        margin-top: 50px;
        margin-left: 20px
    }
        

    .template2 .catType_icon .icon {
        float: left;
        width: 17%;
    }
    .template2 .catType_icon .title .terms{
        padding-left: 185px;
    }
    .template2 .catType_icon .title{
        padding-top: 75px;
    }
    .template2 .catType_icon .icon img{
        width: 55%;
        margin-top: 50px;
        margin-left: 20px
    }
        

    .template3 .catType_icon .icon {
        float: left;
        width: 20%;
    }
    .template3 .catType_icon .title .terms{
        padding-left: 185px;
    }
    .template3 .catType_icon .title{
        padding-top: 60px;
    }
    .template3 .catType_icon .icon img{
        width: 55%;
        margin-top: 50px;
        margin-left: 20px
    }


    .template4 .catType_icon .icon {
        float: left;
        width: 20%;
    }
    .template4 .catType_icon .title .terms{
        padding-left: 185px;
    }
    .template4 .catType_icon .title{
        padding-top: 60px;
    }
    .template4 .catType_icon .title h2{
        color: #c7af83
    }
    .template4 .catType_icon .icon img{
        width: 42%;
        margin-top: 57px;
        margin-left: 20px;
    }
    .template4 .terms_condition{
        margin-left: 20px
    }
    .template.template5 h2{
        margin-top: 0px !important
    }
    .template5{
        width: 445px;
        min-height: 147px;
    }
    .template5 .catType_icon .icon {
        float: left;
        width: 20%;
    }
    .template5 .catType_icon .title .terms{
        padding-left: 185px;
    }
    .template5 .catType_icon .title{
        padding-top: 85px;
        padding-left: 5px;
        min-height: 90px;
    }
    .template5 .catType_icon .title h2{
        font-size: 23px;
    }
    .template5 .catType_icon .title h2{
        color: #c7af83
    }
    .template5 .catType_icon .icon img{
        width: 42%;
        margin-top: 57px;
        margin-left: 20px;
    }
    .template5 .terms_condition{
        margin-left: 20px;
        margin-top: 18px;
    }
    .template .title .icon{
    	width: 40%;
    }
    .tamplate_header .template_title{
    	background: #fff;
    	border: 1px solid #ededed;
    	width: 445px;
    	display: none;
    }
    .temp1 .template_title{
        display: block;
    }
    .tamplate_header{
        /*padding: 10px;*/
        margin-bottom: 10px
    }
</style>
<?php
if( array_key_exists('REDIRECT_URL', $_SERVER) ){
    $explode = explode('/',$_SERVER['REDIRECT_URL']);
}else{
    $explode = explode('/',$_SERVER['PATH_INFO']);	
}
?>
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

{!! Form::open(array('route' => 'craete.voucher', 'id' => 'form-with-validation', 'class' => 'form-horizontal','autocomplete' => 'off')) !!}
<div class="form-group">
    {!! Form::label('voucher_template', 'Voucher Template*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        <select class="form-control" name="voucher_template" >
            @php
                $voucher = ['1' => 'Template One','2' => 'Template two','3' => 'Template three','4' => ' template Four','5' => 'Long Text'];
            @endphp
            @foreach( $voucher as $k => $v )
                <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="tamplate_header temp1">
	<div class="template template1">
	    <div class="catType_icon title">
	        <div class="icon">
	            <img src="{{ asset('uploads/1562400560-hotel.png') }}" >
	        </div>
	        <div class="title">
	            <h2>Some demo desc </h2>
	            <div class="valid_date">
	                <h4>Valid Date: <span class="valid_date_spam">2109-07-02</span></h4>
	            </div>
	            <div class="terms">
	                <h5>Terms & condition: <span>some demo text</span></h5>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="template_title">
	</div>
</div>

<div class="tamplate_header">
	<div class="template template2">
	    <div class="catType_icon title">
	        <div class="icon">
	            <img src="{{ asset('uploads/1562400560-hotel.png') }}" >
	        </div>
	        <div class="title">
	            <h2>Some demo desc </h2>
	            <div class="valid_date">
	                <h4>Valid Date: <span class="valid_date_spam">2109-07-02</span></h4>
	            </div>
	            <div class="terms">
	                <h5>Terms & condition: <span>some demo text</span></h5>
	            </div>
	        </div>

	    </div>
	</div>
	<div class="template_title">
		
	</div>
</div>

<div class="tamplate_header">
	<div class="template template3">
	    <div class="catType_icon title">
	        <div class="icon">
	            <img src="{{ asset('uploads/1562400560-hotel.png') }}" >
	        </div>
	        <div class="title">
	            <h2>Some demo desc </h2>
	            <div class="valid_date">
	                <h4>Valid Date: <span class="valid_date_spam">2109-07-02</span></h4>
	            </div>
	            <div class="terms">
	                <h5>Terms & condition: <span>some demo text</span></h5>
	            </div>
	        </div>

	    </div>
	</div>
	<div class="template_title">
		
	</div>
</div>

<div class="tamplate_header">
	<div class="template template4">
	    <div class="catType_icon title">
	        <div class="icon">
	            <img src="{{ asset('uploads/1562400560-hotel.png') }}" >
	        </div>
	        <div class="title">
	            <h2>Some demo desc </h2>
	        </div>
	    </div>
	    <br><br>
	    <div class="terms_condition">
	        <div class="valid_date">
	            <h5>Valid Date: <span class="valid_date_spam">2109-07-02</span></h5>
	        </div>
	        <div class="terms">
	            <h5>Terms & condition: <span>some demo text</span></h5>
	        </div>
	    </div>
	</div>
	<div class="template_title">
		
	</div>
</div>

<div class="tamplate_header">
    <div class="template template5">
        <div class="catType_icon title">
            <div class="icon">
                <img src="{{ asset('uploads/1562400560-hotel.png') }}" >
            </div>
            <div class="title">
                <h2>Some demo desc </h2>
            </div>
        </div>
        <br>
        <div class="terms_condition">
            <div class="valid_date">
                <h5><strong>Valid Date:</strong> <span class="valid_date_spam">2109-07-02</span></h5>
            </div>
            <div class="terms">
                <h5><strong>Terms & condition:</strong> <span>some demo text</span></h5>
            </div>
        </div>
    </div>
    <div class="template_title">
        
    </div>
</div>


<div class="form-group">

    {!! Form::label('title', 'Title*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('title', old('title'), array('class'=>'form-control')) !!}
        
    </div>
</div><div class="form-group">
    {!! Form::label('valid_date', 'Valid Date*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('valid_date', old('valid_date'), array('class'=>'form-control datepicker')) !!}
        
    </div>
</div>
<div class="form-group">
    {!! Form::label('terms_condition', 'Terms and Condition*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('terms_condition', old('terms_condition'), array('class'=>'form-control')) !!}
        
    </div>
</div>
<div class="form-group">
    {!! Form::label('plan_id', 'Voucher For*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        @foreach( $plans as $k => $v )
            <label><input checked="checked" name="plan_id[]" type="checkbox" value="{{ $v->id }}"> {{ $v->title }} </label>
        @endforeach
        
    </div>
</div>
{{-- <div class="form-group">
    {!! Form::label('barcode', 'Barcode*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('barcode', old('barcode'), array('class'=>'form-control')) !!}
        
    </div>
</div>
 --}}
 <input type="hidden" name="barcode" value="{{ rand(11111 , 99999) }}">
 {{-- <div class="form-group">
    {!! Form::label('discount', 'Discount*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('discount', old('discount'), array('class'=>'form-control')) !!}
        
    </div>
</div> --}}
<input type="hidden" name="discount" value="0">
<input type="hidden" name="voucher_of" value="{{ end($explode) }}">
{{-- <div class="form-group">
    {!! Form::label('voucher_type', 'voucher type*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        <select class="form-control" name="voucher">
            @foreach( $Categories as $k => $v )
                <option value="{{ $v->id }}">{{ $v->name }}</option>
            @endforeach
        </select>
    </div>
</div>
     --}}

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')) !!}
    </div>
</div>

{!! Form::close() !!}

{{--     <img src="{{ asset('images/1.png') }}" class="image_template">
    <img src="{{ asset('images/2.png') }}" class="image_template">
    <img src="{{ asset('images/3.png') }}" class="image_template">
    <img src="{{ asset('images/4.png') }}" class="image_template">
 --}}
@section('javascript')
    <script type="text/javascript">
    jQuery(document).ready(function(e){
        $('select[name=voucher_template]').change(function(){
            var selectedTemplate = $(this).val();
            if( selectedTemplate == 1 ){
                $('.template1').show();
                $('.template2').hide();
                $('.template3').hide();
                $('.template4').hide();
                $('.template5').hide();
                $('.template_title').hide();
                $('.template1').parent().find('.template_title').show();
            }
            if( selectedTemplate == 2 ){
                $('.template1').hide();
                $('.template2').show();
                $('.template3').hide();
                $('.template4').hide();
                $('.template5').hide();
				$('.template_title').hide();
                $('.template2').parent().find('.template_title').show();

            }
            if( selectedTemplate == 3 ){
                $('.template1').hide();
                $('.template2').hide();
                $('.template3').show();
                $('.template4').hide();
                $('.template5').hide();
				$('.template_title').hide();
                $('.template3').parent().find('.template_title').show();
            }
            if( selectedTemplate == 4 ){
                $('.template1').hide();
                $('.template2').hide();
                $('.template3').hide();
                $('.template4').show();
                $('.template5').hide();
				$('.template_title').hide();
                $('.template4').parent().find('.template_title').show();
            }
            if( selectedTemplate == 5 ){
                $('.template1').hide();
                $('.template2').hide();
                $('.template3').hide();
                $('.template4').hide();
                $('.template5').show();
				$('.template_title').hide();
                $('.template5').parent().find('.template_title').show();
            }
        });
        $('#title').keyup(function(){
            let textValue = $(this).val();
            if( textValue.length > 20 ){
	            $('.template_title').html(textValue);
                $('.catType_icon.title .title h2').html('');
            }else{
                $('.template_title').html('');
	            $('.catType_icon.title .title h2').html(textValue);
            }
        });

        $('#terms_condition').keyup(function(){
            let textValue = $(this).val();
            $('.terms span').html(textValue);
        });
        
        $('#valid_date').blur(function(){
            setTimeout(function(){
                let validDate = $('input[name=valid_date]').val();
                $('.valid_date_spam').html(validDate);

            }, 150);
        });
    });
</script>
@endsection
@endsection

