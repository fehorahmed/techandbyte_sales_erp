<?php
$menu = ['loan.index', 'loan.create', 'loan.edit'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
        <span class="pcoded-mtext">Loan Manage..</span>
    </a>
    <ul class="pcoded-submenu">

        <?php
        $subMenu = ['loan.index'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('loan.index') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Loan</span>
            </a>
        </li>
        <?php
        $subMenu = ['loan.create'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('loan.create') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Loan Create</span>
            </a>
        </li>
    </ul>
</li>
