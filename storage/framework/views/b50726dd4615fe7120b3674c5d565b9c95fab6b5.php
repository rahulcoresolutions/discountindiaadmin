<style type="text/css">
    .red{
        background-color: red !important;
        color: white;

    }
    .yellow{
        background: yellow !important;
        color: white;
    }
</style>
<?php $__env->startSection('content'); ?>
    <p><?php echo link_to_route('users.create', trans('coreadmin::admin.users-index-add_new'), [], ['class' => 'btn btn-success']); ?></p>
    <?php if($users->count() > 0): ?>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><?php echo e(trans('coreadmin::admin.users-index-users_list')); ?></div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th><?php echo e(trans('coreadmin::admin.users-index-name')); ?></th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Mobile</th>
                        <th>Customer ID</th>
                        <th>Expired On</th>

                        <th>&nbsp;</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e(($user->status == 0 && $user->role_id != 3 && $user->id != 1)? 'red' : 'tr'); ?>">
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <?php if($user->plan != null || $user->plan != 'null' && $user->plan['title'] ): ?>
                                    <td><?php echo e($user->plan['title']); ?></td>
                                <?php else: ?>
                                    <td></td>
                                <?php endif; ?>
                                <td><?php echo e($user->mobile); ?></td>
                                <td><?php echo e($user->customer_unique_id); ?></td>
                                <td><?php echo e($user->expired_on); ?></td>
                                <td>
                                    <?php echo link_to_route('users.edit', trans('coreadmin::admin.users-index-edit'), [$user->id], ['class' => 'btn btn-xs btn-info']); ?>

                                    <?php echo Form::open(['style' => 'display: inline-block;', 'method' => 'DELETE', 'onsubmit' => 'return confirm(\'' . trans('coreadmin::admin.users-index-are_you_sure') . '\');',  'route' => array('users.destroy', $user->id)]); ?>

                                    <?php echo Form::submit(trans('coreadmin::admin.users-index-delete'), array('class' => 'btn btn-xs btn-danger')); ?>

                                    <?php echo Form::close(); ?>

                                    <?php if( $user->status == 0 && $user->role_id != 3 && $user->id != 1): ?>
                                        <a href="<?php echo e(route('change.status', $user->id )); ?>">Active</a>
                                    <?php endif; ?>
                                    <?php if( $user->status == 1 && $user->role_id != 3 && $user->id != 1): ?>
                                        <a href="<?php echo e(route('deacativate.status', $user->id )); ?>">Deactive</a>
                                    <?php endif; ?>
                                    
                                </td>
                            </tr>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <?php echo e(trans('coreadmin::admin.users-index-no_entries_found')); ?>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/upcommingRenewal.blade.php ENDPATH**/ ?>