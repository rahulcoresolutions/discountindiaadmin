<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu"
            data-keep-expanded="false"
            data-auto-scroll="true"
            data-slide-speed="200">
            <li @if(Request::path() == 'dashboard') class="active" @endif>
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-dashboard"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
            @if(Auth::user()->role_id == config('coreadmin.defaultRole'))
                <li @if(Request::path() == config('coreadmin.route').'/menu') class="active" @endif>
                    <a href="{{ url(config('coreadmin.route').'/menu') }}">
                        <i class="fa fa-list"></i>
                        <span class="title">{{ trans('coreadmin::admin.partials-sidebar-menu') }}</span>
                    </a>
                </li>
                
                <li @if(Request::path() == 'users') class="active" @endif>
                    <a href="{{ url('users') }}">
                        <i class="fa fa-users"></i>
                        <span class="title">{{ trans('coreadmin::admin.partials-sidebar-users') }}</span>
                    </a>
                </li>
                <li @if(Request::path() == 'roles') class="active" @endif>
                    <a href="{{ url('roles') }}">
                        <i class="fa fa-gavel"></i>
                        <span class="title">{{ trans('coreadmin::admin.partials-sidebar-roles') }}</span>
                    </a>
                </li>
                <li @if(Request::path() == config('coreadmin.route').'/actions') class="active" @endif>
                    <a href="{{ url(config('coreadmin.route').'/actions') }}">
                        <i class="fa fa-users"></i>
                        <span class="title">{{ trans('coreadmin::admin.partials-sidebar-user-actions') }}</span>
                    </a>
                </li>
                <li @if(Request::path() == config('coreadmin.route').'/actions') class="active" @endif>
                    <a href="{{ route('upcomming.renewals') }}">
                        <i class="fa fa-users"></i>
                        <span class="title">Upcoming renewals</span>
                    </a>
                </li>
            @endif
            @foreach($menus as $menu)
                @if($menu->menu_type != 2 && is_null($menu->parent_id))
                    @if(Auth::user()->role->canAccessMenu($menu))
                        <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($menu->name)) class="active" @endif>
                            <a href="{{ route(config('coreadmin.route').'.'.strtolower($menu->name).'.index') }}">
                                <i class="fa {{ $menu->icon }}"></i>
                                <span class="title">{{ $menu->title }}</span>
                            </a>
                        </li>
                    @endif
                @else
                    @if(Auth::user()->role->canAccessMenu($menu) && !is_null($menu->children()->first()) && is_null($menu->parent_id))
                        <li>
                            <a href="#">
                                <i class="fa {{ $menu->icon }}"></i>
                                <span class="title">{{ $menu->title }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @foreach($menu['children'] as $child)
                                    @if(Auth::user()->role->canAccessMenu($child))
                                        <li
                                                @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($child->name)) class="active active-sub" @endif>
                                            <a href="{{ route(strtolower(config('coreadmin.route').'.'.$child->name).'.index') }}">
                                                <i class="fa {{ $child->icon }}"></i>
                                                <span class="title">
                                                    {{ $child->title  }}
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
            @if( Auth::user()->role_id != 3 )
	            <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'get/order/logs') class="active" @endif>
	                <a href="{{ route('get.order.logs') }}">
	                    <i class="fa fa-list"></i>
	                    <span class="title">Sort Logs</span>
	                </a>
	            </li>
            @endif
            <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'get/paid/vouchers') class="active" @endif>
                <a href="{{ route('get.paid.voucher') }}">
                    <i class="fa fa-list"></i>
                    <span class="title">Paid Vouchers</span>
                </a>
            </li>
            @if( Auth::user()->role_id != 3 )

	            <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'list/shared/voucher') class="active" @endif>
	                <a href="{{ route('list.share.voucher') }}">
	                    <i class="fa fa-list"></i>
	                    <span class="title">Shared Vouchers</span>
	                </a>
	            </li>
	        @endif
            <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == 'list/notification') class="active" @endif>
                <a href="{{ route('list.notification') }}">
                    <i class="fa fa-list"></i>
                    <span class="title">List Notifications</span>
                </a>
            </li>
           
            <li>
                {!! Form::open(['url' => 'logout']) !!}
                <button type="submit" class="logout">
                    <i class="fa fa-sign-out fa-fw"></i>
                    <span class="title">{{ trans('coreadmin::admin.partials-sidebar-logout') }}</span>
                </button>
                {!! Form::close() !!}
            </li>

        </ul>
    </div>
</div>
