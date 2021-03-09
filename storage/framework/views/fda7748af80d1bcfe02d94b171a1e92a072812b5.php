<?php $__env->startSection('content'); ?>
<style>
    .labelData{
        width: 100%;
        text-align: right;
        padding: 0;
        margin: 0;
    }
</style>
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

<?php echo Form::model($subcategory, array('files' => true, 'class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('coreadmin.route').'.subcategory.update', $subcategory->id))); ?>


<div class="form-group">
    <?php echo Form::label('title', 'Title', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::text('title', old('title',$subcategory->title), array('class'=>'form-control')); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('attachment', 'Attachment', array('class'=>'col-sm-2 control-label')); ?>

    <div class="col-sm-10">
        <?php echo Form::file('attachment'); ?>

        
    </div>
</div>

<?php
    $selectedOffers = json_decode($subcategory->offers);
?>


<div class="form-group">
    <div class="row">
        <div class="col-md-2  " style="margin: 0 ; padding: 0" >
            <?php echo Form::label('offers', 'Select Merchants*', array('class'=>'col-sm-2 control-label labelData')); ?>

        </div>
        <div class="col-md-10">
            <div class="row">
                <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <?php if( in_array( $v->id , $selectedOffers ) ): ?>
                            <label><input type="checkbox" class="form-control" checked name="offers[]" value="<?php echo e($v->id); ?>" style="width: 50px;padding: 0;margin: 0;float: left;"> <?php echo e($v->title); ?></label>
                        <?php else: ?>
                            <label><input type="checkbox" class="form-control" name="offers[]" value="<?php echo e($v->id); ?>" style="width: 50px;padding: 0;margin: 0;float: left;"> <?php echo e($v->title); ?></label>
                        <?php endif; ?>
                        
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <?php echo Form::submit(trans('coreadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')); ?>

      <?php echo link_to_route(config('coreadmin.route').'.subcategory.index', trans('coreadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')); ?>

    </div>
</div>

<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/subcategory/edit.blade.php ENDPATH**/ ?>