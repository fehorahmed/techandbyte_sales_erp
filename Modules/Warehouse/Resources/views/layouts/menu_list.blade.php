<?php
$menu = ['warehouse.index', 'warehouse.create', 'warehouse.store', 'warehouse.edit', 'warehouse.update'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-aperture rotate-refresh"></i></span>
        <span class="pcoded-mtext">Warehouse Manage..</span>
    </a>
    <ul class="pcoded-submenu">

        <?php
        $subMenu = ['warehouse.create'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('warehouse.create') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Warehouse Add</span>
            </a>
        </li>
        <?php
        $subMenu = ['warehouse.index'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('warehouse.index') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Warehouse</span>
            </a>
        </li>
    </ul>
</li>
