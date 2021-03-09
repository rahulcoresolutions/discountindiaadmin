<?php $__env->startSection('content'); ?>
<style type="text/css">
    .expired{
        background: wheat !important
    }
</style>



    <?php if($listVouchers->count()): ?>
        <div>
            <p><div class="expired" style="height: 20px;width: 20px;float: left"></div>&nbsp; Expired</p>
        </div>

        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption"><?php echo e(trans('coreadmin::templates.templates-view_index-list')); ?></div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable userData">
                    <thead>
                        <tr>
                            <th>
                                <?php echo Form::checkbox('delete_all',1,false,['class' => 'mass']); ?>

                            </th>
                            <th>Title</th>
                            <th>Voucher Unique Id</th>
                            <th>Merchant</th>
                            <th>No. of redeem</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        <?php $__currentLoopData = $listVouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($row->valid_date <= date('Y-m-d') ? 'expired' : ''); ?>" >
                                <td>
                                    <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                                </td>
                                <td><?php echo e($row->title); ?></td>
                                <td><?php echo e($row->voucher_unique_id); ?> </td>
                                <?php if($row->Offer != null): ?>
                                    <td><?php echo e($row->Offer->title); ?> </td>  
                                <?php else: ?>
                                    <td>Merchant Deleted</td>
                                <?php endif; ?>
                                <td><?php echo e(count($row->vocuherDetails)); ?></td>
                            </tr>
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







<p><?php echo link_to_route('create.paid.voucher', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')); ?></p>

<?php if($vouchers->count()): ?>
        <div>
            <p><div class="expired" style="height: 20px;width: 20px;float: left"></div>&nbsp; Expired</p>
        </div>

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
                        <th>Title</th>
                        <th>Terms and Condition</th>
                        <th>Image</th>
                        <th>From</th>
                        <th>Valid Date</th>
                        <th>voucher Id</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="<?php echo e($row->valid_date <= date('Y-m-d') ? 'expired' : ''); ?>" >
                            <td>
                                <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                            </td>
                            <td><?php echo e($row->title); ?></td>
                            <td><?php echo e($row->terms_condition); ?></td>
                            <td>
                                <?php if($row->fileName != null): ?>
                                    <img src="<?php echo e(asset('voucher/images/'.$row->fileName )); ?>" style="width: 70px;height: 70px;">
                                <?php else: ?>
                                    ---- 
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(($row->offer ) ? $row->offer->title : ''); ?></td>
                            <td><?php echo e($row->valid_date); ?></td>
                            <td><?php echo e($row->voucher_unique_id); ?></td>
                            <td><a href="<?php echo e(route('edit.paid.voucher' , $row->id)); ?>" class="btn btn-primary btn-xs">Edit</a> | <a href="<?php echo e(route('delete.paid.voucher' , $row->id)); ?>" class="btn btn-danger btn-xs">Delete</a></td>
                        </tr>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/paidVouchers/index.blade.php ENDPATH**/ ?>