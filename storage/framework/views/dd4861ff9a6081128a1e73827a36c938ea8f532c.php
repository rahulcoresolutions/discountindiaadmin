<?php $__env->startSection('content'); ?>

    <?php if( $voucherDetails ): ?>
        <?php
            $voucherTitle = $voucherDetails['title'];
            $voucherTerms = $voucherDetails['terms_condition'];
            $voucherId = $voucherDetails['voucher_unique_id'];
            $voucherOfferTitle = $voucherDetails['Offer']['title'];
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Voucher</th>
                    <th>Voucher Id</th>
                    <th>Voucher From</th>
                    <th>Voucher Terms</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo e($voucherTitle); ?></td>
                    <td><?php echo e($voucherId); ?></td>
                    <td><?php echo e($voucherOfferTitle); ?></td>
                    <td><?php echo e($voucherTerms); ?></td>
                </tr>
            </tbody>
        </table>
        <form method="POST" action="<?php echo e(route('craete.voucher.redeem')); ?>"> 
            <input type="hidden" name="voucher_unique_id" value="<?php echo e($voucherId); ?>">
            <input type="hidden" name="customer_unique_id" value="<?php echo e($customerId); ?>">
            <input type="hidden" name="status" value="1">
            <?php echo e(csrf_field()); ?>

            <input type="submit" value="Redeem" class="btn btn-primary">
        </form>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-2">

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php echo implode('', $errors->all('<li class="error">:message</li>')); ?>

                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if( $voucherDetails == null ): ?>
    <div class="row">
        <div class="col-md-12" style="padding: 10px;border: 2px solid #ededed;text-align: center" >       
            <h2 style="padding: 0; margin: 0">Not a valid voucher</h2>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/redeemvoucher/details.blade.php ENDPATH**/ ?>