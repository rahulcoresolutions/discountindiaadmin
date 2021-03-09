<?php $__env->startSection('content'); ?>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption"><?php echo e(trans('coreadmin::qa.logs-index-list')); ?></div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-hover table-responsive" id="ajaxtable">
                <thead>
                <th><?php echo e(trans('coreadmin::qa.logs-index-user')); ?></th>
                <th><?php echo e(trans('coreadmin::qa.logs-index-action')); ?></th>
                <th><?php echo e(trans('coreadmin::qa.logs-index-action_model')); ?></th>
                <th><?php echo e(trans('coreadmin::qa.logs-index-action_id')); ?></th>
                <th><?php echo e(trans('coreadmin::qa.logs-index-time')); ?></th>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('#ajaxtable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo e(route('actions.ajax')); ?>',
            language: {
                url: "<?php echo e(trans('coreadmin::strings.datatable_url_language')); ?>"
            },            
            columns: [
                {data: 'users.name', name: 'user_id'},
                {data: 'action', name: 'action'},
                {data: 'action_model', name: 'action_model'},
                {data: 'action_id', name: 'action_id'},
                {data: 'created_at', name: 'created_at'}
            ]
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/packages/core-solutions/core-admin/src/Views/qa/logs/index.blade.php ENDPATH**/ ?>