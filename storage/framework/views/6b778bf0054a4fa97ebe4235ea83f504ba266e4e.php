<?php $__env->startSection('content'); ?>

<p><?php echo link_to_route(config('coreadmin.route').'.offers.create', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')); ?></p>
<?php echo e(csrf_field()); ?>

<?php if($offers->count()): ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption"><?php echo e(trans('coreadmin::templates.templates-view_index-list')); ?></div>
        </div>
        <div class="portlet-body">
            
            <table id="userDatatable" class="table table-striped table-hover table-responsive datatable" id="datatable">
                <thead>
                    <tr>
                        <th>
                            <?php echo Form::checkbox('delete_all',1,false,['class' => 'mass']); ?>

                        </th>
                        <th>Title</th>
                        <th>Attachment</th>
                        <th>Category</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Fax</th>
                        
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody id="sortable">
                    <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-id="<?php echo e($row->id); ?>" data-order="<?php echo e($row->order); ?>">
                            <td>
                                <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                            </td>

                            <td><a href="<?php echo e(route('get.user.voucher' , $row->id)); ?>"><?php echo e($row->title); ?></a></td>
                            <td><?php echo e($row->attachment); ?></td>
                            <td><?php echo e($row->categoryDetails->name); ?></td>
                            <td><?php echo e($row->address); ?></td>
                            <td><?php echo e($row->mobile); ?></td>
                            <td><?php echo e($row->email); ?></td>
                            <td><?php echo e($row->fax); ?></td>
                            
                            <td>
                                <a class="btn btn-primary btn-xs" href="<?php echo e(route('add.voucher' , $row->id)); ?>">Add Vouchers</a>
                                <?php echo link_to_route(config('coreadmin.route').'.offers.edit', trans('coreadmin::templates.templates-view_index-edit'), array($row->id), array('class' => 'btn btn-xs btn-info')); ?>

                                <?php echo Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'onsubmit' => "return confirm('".trans("coreadmin::templates.templates-view_index-are_you_sure")."');",  'route' => array(config('coreadmin.route').'.offers.destroy', $row->id))); ?>

                                <?php echo Form::submit(trans('coreadmin::templates.templates-view_index-delete'), array('class' => 'btn btn-xs btn-danger')); ?>

                                <?php echo Form::close(); ?>

                                <?php if( $row->status == 1 ): ?> 
                                    <a href="<?php echo e(route('change.merchant.deactivate' , $row->id)); ?>" class="btn btn-xs btn-warning">Deactivate</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('change.merchant.activate' , $row->id)); ?>" class="btn btn-xs btn-success">Activate</a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('list.vouchers.merchant' , $row->id)); ?>" class="btn btn-primary btn-xs">List Vouchers</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-danger" id="delete">
                        <?php echo e(trans('coreadmin::templates.templates-view_index-delete_checked')); ?>

                    </button>
                </div>
            </div>
            
            <?php echo Form::open(['route' => config('coreadmin.route').'.offers.massDelete', 'method' => 'post', 'id' => 'massDelete']); ?>

                <input type="hidden" id="send" name="toDelete">
            <?php echo Form::close(); ?>

        </div>
	</div>
<?php else: ?>
    <?php echo e(trans('coreadmin::templates.templates-view_index-no_entries_found')); ?>

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $( "#sortable" ).sortable({
                update: function( event, ui ) {
                    let trLength = $('#sortable tr').length;
                    let dataId = [];
                    let dataOrder = [];
                    for( let i = 0 ; i <= trLength ; i++){
                        var data_id = $('#sortable tr:nth-child('+i+')').attr('data-id');
                        if(data_id != undefined){
                            dataId.push(data_id);   
                        }
                    }
                    for( let i = 0 ; i <= trLength ; i++){
                        var data_order = $('#sortable tr:nth-child('+i+')').attr('data-order');
                        if(data_order != undefined){
                            dataOrder.push(data_order);   
                        }
                    }
                    console.log(dataId);
                    $.ajax({
                        url: "<?php echo e(route('order.sort')); ?>",
                        type:"POST",
                        data: { _token : $('input[name=_token]').val() , dataId : dataId , dataOrder : dataOrder },
                        success: function(res){
                            console.log(res);
                        }
                    });
                }
            }); 
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/offers/index.blade.php ENDPATH**/ ?>