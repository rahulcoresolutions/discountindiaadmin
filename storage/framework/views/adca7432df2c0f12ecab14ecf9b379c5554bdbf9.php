<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu"
            data-keep-expanded="false"
            data-auto-scroll="true"
            data-slide-speed="200">
            <li <?php if(Request::path() == 'dashboard'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(route('dashboard')); ?>">
                        <i class="fa fa-dashboard"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
            <?php if(Auth::user()->role_id == config('coreadmin.defaultRole')): ?>
                <li <?php if(Request::path() == config('coreadmin.route').'/menu'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url(config('coreadmin.route').'/menu')); ?>">
                        <i class="fa fa-list"></i>
                        <span class="title"><?php echo e(trans('coreadmin::admin.partials-sidebar-menu')); ?></span>
                    </a>
                </li>
                
                <li <?php if(Request::path() == 'users'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url('users')); ?>">
                        <i class="fa fa-users"></i>
                        <span class="title"><?php echo e(trans('coreadmin::admin.partials-sidebar-users')); ?></span>
                    </a>
                </li>
                <li <?php if(Request::path() == 'roles'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url('roles')); ?>">
                        <i class="fa fa-gavel"></i>
                        <span class="title"><?php echo e(trans('coreadmin::admin.partials-sidebar-roles')); ?></span>
                    </a>
                </li>
                <li <?php if(Request::path() == config('coreadmin.route').'/actions'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(url(config('coreadmin.route').'/actions')); ?>">
                        <i class="fa fa-users"></i>
                        <span class="title"><?php echo e(trans('coreadmin::admin.partials-sidebar-user-actions')); ?></span>
                    </a>
                </li>
                <li <?php if(Request::path() == config('coreadmin.route').'/actions'): ?> class="active" <?php endif; ?>>
                    <a href="<?php echo e(route('upcomming.renewals')); ?>">
                        <i class="fa fa-users"></i>
                        <span class="title">Upcoming renewals</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($menu->menu_type != 2 && is_null($menu->parent_id)): ?>
                    <?php if(Auth::user()->role->canAccessMenu($menu)): ?>
                        <li <?php if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($menu->name)): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(route(config('coreadmin.route').'.'.strtolower($menu->name).'.index')); ?>">
                                <i class="fa <?php echo e($menu->icon); ?>"></i>
                                <span class="title"><?php echo e($menu->title); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if(Auth::user()->role->canAccessMenu($menu) && !is_null($menu->children()->first()) && is_null($menu->parent_id)): ?>
                        <li>
                            <a href="#">
                                <i class="fa <?php echo e($menu->icon); ?>"></i>
                                <span class="title"><?php echo e($menu->title); ?></span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <?php $__currentLoopData = $menu['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(Auth::user()->role->canAccessMenu($child)): ?>
                                        <li
                                                <?php if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($child->name)): ?> class="active active-sub" <?php endif; ?>>
                                            <a href="<?php echo e(route(strtolower(config('coreadmin.route').'.'.$child->name).'.index')); ?>">
                                                <i class="fa <?php echo e($child->icon); ?>"></i>
                                                <span class="title">
                                                    <?php echo e($child->title); ?>

                                                </span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if( Auth::user()->role_id != 3 ): ?>
	            <li <?php if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'get/order/logs'): ?> class="active" <?php endif; ?>>
	                <a href="<?php echo e(route('get.order.logs')); ?>">
	                    <i class="fa fa-list"></i>
	                    <span class="title">Sort Logs</span>
	                </a>
	            </li>
            <?php endif; ?>
            <li <?php if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'get/paid/vouchers'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(route('get.paid.voucher')); ?>">
                    <i class="fa fa-list"></i>
                    <span class="title">Paid Vouchers</span>
                </a>
            </li>
            <?php if( Auth::user()->role_id != 3 ): ?>

	            <li <?php if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'list/shared/voucher'): ?> class="active" <?php endif; ?>>
	                <a href="<?php echo e(route('list.share.voucher')); ?>">
	                    <i class="fa fa-list"></i>
	                    <span class="title">Shared Vouchers</span>
	                </a>
	            </li>
	        <?php endif; ?>
            <li <?php if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'list/notification'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(route('list.notification')); ?>">
                    <i class="fa fa-list"></i>
                    <span class="title">List Notifications</span>
                </a>
            </li>
           
            <li>
                <?php echo Form::open(['url' => 'logout']); ?>

                <button type="submit" class="logout">
                    <i class="fa fa-sign-out fa-fw"></i>
                    <span class="title"><?php echo e(trans('coreadmin::admin.partials-sidebar-logout')); ?></span>
                </button>
                <?php echo Form::close(); ?>

            </li>

        </ul>
    </div>
</div>
<?php /**PATH /home/sboy8c4wy24p/public_html/thediscountindia.com/admin/resources/views/admin/partials/sidebar.blade.php ENDPATH**/ ?>