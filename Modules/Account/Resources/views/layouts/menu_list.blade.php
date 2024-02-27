<?php
$menu = [
    'account.chart_of_account',
    'account.sub_account_list',
    'account.predefined_accounts',
    'account.financial_year',
    'account.opening_balance',
    'account.opening_balance_add',
    'account.opening_balance_edit',
    'account.debit_voucher',
    'account.credit_voucher',
    'account.contra_voucher',
    'account.contra_voucher_add',
    'account.contra_voucher_edit',
    'account.journal_voucher',
    'account.journal_voucher_add',
    'account.journal_voucher_edit',
    'account.bank_reconciliation',
    'account.add_payment_method',
    'account.payment_method_list',
    'account.supplier_payment',
    'account.customer_receive',
    'account.service_payment',
    'account.cash_adjustment',
    'account.voucher_approval',
    'account.sub_account_all',
    'account.sub_account_add',
    'account.sub_account_edit',
    'account.financialyear_add',
    'account.financialyear_all',
    'account.financialyear_edit',
    'account.debit_voucher_add',
    'account.debit_voucher_edit',
    'account.debit_voucher_view',
    'account.credit_voucher',
    'account.credit_voucher_add',
    'account.credit_voucher_edit',
    'account.credit_voucher_view',
    'account.account_head_type_add',
    'account.account_head_type_edit',
    'account.account_head_type_all',
    'account.account_sub_head_add',
    'account.account_sub_head_edit',
    'account.account_sub_head_all',
];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
        <span class="pcoded-mtext">Accounts</span>
    </a>
    <ul class="pcoded-submenu">
        <?php
        $subMenu = ['account.chart_of_account'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.chart_of_account') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Chart Of Account</span>
            </a>
        </li>
        
        <?php
        $subMenu = ['account.financialyear_add', 'account.financialyear_all', 'account.financialyear_edit'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.financialyear_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Financial Year</span>
            </a>
        </li>
        
        <?php
        $subMenu = ['account.account_head_type_all'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.account_head_type_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Head Type All</span>
            </a>
        </li>

        <?php
        $subMenu = ['account.account_sub_head_all'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.account_sub_head_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Sub Head All</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.transaction_all', 'account.transaction_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.transaction_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Transaction</span>
            </a>
        </li>


        <?php
        $subMenu = ['account.sub_account_all', 'account.sub_account_add', 'account.sub_account_edit'];
        ?>
        <!--<li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">-->
        <!--    <a href="{{ route('account.sub_account_all') }}">-->
        <!--        <span class="pcoded-micon"><i-->
        <!--                class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>-->
        <!--        <span class="pcoded-mtext">Sub Account List</span>-->
        <!--    </a>-->
        <!--</li>-->

        <?php
        $subMenu = ['account.predefined_accounts'];
        ?>
        <!--<li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">-->
        <!--    <a href="{{ route('account.predefined_accounts') }}">-->
        <!--        <span class="pcoded-micon"><i-->
        <!--                class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>-->
        <!--        <span class="pcoded-mtext">Predefined Accounts</span>-->
        <!--    </a>-->
        <!--</li>-->

        
        {{--
        <?php
        $subMenu = ['account.opening_balance', 'account.opening_balance_add', 'account.opening_balance_edit'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.opening_balance') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Opening Balance</span>
            </a>
        </li>

        <?php
        $subMenu = ['account.debit_voucher', 'account.debit_voucher_add', 'account.debit_voucher_edit', 'account.debit_voucher_view'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.debit_voucher') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Debit Voucher</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.credit_voucher', 'account.credit_voucher_add', 'account.credit_voucher_edit', 'account.credit_voucher_view'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.credit_voucher') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Credit Voucher</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.contra_voucher', 'account.contra_voucher_add', 'account.contra_voucher_edit'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.contra_voucher') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Contra Voucher</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.journal_voucher', 'account.journal_voucher_add', 'account.journal_voucher_edit'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.journal_voucher') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Journal Voucher</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.bank_reconciliation'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.bank_reconciliation') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Bank Reconciliation</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.add_payment_method'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.add_payment_method') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Add Payment Method</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.payment_method_list'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.payment_method_list') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Payment Method List</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.supplier_payment'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.supplier_payment') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Supplier Payment</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.customer_receive'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.customer_receive') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Customer Receive</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.service_payment'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.service_payment') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Service Payment</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.cash_adjustment'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.cash_adjustment') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Cash Adjustment</span>
            </a>
        </li>
        <?php
        $subMenu = ['account.voucher_approval'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.voucher_approval') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Voucher Approval</span>
            </a>
        </li>
--}}
    </ul>
</li>


{{-- ExPense --}}
{{--
<?php
$menu = ['account.expense_item_all', 'account.expense_item_add', 'account.expense_item_edit', 'account.expense_all', 'account.expense_add'];
?>

<li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $menu) ? 'active pcoded-trigger' : '' }}">
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
        <span class="pcoded-mtext">Expense</span>
    </a>
    <ul class="pcoded-submenu">
        <?php
        $subMenu = ['account.expense_item_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.expense_item_add') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Add Expense Item</span>
            </a>
        </li>

        <?php
        $subMenu = ['account.expense_item_all', 'account.expense_item_edit'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.expense_item_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Expense Item List</span>
            </a>
        </li>

        <?php
        $subMenu = ['account.expense_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.expense_add') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Add Expense</span>
            </a>
        </li>

        <?php
        $subMenu = ['account.expense_all', 'account.expense_add'];
        ?>
        <li class="{{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
            <a href="{{ route('account.expense_all') }}">
                <span class="pcoded-micon"><i
                        class="feather {{ in_array(Route::currentRouteName(), $subMenu) ? 'icon-check-circle' : 'icon-circle' }}"></i></span>
                <span class="pcoded-mtext">Expense List</span>
            </a>
        </li>


    </ul>
</li> --}}
