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

<?php echo Form::model($subscribeplan, array('class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('coreadmin.route').'.subscribeplan.update', $subscribeplan->id))); ?>


<div class="form-group">
    <?php echo Form::label('from', 'From*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('from', old('from',$subscribeplan->from), array('class'=>'form-control datepicker')); ?>

        
    </div>
</div><div class="form-group">
    <?php echo Form::label('to', 'To*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('to', old('to',$subscribeplan->to), array('class'=>'form-control datepicker')); ?>

        
    </div>
</div><div class="form-group">
    <?php echo Form::label('plan_id', 'Plan*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('plan_id', old('plan_id',$subscribeplan->plan_id), array('class'=>'form-control')); ?>

        
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <?php echo Form::submit(trans('coreadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')); ?>

      <?php echo link_to_route(config('coreadmin.route').'.subscribeplan.index', trans('coreadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')); ?>

    </div>
</div>

<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/subscribeplan/edit.blade.php ENDPATH**/ ?>