<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php echo implode('', $errors->all('
                        <li class="error">:message</li>
                        ')); ?>

                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php if($menusList->count() == 0): ?>
        <div class="row">
            <div class="col-xs-6 col-md-4">
                <div class="alert alert-info">
                    <?php echo e(trans('coreadmin::qa.menus-index-no_menu_items_found')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xs-12 form-group">
            <a href="<?php echo e(route('menu.crud')); ?>" class="btn btn-primary"><?php echo e(trans('coreadmin::qa.menus-index-new_crud')); ?></a>
            <a href="<?php echo e(route('menu.custom')); ?>" class="btn btn-primary"><?php echo e(trans('coreadmin::qa.menus-index-new_custom')); ?></a>
            <a href="<?php echo e(route('menu.parent')); ?>" class="btn btn-primary"><?php echo e(trans('coreadmin::qa.menus-index-new_parent')); ?></a>
        </div>
    </div>

    <?php echo Form::open(['class' => 'form-horizontal']); ?>


    <?php if($menusList->count() != 0): ?>
        <div class="row">
            <div class="col-xs-6 col-md-4">
                <div class="alert alert-danger">
                    <?php echo e(trans('coreadmin::qa.menus-index-positions_drag_drop')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xs-6 col-md-4">
            <ul id="sortable" class="list-unstyled">
                <?php $__currentLoopData = $menusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($menu->children()->first() == null): ?>
                        <li data-menu-id="<?php echo e($menu->id); ?>">
                            <span>
                                <?php echo e($menu->title); ?> <?php echo e($menu->parent_id); ?>

                                <a href="<?php echo e(route('menu.edit',[$menu->id])); ?>"
                                   class="btn btn-xs btn-default pull-right">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </span>
                            <input type="hidden" class="menu-no" value="<?php echo e($menu->position); ?>"
                                   name="menu-<?php echo e($menu->id); ?>">
                            <?php if($menu->menu_type == 2): ?>
                                <ul class="childs" style="min-height: 10px;"></ul>
                            <?php endif; ?>
                        </li>
                    <?php else: ?>
                        <li data-menu-id="<?php echo e($menu->id); ?>">
                            <span>
                                <?php echo e($menu->title); ?>

                                <a href="<?php echo e(route('menu.edit',[$menu->id])); ?>"
                                   class="btn btn-xs btn-default pull-right">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </span>
                            <input type="hidden" class="menu-no" value="<?php echo e($menu->position); ?>"
                                   name="menu-<?php echo e($menu->id); ?>">
                            <ul class="childs list-unstyled" style="min-height: 10px;">
                                <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <span>
                                            <?php echo e($child->title); ?>

                                            <a href="<?php echo e(route('menu.edit',[$child->id])); ?>"
                                               class="btn btn-xs btn-default pull-right">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </span>
                                        <input type="hidden" class="child-no" value="<?php echo e($child->position); ?>"
                                               name="child-<?php echo e($child->id); ?>">
                                        <input type="hidden" class="menu-id" value="<?php echo e($menu->id); ?>"
                                               name="child-parent-<?php echo e($child->id); ?>">
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <?php if($menusList->count() != 0): ?>

        <div class="row" id="dragMessage" style="display: none;">
            <div class="col-xs-6 col-md-4">
                <div class="alert alert-danger">
                    <?php echo e(trans('coreadmin::qa.menus-index-click_save_positions')); ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?php echo Form::submit(trans('coreadmin::qa.menus-index-save_positions'),['class' => 'btn btn-danger']); ?>

            </div>
        </div>
    <?php endif; ?>

    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $(function () {
            $("#sortable").sortable({
                placeholder: "ui-state-highlight",
                update: function () {
                    $('#dragMessage').show();
                    var i = 1;
                    $('#sortable').find('> li').each(function () {
                        $(this).attr('data-menu-no', i);
                        var no = $(this).attr('data-menu-no');
                        $(this).find('.menu-no').val(no);
                        i++;
                    });
                }

            });
            $("#sortable").disableSelection();
            $(".childs").sortable({
                placeholder: "ui-state-highlight",
                connectWith: ".childs",
                dropOnEmpty: true,
                update: function () {
                    $('#dragMessage').show();
                    $('#sortable').find('> li').each(function () {
                        var i = 1;
                        $('> ul > li', this).each(function () {
                            var no = $(this).parent().parent().attr('data-menu-id');
                            $(this).find('.menu-id').val(no);
                            $(this).find('.child-no').val(i);
                            i++;
                            console.log('ok');
                        });
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/packages/core-solutions/core-admin/src/Views/qa/menus/index.blade.php ENDPATH**/ ?>