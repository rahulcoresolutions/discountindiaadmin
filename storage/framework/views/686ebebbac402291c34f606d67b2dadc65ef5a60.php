<?php $__env->startSection('content'); ?>

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


<form id='form-with-validation' class ='form-horizontal' method="GET" action="<?php echo e(route('get.voucher.details')); ?>">

    <div class="form-group">
        <?php echo Form::label('customer_unique_id', 'Customer Id*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('customer_unique_id', old('customer_unique_id'), array('class'=>'form-control')); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('voucher_unique_id', 'Voucher Id*', array('class'=>'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('voucher_unique_id', old('voucher_unique_id'), array('class'=>'form-control')); ?>

        </div>
    </div>
    
    
    
    <input type="hidden" name="status" value="1">

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <button type="submit" class="getVoucherDetails">Get Details</button>
        </div>
    </div>
<?php echo Form::close(); ?>

<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/redeemvoucher/create.blade.php ENDPATH**/ ?>