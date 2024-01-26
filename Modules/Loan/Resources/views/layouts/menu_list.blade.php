<?php
$menu = ['loan.index', 'loan.create', 'loan.edit','loan.loan_holder_index', 'loan.loan_holder_create', 'loan.loan_holder_edit','loan.details.index'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
        <span class="pcoded-mtext">Loan Manage..</span>
    </a>
    <ul class="pcoded-submenu">

        <?php
        $subMenu = ['loan.loan_holder_index'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('loan.loan_holder_index') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Loan Holder</span>
            </a>
        </li>
            <?php
        $subMenu = ['loan.index','loan.details.index'];
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
