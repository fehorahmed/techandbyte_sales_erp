<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Customer</title>

       {{-- Laravel Vite - CSS File --}}
       {{-- {{ module_vite('build-customer', 'Resources/assets/sass/app.scss') }} --}}

    </head>
    <body>
        @yield('content')



        <li class="pcoded-hasmenu active pcoded-trigger">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                <span class="pcoded-mtext">Customer</span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <span class="pcoded-mtext">Customer Add</span>
                    </a>
                </li>
                <li class>
                    <a href="dashboard-crm.html">
                        <span class="pcoded-mtext">All Customer</span>
                    </a>
                </li>
                <li class="">
                    <a href="dashboard-analytics.html">
                        <span class="pcoded-mtext">Analytics</span>
                        <span class="pcoded-badge label label-info ">NEW</span>
                    </a>
                </li>
            </ul>
        </li>

    </body>
</html>
