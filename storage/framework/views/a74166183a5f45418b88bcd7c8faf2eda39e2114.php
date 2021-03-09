<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1><?php echo e(trans('coreadmin::templates.templates-view_edit-edit')); ?></h1>

        <?php if($errors->any()): ?>
        	<div class="alert alert-danger">
        	    <ul>
                    <?php echo implode('', $errors->all('<li class="error">:message</li>')); ?>

                </ul>
        	</div>
        <?php endif; ?>
    </div>
</div>

<?php echo Form::model($delivery, array('files' => true, 'class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('coreadmin.route').'.delivery.update', $delivery->id))); ?>


<div class="form-group">
    <?php echo Form::label('attachment', 'Attachment', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::file('attachment'); ?>

        <img src="<?php echo e(asset('uploads/'.$delivery->attachment)); ?>" style="width: 20%">
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('mobile', 'Mobile*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('mobile', old('mobile',$delivery->mobile), array('class'=>'form-control')); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('valid', 'Valid till*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('valid', old('valid',$delivery->valid), array('class'=>'form-control datepicker')); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('city', 'City*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <select class="form-control" name="city">
            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($v->id); ?>" <?php echo e(($v->id == $delivery->city) ? 'selected' : ''); ?>><?php echo e($v->city); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <?php echo Form::submit(trans('coreadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')); ?>

      <?php echo link_to_route(config('coreadmin.route').'.delivery.index', trans('coreadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')); ?>

    </div>
</div>

<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/delivery/edit.blade.php ENDPATH**/ ?>