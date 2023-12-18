<?php
$menu = [
    'purchase.purchase_add','supplier.supplier_all','supplier.supplier_edit','purchase.purchase_receipt_all','purchase.purchase_receipt_details'
];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
        <span class="pcoded-mtext">Purchase</span>
    </a>
    <ul class="pcoded-submenu">
        <?php
        $subMenu = [
            'purchase.purchase_add',
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('purchase.purchase_add') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Purchase Order</span>
            </a>
        </li>
        <?php
        $subMenu = [
            'purchase.purchase_receipt_all','purchase.purchase_receipt_details'
        ];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('purchase.purchase_receipt_all') }}">
                <span class="pcoded-micon"><i class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Order</span>
            </a>
        </li>
    </ul>
</li>
