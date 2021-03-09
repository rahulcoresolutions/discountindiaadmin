

<style type="text/css">
    .red{
        background-color: red !important;
        color: white;

    }
    .yellow{
        background: yellow !important;
        color: white;
    }
    .hide{
        display: none;
    }
</style>

<?php $__env->startSection('content'); ?>
    <p><?php echo link_to_route('users.create', trans('coreadmin::admin.users-index-add_new'), [], ['class' => 'btn btn-success']); ?></p>
    <?php if($users->count() > 0): ?>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Merchants List</div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable userData">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Category</th>
                        <th>Vouchers</th>
                        <th>Redeemed Vouchers</th>
                        <th>Created On</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->mobile); ?></td>
                                <td><?php echo e($user->offers->categoryDetails->name); ?></td>                                
                                <td><?php echo e(count($user->offers->vouchers)); ?></td>
                                <td><?php echo e($user->userRedeemedVouchers); ?></td>
                                <td><?php echo e($user->created_at); ?></td>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/reports/index.blade.php ENDPATH**/ ?>