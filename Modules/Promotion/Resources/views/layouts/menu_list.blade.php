<?php
$menu = ['promotion.index', 'promotion.create', 'promotion.edit'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
        <span class="pcoded-mtext">Promotion Management</span>
    </a>
    <ul class="pcoded-submenu">

        <?php
        $subMenu = ['promotion.index'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('promotion.index') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Promotion</span>
            </a>
        </li>
        <?php
        $subMenu = ['promotion.create'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('promotion.create') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Promotion Create</span>
            </a>
        </li>
    </ul>
</li>
