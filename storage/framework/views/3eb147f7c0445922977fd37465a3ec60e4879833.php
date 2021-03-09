<?php $__env->startSection('content'); ?>



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
                        <th>Title</th>
                        <th>Belongs To</th>
                        <th>Valid Date</th>
                        <th>Terms and Condition</th>
                        <th>voucher Id</th>
                        

                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                            </td>
                            <td><?php echo e($row->title); ?></td>
                            <td><?php echo e($row['Offer']['title']); ?></td>
                            <td><?php echo e($row->valid_date); ?></td>
                            <td><?php echo e($row->terms_condition); ?></td>
                            <td><?php echo e($row->voucher_unique_id); ?></td>

                            <td>
                                <?php echo link_to_route(config('coreadmin.route').'.vouchers.edit', trans('coreadmin::templates.templates-view_index-edit'), array($row->id), array('class' => 'btn btn-xs btn-info')); ?>

                                
                                <a href="<?php echo e(route('voucher.clone',$row->id)); ?>" class="btn btn-xs btn-primary">Clone</a> 
                                <a href="javascript:;" class="btn btn-success btn-xs openModal" data-attr="<?php echo e($row->id); ?>">share</a>
                                <?php if( $row->status == 1): ?>
                                    <a href="<?php echo e(route('change.voucher.deactivate' , $row->id)); ?>" class="btn btn-warning btn-xs" >De-activate</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('change.voucher.activate' , $row->id)); ?>" class="btn btn-info btn-xs" >Activate</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <input type="hidden" name="voucherId" class="voucher_id" value="<?php echo e($row->voucher_unique_id); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <form action="<?php echo e(route('share.voucher')); ?>" method="POST">
                            <h4 class="modal-title">Share with user</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <input type="hidden" name="voucherId" value="" class="voucherId">
                            <input type="hidden" name="userId" value="">

                            <div class="row-fluid">

                                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="userId  ">
                                    <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option data-subtext="<?php echo e($v->name); ?> (<?php echo e($v->mobile); ?>)" value="<?php echo e($v->id); ?>"><?php echo e($v->name); ?> (<?php echo e($v->mobile); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div >
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Expire date</label>
                                <input type="date" name="expiredDate" class="form-control" min="<?php echo date("Y-m-d"); ?>" id="exampleFormControlSelect1">
                            </div>
                        </div>
                        <div class="modal-footer">
                                <input type="submit" name="submit" value="submit" class="btn btn-default">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-danger" id="delete">
                        <?php echo e(trans('coreadmin::templates.templates-view_index-delete_checked')); ?>

                    </button>
                </div>
            </div>
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
            $(document).on('click', '.openModal',function(){
                let voucherId = $(this).attr('data-attr');
                $('.voucherId').val(voucherId);
                $('#myModal').modal('show'); 
            });
            $('.selectpicker').on('change', function(){
                var selected = '';
                selected = $('.selectpicker').val()
                $('input[name=userId]').val(selected);
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/vouchers/index.blade.php ENDPATH**/ ?>