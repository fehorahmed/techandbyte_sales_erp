<?php
$menu = ['product.unit_add', 'product.unit_all', 'product.brand_all', 'product.brand_edit', 'product.brand_add', 'product.unit_edit', 'product.category_add', 'product.category_all', 'product.category_edit', 'product.sub_category_add', 'product.sub_category_all', 'product.sub_category_edit', 'product.product_add', 'product.product_all', 'product.product_edit'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i></span>
        <span class="pcoded-mtext">Product Management</span>
    </a>
    <ul class="pcoded-submenu">

        <?php
        $subMenu = ['product.product_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.product_add') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Product Add</span>
            </a>
        </li>
        <?php
        $subMenu = ['product.product_all'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.product_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Product</span>
            </a>
        </li>

        <?php
        $subMenu = ['product.brand_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.brand_add') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Brand Add</span>
            </a>
        </li>
        <?php
        $subMenu = ['product.brand_all'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.brand_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Brand</span>
            </a>
        </li>


        <?php
        $subMenu = ['product.unit_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.unit_add') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Unit Add</span>
            </a>
        </li>
        <?php
        $subMenu = ['product.unit_all'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.unit_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Unit</span>
            </a>
        </li>

        <?php
        $subMenu = ['product.category_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.category_add') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Category Add</span>
            </a>
        </li>
        <?php
        $subMenu = ['product.category_all'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.category_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Category</span>
            </a>
        </li>

        {{-- <?php
        $subMenu = ['product.sub_category_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.sub_category_add') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Sub Category Add</span>
            </a>
        </li>
        <?php
        $subMenu = ['product.sub_category_all'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('product.sub_category_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Sub Category</span>
            </a>
        </li> --}}


    </ul>
</li>
