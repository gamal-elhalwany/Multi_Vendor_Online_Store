<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
            <a href="{{ route('dashboard') }}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('dashboard/categories*') ? 'active-link' : '' }}">
                        <i class="far fa-list-alt nav-icon"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('dashboard/products*') ? 'active-link' : '' }}">
                        <i class="fab fa-product-hunt nav-icon"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.trash') }}" class="nav-link {{ request()->is('dashboard/categories/trash') ? 'active-link' : '' }}" class="nav-link {{ request()->is('dashboard/products*') ? 'active-link' : '' }}">
                        <i class="fas fa-trash-alt nav-icon"></i>
                        <p>Trash</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Simple Link
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
