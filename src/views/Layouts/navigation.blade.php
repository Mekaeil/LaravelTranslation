<div class="col-md-3 left_col hidden-print">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="#" class="site_title">
                <img src="{{ asset('images/logo.png') }}" class="img-circle logo-side" alt="">
                <span>{{ config('admin.site.title') }}</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ asset('images/icon/3.svg') }}" alt="" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>Mekaeil Andisheh</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li class="dropdown-submenu">
                        <a class="accLink" href="#">
                            <i class="fa fa-language"></i>
                            Translation
                        </a>

                        <ul class="nav child_menu">
                            <li>
                                <a href="{{ route('admin.trans.lang.index') }}">Languages</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.trans.base.index') }}">Base Translation</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.trans.module.index') }}">Module Translation</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>


        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="#">
                <br>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Full Page" onclick="toggleFullScreen();">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock" class="lock_btn">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="#">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>