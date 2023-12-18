<?php
$menu = [
    'supplier.supplier_add','supplier.supplier_all','supplier.supplier_edit'
];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
        <span class="pcoded-mtext">Supplier</span>
    </a>
    <ul class="pcoded-submenu">
        <?php
        $subMenu = [
            'supplier.supplier_add',
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('supplier.supplier_add') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Supplier Add</span>
            </a>
        </li>
        <?php
        $subMenu = [
            'supplier.supplier_all',
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('supplier.supplier_all') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Supplier</span>
            </a>
        </li>
    </ul>
</li>
