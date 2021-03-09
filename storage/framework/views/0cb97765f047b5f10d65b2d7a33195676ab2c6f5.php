<?php $__env->startSection('content'); ?>
    <style type="text/css">
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){
            width: 82% !important
        }
        .bootstrap-select.btn-group:not(.input-group-btn){
            padding-left: 15px
        }
    </style>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <h1>Create Notification</h1>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php echo implode('', $errors->all('<li class="error">:message</li>')); ?>

                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php echo Form::open(['route' => 'store.notification', 'class' => 'form-horizontal']); ?>


    <div class="form-group">
        <?php echo Form::label('message', 'Message', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('message', old('message'), ['class'=>'form-control', 'placeholder'=> "Notification"]); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('redirect', 'Redirect To', ['class'=>'col-sm-2 control-label']); ?>

        <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="redirect_url">
            <?php $__currentLoopData = $voucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option data-subtext="<?php echo e($v->voucher_unique_id); ?> (<?php echo e($v->title); ?>)" value="<?php echo e($v->voucher_unique_id); ?>"><?php echo e($v->voucher_unique_id); ?> (<?php echo e($v->title); ?>)</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>


    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <?php echo Form::submit(trans('coreadmin::admin.users-create-btncreate'), ['class' => 'btn btn-primary']); ?>

        </div>
    </div>
    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/notification/create.blade.php ENDPATH**/ ?>