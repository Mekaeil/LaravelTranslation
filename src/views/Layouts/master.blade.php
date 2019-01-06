@include('LaraTrans::Layouts.header')

<div class="container body">
    <div class="main_container">

    @include('LaraTrans::Layouts.navigation')

    <!-- top navigation -->
    @include('LaraTrans::Layouts.nav-top')
    <!-- /top navigation -->

        <!-- /header content -->

        <!-- page content -->
        <div class="right_col" role="main">
            @yield('breadcrumb')

            @include('LaraTrans::Layouts.alerts')

            @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer class="hidden-print">
            <div class="pull-right">
                Copyright 2018
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

    </div>
</div>

@include('LaraTrans::Layouts.footer')