<?php $__env->startSection('content'); ?>
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
        background-image: url(<?php echo e(asset('images/1.png')); ?>)
    }
    .template2{
        background-image: url(<?php echo e(asset('images/2.png')); ?>)
    }
    .template3{
        background-image: url(<?php echo e(asset('images/3.png')); ?>)
    }
    .template4{
        background-image: url(<?php echo e(asset('images/4.png')); ?>)
    }
    .template5{
        background-image: url(<?php echo e(asset('images/Untitled-1-02.jpg')); ?>)
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
    .voucherslistimages{
        display: none;
    }
    .btn-group.bootstrap-select{
        width: 100% !important
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
        <h1><?php echo e(trans('coreadmin::templates.templates-view_create-add_new')); ?></h1>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php echo implode('', $errors->all('<li class="error">:message</li>')); ?>

                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php echo Form::open(array('route' => 'craete.paid.voucher', 'id' => 'form-with-validation', 'class' => 'form-horizontal','autocomplete' => 'off' , "enctype" => 'multipart/form-data')); ?>

    <div class="form-group">
        <?php echo Form::label('voucher_template', 'Voucher Template*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="voucherType" checked="" value="uploadVoucher">Upload voucher
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="voucherType" value="preTemp">Pre Template
                </label>
            </div>
        </div>
    </div>

    <div class="voucherslistimages">
        <div class="form-group">
            <?php echo Form::label('voucher_template', 'Voucher Template*', array('class'=>'col-sm-2 control-label')); ?>

            <div class="col-sm-10">
                <select class="form-control" name="voucher_template" >
                    <?php
                        $voucher = ['1' => 'Template One','2' => 'Template two','3' => 'Template three','4' => ' template Four','5' => 'Long Text'];
                    ?>
                    <?php $__currentLoopData = $voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>"><?php echo e($v); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="tamplate_header temp1">
            <div class="template template1">
                <div class="catType_icon title">
                    <div class="icon">
                        <img src="<?php echo e(asset('uploads/1562400560-hotel.png')); ?>" >
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
                        <img src="<?php echo e(asset('uploads/1562400560-hotel.png')); ?>" >
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
                        <img src="<?php echo e(asset('uploads/1562400560-hotel.png')); ?>" >
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
                        <img src="<?php echo e(asset('uploads/1562400560-hotel.png')); ?>" >
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
                        <img src="<?php echo e(asset('uploads/1562400560-hotel.png')); ?>" >
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
    </div>
    <div class="browseImage">
        <div class="form-group">
            <?php echo Form::label('voucher_template', 'Browse Image', array('class'=>'col-sm-2 control-label')); ?>

            <div class="col-sm-10">
                <div class="custom-file">
                    <input type="file" class="form-control custom-file-input" name="bannerImage" id="inputGroupFile01">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('voucher_template', 'Vouchers*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="voucher_of">
                <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if( $v->Offer != null ): ?>
	                    <option data-subtext="<?php echo e(($v->Offer != null) ? $v->Offer->title : ''); ?> (<?php echo e((strlen($v->title) > 50 ) ? substr($v->title, 0 , 50).' .....' : $v->title); ?>)" value="<?php echo e($v->Offer->id); ?>"><?php echo e($v->voucher_unique_id); ?></option>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="form-group">

        <?php echo Form::label('title', 'Title*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('title', old('title'), array('class'=>'form-control')); ?>

            
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('valid_date', 'Valid Date*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('valid_date', old('valid_date'), array('class'=>'form-control datepicker')); ?>

            
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('terms_condition', 'Terms and Condition*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('terms_condition', old('terms_condition'), array('class'=>'form-control')); ?>

            
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('customer_price', 'Customer Price*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('customer_price', old('customer_price'), array('class'=>'form-control')); ?>

            
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('hotel_price', 'Hotel Price*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('hotel_price', old('hotel_price'), array('class'=>'form-control')); ?>

            
        </div>
    </div>

    <input type="hidden" name="barcode" value="<?php echo e(rand(11111 , 99999)); ?>">
    <input type="hidden" name="discount" value="0">
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
          <?php echo Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')); ?>

        </div>
    </div>

    <?php echo Form::close(); ?>


<?php $__env->startSection('javascript'); ?>
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

        $(document).on('change' , 'select[name=category]' , function(){
            let selectedCat = $(this).val();
            $.ajax({
                url : '<?php echo e(route("get.cat.offers")); ?>',
                type : "POST",
                data : {_token : $('input[name=_token]').val() , catId : selectedCat},
                success : function(res){
                    $('select[name=Offers]').html('');
                    for(let i = 0 ; i < res.length ;i++){
                        $('select[name=Offers]').append('<option value='+res[i].id+'>'+res[i].title+'</option>');
                    }
                    console.log(res);
                }
            });
            console.log();
        });
        $(document).on('keyup' , '#customer_price' , function(){
            let value = $(this).val();
                $('input[name=hotel_price]').val((value -((value*10)/100)));
        });
        $(document).on('change' , 'input[name=voucherType]' , function(){
            if( $(this).val() == "preTemp" ){
                $('.voucherslistimages').show();
                $('.browseImage').hide();
            }
            if( $(this).val() == 'uploadVoucher' ){
                $('.voucherslistimages').hide();
                $('.browseImage').show();
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/paidVouchers/create.blade.php ENDPATH**/ ?>