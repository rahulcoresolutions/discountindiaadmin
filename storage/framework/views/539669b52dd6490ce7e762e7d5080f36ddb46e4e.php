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

<?php echo Form::model($topslider, array('files' => true, 'class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('coreadmin.route').'.topslider.update', $topslider->id))); ?>


<div class="form-group">
    <?php echo Form::label('attachment', 'Attachment', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::file('attachment'); ?>

        
    </div>
</div><div class="form-group">
    <?php echo Form::label('active', 'Active*', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <ul>
            <li>
                <label id="yes"><?php echo Form::radio('active', '1', true ); ?> &nbsp;&nbsp;&nbsp;Yes </label>
            </li>
            <li>
                <label id="no"><?php echo Form::radio('active', '0', false); ?> &nbsp;&nbsp;&nbsp;No</label>
            </li>
        </ul>
        
        
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <?php echo Form::submit(trans('coreadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')); ?>

      <?php echo link_to_route(config('coreadmin.route').'.topslider.index', trans('coreadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')); ?>

    </div>
</div>

<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/topslider/edit.blade.php ENDPATH**/ ?>