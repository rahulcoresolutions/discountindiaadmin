<?php $__env->startSection('content'); ?>

<?php if($offer->count() > 0): ?>
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
                        <th>Sort</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody id="sortable">
                    <?php $__currentLoopData = $offer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                        <?php if($row->has('offers')): ?>
                            
                            <?php if($row->offers->has('title')): ?>
                                <tr data-id="<?php echo e($row->id); ?>" data-order="<?php echo e($row->order); ?>">
                                    <td>
                                        <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                                    </td>
                                    <!--<td><?php echo e($row->offers->title); ?></td>-->
                                    <td><?php echo e($row->sortId); ?></td>
                                    <td><?php echo e($row->date); ?></td>
                                    
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/offers/orderLog.blade.php ENDPATH**/ ?>