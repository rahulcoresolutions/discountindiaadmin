<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <h1><?php echo e(trans('coreadmin::admin.users-create-create_user')); ?></h1>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php echo implode('', $errors->all('
                        <li class="error">:message</li>
                        ')); ?>

                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php echo Form::open(['route' => 'users.store', 'class' => 'form-horizontal']); ?>


    <div class="form-group">
        <?php echo Form::label('name', trans('coreadmin::admin.users-create-name'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-create-name_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('email', trans('coreadmin::admin.users-create-email'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::email('email', old('email'), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-create-email_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('password', trans('coreadmin::admin.users-create-password'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::password('password', ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-create-password_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('role_id', trans('coreadmin::admin.users-create-role'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::select('role_id', $roles, 2 , ['class'=>'form-control']); ?>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <?php echo Form::submit(trans('coreadmin::admin.users-create-btncreate'), ['class' => 'btn btn-primary']); ?>

        </div>
    </div>

    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/users/create.blade.php ENDPATH**/ ?>