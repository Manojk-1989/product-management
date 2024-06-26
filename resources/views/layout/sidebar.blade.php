<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Product Master
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('product.create') }}" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Product List</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Color Master
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('color.create') }}" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Color</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Size Master
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('size.create') }}" class="nav-link active">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Size</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
