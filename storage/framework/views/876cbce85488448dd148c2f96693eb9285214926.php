
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
    <!--<p><?php echo link_to_route('users.create', trans('coreadmin::admin.users-index-add_new'), [], ['class' => 'btn btn-success']); ?></p>-->
    <?php if($data->count() > 0): ?>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Merchants List</div>
            </div>
            
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    No of User
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    No of User
                </div>
            </div>
        </div>
            
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable userData">
                    <thead>
                    <tr>
                        <th>Voucher Name</th>
                        <th>Voucher Unique Id</th>
                        <th>Username</th>
                        <th>C Id</th>
                        <th>User Plan</th>
                        <th>Merchant Name</th>
                        <th>Created On</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $vouchers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $vouchers->vocuherDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($vouchers->title); ?></td>
                                <td><?php echo e($vouchers->voucher_unique_id); ?></td>
                                <td><?php echo e(($voucher->customerDetails) ? $voucher->customerDetails->name : ""); ?></td>
                                <td><?php echo e(($voucher->customerDetails) ? $voucher->customerDetails->customer_unique_id : ""); ?></td>
                                <?php if( $voucher->customerDetails ): ?>
                                    <td><?php echo e(($voucher->customerDetails->plan) ? $voucher->customerDetails->plan->title : ""); ?></td>
                                <?php else: ?>
                                <td></td>
                                <?php endif; ?>
                                
                                <td><?php echo e(($vouchers->Offer) ? $vouchers->Offer->title : ""); ?></td>
                                <td><?php echo e($voucher->created_at); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>
        <?php echo e(trans('coreadmin::admin.users-index-no_entries_found')); ?>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/reports/voucherReport.blade.php ENDPATH**/ ?>