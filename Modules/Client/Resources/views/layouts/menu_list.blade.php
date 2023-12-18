<?php
$menu = ['client.index', 'client.create', 'client.edit', 'client.category.index', 'client.category.create', 'client.category.edit'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
        <span class="pcoded-mtext">Client</span>
    </a>
    <ul class="pcoded-submenu">

        <?php
        $subMenu = ['client.index', 'client.create', 'client.edit'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('client.index') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Client</span>
            </a>
        </li>
        <?php
        $subMenu = ['client.category.index', 'client.category.create', 'client.category.edit'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('client.category.index') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Client Category</span>
            </a>
        </li>
    </ul>
</li>
