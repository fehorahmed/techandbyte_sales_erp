<?php
$menu = ['inventory.inventory_receipt_all', 'inventory.inventory_receipt_details'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
        <span class="pcoded-mtext">Inventory</span>
    </a>
    <ul class="pcoded-submenu">
        <?php
        $subMenu = ['inventory.inventory_receipt_all', 'inventory.inventory_receipt_details'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('inventory.inventory_receipt_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">All Order</span>
            </a>
        </li>
    </ul>
</li>
