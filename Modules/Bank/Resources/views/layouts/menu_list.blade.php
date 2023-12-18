<?php
$menu = [
    'bank.bank_add','bank.bank_all','bank.bank_edit'
];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
        <span class="pcoded-mtext">Bank</span>
    </a>
    <ul class="pcoded-submenu">
        <?php
        $subMenu = [
            'bank.bank_add',
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('bank.bank_add') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Add Bank</span>
            </a>
        </li>
        <?php
        $subMenu = [
            'bank.bank_all',
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('bank.bank_all') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Bank</span>
            </a>
        </li>
    </ul>
</li>
