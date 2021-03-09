<?php $__env->startSection('content'); ?>

<p><?php echo link_to_route(config('coreadmin.route').'.subscribeplan.create', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')); ?></p>

<?php if($subscribeplan->count()): ?>
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
                        <th>From</th>
                        <th>To</th>
                        <th>Plan</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $subscribeplan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]); ?>

                            </td>
                            <td><?php echo e($row->from); ?></td>
                            <td><?php echo e($row->to); ?></td>
                            <td><?php echo e($row->plan->title); ?></td>
                            <td>
                                <?php echo link_to_route(config('coreadmin.route').'.subscribeplan.edit', trans('coreadmin::templates.templates-view_index-edit'), array($row->id), array('class' => 'btn btn-xs btn-info')); ?>

                                <?php echo Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'onsubmit' => "return confirm('".trans("coreadmin::templates.templates-view_index-are_you_sure")."');",  'route' => array(config('coreadmin.route').'.subscribeplan.destroy', $row->id))); ?>

                                <?php echo Form::submit(trans('coreadmin::templates.templates-view_index-delete'), array('class' => 'btn btn-xs btn-danger')); ?>

                                <?php echo Form::close(); ?>

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
            <?php echo Form::open(['route' => config('coreadmin.route').'.subscribeplan.massDelete', 'method' => 'post', 'id' => 'massDelete']); ?>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/subscribeplan/index.blade.php ENDPATH**/ ?>