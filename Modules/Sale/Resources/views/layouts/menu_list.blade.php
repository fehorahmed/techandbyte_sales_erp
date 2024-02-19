<?php
$menu = [
    'sale.sale_add','sale.sale_receipt_all','sale.sale_receipt_details',
    'client.index', 'client.create', 'client.edit', 'client.category.index', 'client.category.create', 'client.category.edit'
];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
        <span class="pcoded-mtext">Sale</span>
    </a>
    <ul class="pcoded-submenu">
        <?php
        $subMenu = [
            'sale.sale_add',
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('sale.sale_add') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Sale Order</span>
            </a>
        </li>
        <?php
        $subMenu = [
            'sale.sale_receipt_all','sale.sale_receipt_details'
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('sale.sale_receipt_all') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Order</span>
            </a>
        </li>
        @include('client::layouts.menu_list')
    </ul>
</li>
