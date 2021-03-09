<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <h1><?php echo e(trans('coreadmin::admin.users-edit-edit_user')); ?></h1>

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
    <?php echo Form::open(['route' => ['users.update', $user->id], 'class' => 'form-horizontal', 'method' => 'PATCH']); ?>

    <div class="form-group">
        <?php echo Form::label('name', trans('coreadmin::admin.users-edit-name'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('name', old('name', $user->name), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-name_placeholder')]); ?>

        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('email', trans('coreadmin::admin.users-edit-email'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::email('email', old('email', $user->email), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-email_placeholder')]); ?>

        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('password', trans('coreadmin::admin.users-edit-password'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::password('password', ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-password_placeholder')]); ?>

        </div>
    </div>
    
    <div class="form-group">
        <?php echo Form::label('role_id', trans('coreadmin::admin.users-edit-role'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::select('role_id', $roles, $user->role_id, ['class'=>'form-control']); ?>

        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('plan_id', 'Plan', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <select name="plan_id" class='form-control'>
                <option value="0">Select Plan</option>
                <?php if( $plan != null ): ?>

                    <?php $__currentLoopData = $plan->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e(($user->plan_id == $k ) ? 'selected' : ''); ?> value="<?php echo e($k); ?>">
                            <?php echo e($v); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('belongs_to', 'Belongs To', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <select name="belongs_to" class='form-control'>
                <option value="0">Select belongs to</option>
                <?php if( $plan != null ): ?>

                    <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e(($user->offerId == $v->id ) ? 'selected' : ''); ?> value="<?php echo e($v->id); ?>">
                            <?php echo e($v->title); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
            
        </div>
    </div>
    <div class="form-group">
        <?php echo Form::label('mobile', 'Mobile', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('mobile', old('mobile', $user->mobile), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::admin.users-edit-name_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <?php echo Form::submit(trans('coreadmin::admin.users-edit-btnupdate'), ['class' => 'btn btn-primary']); ?>

        </div>
    </div>
    
    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/users/edit.blade.php ENDPATH**/ ?>