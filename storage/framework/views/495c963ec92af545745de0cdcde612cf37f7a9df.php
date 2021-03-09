<?php $__env->startSection('content'); ?>

<p><?php echo link_to_route(config('coreadmin.route').'.redeemvoucher.create', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')); ?></p>
<?php if(Session::has('successVoucher')): ?>
    <p class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?>"><?php echo e(Session::get('successVoucher')); ?></p>
<?php endif; ?>
<?php if($redeemvoucher->count()): ?>
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
                        <th>Customer Id</th>
                        <th>Voucher Id</th>
                        <th>Voucher Title</th>
                        <th>Redeem at </th>
                        
                        

                        
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $redeemvoucher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                            </td>
                            <td><?php echo e($row->customer_unique_id); ?></td>
                            <td><?php echo e($row->voucher_unique_id); ?></td>
                            <td>
                                <?php if( $row->customerDetails != null ): ?>
                                    <?php if( $row->title != null ): ?>
                                        <?php echo e($row->title); ?>

                                    <?php else: ?>
                                        <?php echo e($row->voucherdetails->title); ?>

                                    <?php endif; ?>
                                <?php else: ?>
                                    Voucher Deleted
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($row->created_at); ?></td>
                            
                            

                            
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-xs-12">
                    
                </div>
            </div>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/redeemvoucher/index.blade.php ENDPATH**/ ?>