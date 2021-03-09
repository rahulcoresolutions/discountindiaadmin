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

<?php echo Form::open(array('route' => config('coreadmin.route').'.plans.store', 'id' => 'form-with-validation', 'class' => 'form-horizontal')); ?>


<div class="form-group">
    <?php echo Form::label('title', 'Plan Name*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('title', old('title'), array('class'=>'form-control')); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('desc', 'Plan Description', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('desc', old('desc'), array('class'=>'form-control')); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('price', 'Plan Price', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('price', old('price'), array('class'=>'form-control')); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('valid', 'Valid Date (months)', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::number('valid', old('valid'), array('class'=>'form-control')); ?>

    </div>
</div>
<div class="form-group">
    <?php echo Form::label('contact', 'Contact no.', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::number('contactno', old('contactno'), array('class'=>'form-control')); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label('imagename', 'Featured Image', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::file('imagename', old('imagename'), array('class'=>'form-control')); ?>

    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <?php echo Form::submit( trans('coreadmin::templates.templates-view_create-create') , array('class' => 'btn btn-primary')); ?>

    </div>
</div>

<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/plans/create.blade.php ENDPATH**/ ?>