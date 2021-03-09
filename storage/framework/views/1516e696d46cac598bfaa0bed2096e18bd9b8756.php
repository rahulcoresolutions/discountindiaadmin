<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <h1><?php echo e(trans('coreadmin::qa.menus-edit-edit_menu_information')); ?></h1>

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

    <?php echo Form::open(['class' => 'form-horizontal']); ?>


    <?php if($menu->menu_type != 2): ?>
        <div class="form-group">
            <?php echo Form::label('parent_id', trans('coreadmin::qa.menus-edit-parent'), ['class'=>'col-sm-2 control-label']); ?>

            <div class="col-sm-10">
                <?php echo Form::select('parent_id', $parentsSelect, old('parent_id', $menu->parent_id), ['class'=>'form-control']); ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?php echo Form::label('title', trans('coreadmin::qa.menus-edit-title'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('title', old('title',$menu->title), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::qa.menus-edit-title_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('roles', trans('coreadmin::qa.menus-edit-roles'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <label>
                        <?php echo Form::checkbox('roles['.$role->id.']',$role->id,old('roles.'.$role->id, $role->canAccessMenu($menu))); ?>

                        <?php echo $role->title; ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('icon', trans('coreadmin::qa.menus-edit-icon'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?php echo Form::text('icon', old('icon',$menu->icon), ['class'=>'form-control', 'placeholder'=> trans('coreadmin::qa.menus-edit-icon_placeholder')]); ?>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <?php echo Form::submit( trans('coreadmin::qa.menus-edit-update'), ['class' => 'btn btn-primary']); ?>

        </div>
    </div>

    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/packages/core-solutions/core-admin/src/Views/qa/menus/edit.blade.php ENDPATH**/ ?>