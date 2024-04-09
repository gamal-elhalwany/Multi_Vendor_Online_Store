<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('admin/dashboard/categories*') ? 'active-link' : '' }}">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('admin/dashboard/products*') ? 'active-link' : '' }}">
                        <i class="fab fa-product-hunt nav-icon"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->is('admin/dashboard/order*') ? 'active-link' : '' }}">
                        <i class="fab fas fa-list nav-icon"></i>
                        <p>Orders</p>
                    </a>
                </li>

                @if(Auth::user()->hasAnyRole('Owner', "Super-admin"))
                <li class="nav-item menu-close">
                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->is('admin/roles*') ? 'active-link' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ __('Roles') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link {{ request()->is('admin/roles') ? 'active' : '' }}">
                                <i class="fab fas fa-list nav-icon"></i>
                                <p>{{ __('All Roles') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.create') }}" class="nav-link {{ request()->is('admin/roles/create') ? 'active' : '' }}">
                                <i class="fa fa-square-plus"></i>
                                <p>Create Role</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('admin/users*') ? 'active-link' : '' }}">
                        <i class="fas fa-layer-group"></i>
                        <p>
                            {{ __('Users') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                                <i class="fab fas fa-users nav-icon"></i>
                                <p>{{ __('All Users') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link {{ request()->is('admin/users/create') ? 'active' : '' }}">
                                <i class="fab fas fa-user nav-icon"></i>
                                <p>Create User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('slider.create') }}" class="nav-link {{ request()->is('admin/dashboard/create-slider*') ? 'active-link' : '' }}">
                        <i class="fab fas fa-user nav-icon"></i>
                        <p>Create Slider</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('coupons.index') }}" class="nav-link {{ request()->is('admin/dashboard/coupons*') ? 'active-link' : '' }}">
                        <i class="fab fas fa-user nav-icon"></i>
                        <p>{{ __('Coupons') }}</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->