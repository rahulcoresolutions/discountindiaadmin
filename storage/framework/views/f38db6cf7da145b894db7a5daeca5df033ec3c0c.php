

<?php $__env->startSection('content'); ?>

<p><?php echo link_to_route('create.paid.voucher', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')); ?></p>

<?php if($vouchers->count()): ?>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption"><?php echo e(trans('coreadmin::templates.templates-view_index-list')); ?></div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-hover table-responsive datatable" id="datatable">
                <thead>
                    <tr>
                        <th>
                            <?php echo Form::checkbox('delete_all',1,false,['class' => 'mass']); ?>

                        </th>
                        <th>Voucher Id</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Voucher Title</th>
                        <th>Expired On</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($row->user != null): ?>
                            <tr>
                                <td>
                                    <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                                </td>
                                <td><?php echo e($row->voucherId); ?></td>
                                <td><?php echo e($row->user->name); ?></td>
                                <td><?php echo e($row->user->mobile); ?></td>
                                <td><?php echo e($row->voucherDetails->title); ?></td>
                                <td><?php echo e($row->expiredDate); ?></td>
                                <td><?php echo e(($row->status == 1) ? "Not yet used" : 'Used'); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php echo Form::open(['route' => config('coreadmin.route').'.vouchers.massDelete', 'method' => 'post', 'id' => 'massDelete']); ?>

                <input type="hidden" id="send" name="toDelete">
            <?php echo Form::close(); ?>

        </div>
	</div>
<?php else: ?>
    <?php echo e(trans('coreadmin::templates.templates-view_index-no_entries_found')); ?>

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $(document).ready(function () {
            $('#delete').click(function () {
                if (window.confirm('<?php echo e(trans('coreadmin::templates.templates-view_index-are_you_sure')); ?>')) {
                    var send = $('#send');
                    var mass = $('.mass').is(":checked");
                    if (mass == true) {
                        send.val('mass');
                    } else {
                        var toDelete = [];
                        $('.single').each(function () {
                            if ($(this).is(":checked")) {
                                toDelete.push($(this).data('id'));
                            }
                        });
                        send.val(JSON.stringify(toDelete));
                    }
                    $('#massDelete').submit();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/sharedVoucher/index.blade.php ENDPATH**/ ?>