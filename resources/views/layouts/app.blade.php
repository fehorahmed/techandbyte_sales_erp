<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords"
        content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">

    <link rel="icon" href="{{ asset('themes/backend/files/assets/images/favicon.ico" type="image/x-icon') }}">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <link rel="stylesheet"
        href="{{ asset('themes/backend/files/bower_components/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('themes/backend/files/bower_components/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/backend/files/toastr/toastr.min.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/assets/pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/assets/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/assets/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/assets/icon/icofont/css/icofont.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/assets/icon/feather/css/feather.css') }}">
    {{-- js tree --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('themes/backend/files/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/backend/files/assets/css/jquery.mCustomScrollbar.css') }}">
    <style>
        .pcoded[nav-type=st6] .pcoded-item.pcoded-left-item>li>a>.pcoded-micon i {
            color: #fff;
        }

        .pcoded-item.pcoded-left-item>li.active>a {
            background-color: #01a9ac !important;
            color: #fff !important;
        }

        .pcoded-mtext::before {
            content: none !important;
        }

        .pcoded .pcoded-navbar .pcoded-item .pcoded-hasmenu .pcoded-submenu li>a .pcoded-micon {
            display: inline-block;
            font-size: 15px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #fff;
            color: #000;
            padding: 8px 30px 8px 20px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #28a745;
            border-radius: 1px;
        }

        .is-valid-border {
            border: 1px solid #28a745;
        }

        .is-valid-border:focus {
            border: 1px solid #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, .25);
        }

        .help-block {
            color: red !important;
        }

        table tr td .form-group {
            margin-bottom: 0;
        }

        .col-form-label,
        .col-form-check {
            font-size: 15px;
            padding-right: 0;
        }

        .card .card-header {
            background-color: transparent;
            padding: 12px 20px;
        }

        .card-header {
            border-bottom: 1px solid #07885b !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: normal;
        }

        .datepicker table tr td.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active:hover {
            background-color: #E1694C;
            background-image: -moz-linear-gradient(to bottom, #E1694C, #E1694C);
            background-image: -ms-linear-gradient(to bottom, #E1694C, #E1694C);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#E1694C), to(#E1694C));
            background-image: -webkit-linear-gradient(to bottom, #E1694C, #E1694C);
            background-image: -o-linear-gradient(to bottom, #E1694C, #E1694C);
            background-image: linear-gradient(to bottom, #E1694C, #E1694C);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#08c', endColorstr='#0044cc', GradientType=0);
            border-color: #E1694C #E1694C #E1694C;
            border-color: rgb(0 159 75) rgb(2, 160, 76) rgb(2, 160, 76);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgb(2, 160, 76);
        }

        .datepicker table tr td.active.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled.disabled,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active.disabled:hover.active,
        .datepicker table tr td.active.disabled:hover.disabled,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.disabled:hover:hover,
        .datepicker table tr td.active.disabled:hover[disabled],
        .datepicker table tr td.active.disabled[disabled],
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active:hover.disabled,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active:hover:hover,
        .datepicker table tr td.active:hover[disabled],
        .datepicker table tr td.active[disabled] {
            background-color: #E1694C;
        }

        .datepicker.datepicker-dropdown.dropdown-menu {
            z-index: 9999 !important;
        }

        @media only screen and (max-width: 768px) {

            .radio-inline,
            .border-checkbox-section .border-checkbox-group,
            .checkbox-color {
                display: inline-block;
            }
        }

        @media only screen and (max-width: 576px) {

            .col-form-label.text-right,
            .col-form-check.text-right {
                text-align: left !important;
            }
        }

        .navbar-logo img {
            width: 120px;
            margin-left: 35%;
        }

        .pcoded .pcoded-header .navbar-logo[logo-theme=theme1] {
            background-color: #143257;
        }
        .pcoded .pcoded-navbar[navbar-theme=theme1] {
            background: #143257;
        }
        .pcoded .pcoded-navbar[navbar-theme=theme1] .main-menu {
            background-color: #143257;
        }
        .pcoded .pcoded-navbar[navbar-theme=theme1] .pcoded-item li.pcoded-hasmenu .pcoded-submenu {
            background: #143257;
        }
    </style>
    @yield('style')
</head>

<body>
    <div class="theme-loader">
        <div class="ball-scale">
            <div class="contain">
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            {{--   Header --}}

            @include('layouts.header')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                                    <a href="{{ route('dashboard') }}">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>

                                <?php
                                    $top_menu = [
                                        'warehouse.index', 'warehouse.create', 'warehouse.store', 'warehouse.edit', 'warehouse.update',
                                        'product.unit_add', 'product.unit_all', 'product.brand_all', 'product.brand_edit', 'product.brand_add', 'product.unit_edit', 'product.category_add', 'product.category_all', 'product.category_edit', 'product.sub_category_add', 'product.sub_category_all', 'product.sub_category_edit', 'product.product_add', 'product.product_all', 'product.product_edit'
                                    ];
                                ?>
                                <li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $top_menu) ? 'active pcoded-trigger' : '' }}" dropdown-icon="style1" subitem-icon="style1">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
                                        <span class="pcoded-mtext">Settings</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        @include('warehouse::layouts.menu_list')
                                        @include('product::layouts.menu_list')
                                    </ul>
                                </li>
                                @include('purchase::layouts.menu_list')
                                @include('inventory::layouts.menu_list')
                                @include('sale::layouts.menu_list')
                                @include('task::layouts.menu_list')
                                @include('promotion::layouts.menu_list')
                                @include('loan::layouts.menu_list')
                                <?php
                                $top_menu = [
                                     'cash','bank.bank_add','bank.bank_all','bank.bank_edit'
                                ];
                                ?>
                                <li class="pcoded-hasmenu {{ in_array(Route::currentRouteName(), $top_menu) ? 'active pcoded-trigger' : '' }}" dropdown-icon="style1" subitem-icon="style1">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
                                        <span class="pcoded-mtext">Cash / Bank</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <?php
                                        $menu = [
                                            'cash'
                                        ];
                                        ?>
                                        <li class="{{ Route::currentRouteName() == 'cash' ? 'active' : '' }}">
                                            <a href="{{ route('cash') }}">
                                                <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                                <span class="pcoded-mtext">Cash</span>
                                            </a>
                                        </li>
                                        @include('bank::layouts.menu_list')
                                    </ul>
                                </li>
                                @include('account::layouts.menu_list')
                                @include('report::layouts.menu_list')


                                <?php
                                $menu = [
                                    'cash'
                                ];
                                ?>
                                <!--<li class="{{ Route::currentRouteName() == 'cash' ? 'active' : '' }}">-->
                                <!--    <a href="{{ route('cash') }}">-->
                                <!--        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>-->
                                <!--        <span class="pcoded-mtext">Cash</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <!--@include('bank::layouts.menu_list')-->
                                <!--@include('supplier::layouts.menu_list')-->
                                <!--@include('warehouse::layouts.menu_list')-->
                                <!--@include('client::layouts.menu_list')-->
                                <!--@include('product::layouts.menu_list')-->
                                <!--@include('purchase::layouts.menu_list')-->
                                <!--@include('inventory::layouts.menu_list')-->
                                <!--@include('customer::layouts.menu_list')-->
                                <!--@include('sale::layouts.menu_list')-->
                                <!--@include('account::layouts.menu_list')-->
                                <!--@include('loan::layouts.menu_list')-->
                                <!--@include('promotion::layouts.menu_list')-->
                                <!--@include('task::layouts.menu_list')-->
                                <!--@include('report::layouts.menu_list')-->
                            </ul>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('themes/backend/files/bower_components/jquery/dist/jquery.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('themes/backend/files/bower_components/jquery-ui/jquery-ui.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('themes/backend/files/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('themes/backend/files/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript"
        src="{{ asset('themes/backend/files/bower_components/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <script type="text/javascript" src="{{ asset('themes/backend/files/bower_components/modernizr/modernizr.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('themes/backend/files/bower_components/modernizr/feature-detects/css-scrollbars.js') }}"></script>

    <script type="text/javascript" src="{{ asset('themes/backend/files/bower_components/chart.js/dist/Chart.js') }}">
    </script>
    {{-- jsTree --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

    <script src="{{ asset('themes/backend/files/assets/pages/widget/amchart/amcharts.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/pages/widget/amchart/serial.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/pages/widget/amchart/light.js') }}"></script>

    <script src="{{ asset('themes/backend/files/assets/pages/form-validation/validate.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('themes/backend/files/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('themes/backend/files/assets/pages/advance-elements/select2-custom.js') }}"></script> --}}

    <script src="{{ asset('themes/backend/files/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}">
    </script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/js/jszip.min.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/js/vfs_fonts.js') }}"></script>
    <script
        src="{{ asset('themes/backend/files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js') }}">
    </script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js') }}">
    </script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/extensions/buttons/js/jszip.min.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js') }}">
    </script>
    <script src="{{ asset('themes/backend/files/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}">
    </script>
    <script src="{{ asset('themes/backend/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}">
    </script>
    <script src="{{ asset('themes/backend/files/assets/pages/data-table/js/dataTables.bootstrap4.min.js') }}"></script>
    <script
        src="{{ asset('themes/backend/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script
        src="{{ asset('themes/backend/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    <script
        src="{{ asset('themes/backend/files/assets/pages/data-table/extensions/buttons/js/extension-btns-custom.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('themes/backend/files/assets/js/SmoothScroll.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/js/vartical-layout.min.js') }}"></script>

    <script type="text/javascript"
        src="{{ asset('themes/backend/files/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <script src="{{ asset('themes/backend/files/bower_components/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('themes/backend/files/assets/js/sweetalert.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('themes/backend/files/toastr/toastr.min.js') }}"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var message = '{{ session('message') }}';
            var error = '{{ session('error') }}';
            if (!window.performance || window.performance.navigation.type != window.performance.navigation
                .TYPE_BACK_FORWARD) {
                if (message != '')
                    toastr.success(message);

                if (error != '')
                    toastr.error(error);
            }
        });
        $(function() {
            //Select2
            $('.select2').select2();
            //Date picker
            $(".date-picker").datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('themes/backend/files/assets/js/script.js') }}"></script>
    @yield('script')
</body>

</html>
