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
    <p><?php echo link_to_route('create.notification', 'Create Notification', [], ['class' => 'btn btn-success']); ?></p>
    <?php if($notification->count() > 0): ?>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><?php echo e(trans('coreadmin::admin.users-index-users_list')); ?></div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable">
                    <thead>
                    <tr>
                        <th>Message</th>
                        <th>Status</th>

                        <th>&nbsp;</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($notif->message); ?></td>
                                <td><?php echo e(($notif->status == 1)? "Active" : "De-Activated"); ?></td>
                                <td><a href="<?php echo e(route('notification.update.status' , $notif->id)); ?>" class="btn btn-xs <?php echo e(($notif->status == 0)? 'btn-primary' : 'btn-danger'); ?>"><?php echo e(($notif->status == 1) ? "Deactivate" : "Activate"); ?></a></td>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/notification/index.blade.php ENDPATH**/ ?>