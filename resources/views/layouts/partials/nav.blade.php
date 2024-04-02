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
                    <a href="{{ route('categories.index') }}"
                        class="nav-link {{ request()->is('admin/dashboard/categories*') ? 'active-link' : '' }}">
                        <i class="far fa-list-alt nav-icon"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}"
                        class="nav-link {{ request()->is('admin/dashboard/products*') ? 'active-link' : '' }}">
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

                <li class="nav-item menu-open">
                    <a href="{{ route('roles.index') }}"
                        class="nav-link {{ request()->is('admin/roles*') ? 'active-link' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Roles
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}"
                                class="nav-link {{ request()->is('admin/roles') ? 'active' : '' }}">
                                <i class="fab fas fa-list nav-icon"></i>
                                <p>All Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.create') }}"
                                class="nav-link {{ request()->is('admin/roles/create') ? 'active' : '' }}">
                                <i class="fab fas fa-list nav-icon"></i>
                                <p>Create Role</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ request()->is('admin/dashboard/order*') ? 'active' : '' }}">
                        <i class="fab fas fa-users nav-icon"></i>
                        <p>All Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.create') }}"
                        class="nav-link {{ request()->is('admin/dashboard/create-user*') ? 'active' : '' }}">
                        <i class="fab fas fa-user nav-icon"></i>
                        <p>Create User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('slider.create') }}"
                        class="nav-link {{ request()->is('admin/dashboard/create-slider*') ? 'active-link' : '' }}">
                        <i class="fab fas fa-user nav-icon"></i>
                        <p>Create Slider</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->