<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <title>@yield('title')</title>

    @yield('css')

</head>


<body>

<div class="offcanvas-menu">
    <div class="container">

        <div class="wrapper-search">
            <form>
                <div class="form-group">
                    <input type="input" class="form-control" placeholder="Search User/Org">
                </div>
            </form>
        </div>

        <div class="header-center-menu">

            <ul class="nav">

                @include('components.auth.nav_bar')

            </ul>

        </div>

        <div class="header-right-menu">

            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="gl-icon-person"></span>
                        <span class="text">Account Setting</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="gl-icon-clock"></span>
                        <span class="text">Add Hours</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="gl-icon-sharing"></span>
                        <span class="text">Share Profile</span>
                    </a>
                </li>
                <li class="nav-item active dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="gl-icon-envelope"></span>
                        <span class="text">Messages Box</span>
                        <span class="badge">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="gl-icon-bell"></span>
                        <span class="text">Alerts</span>
                        <span class="badge">999999999</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </li>

            </ul>

        </div>

    </div>
</div>

<div class="offcanvas-menu-backdrop"></div>

<div class="offcanvas-contentarea">

    <div class="wrapper_bottom_footer">

        @include('components.auth.header')


        <div class="row-content">


                    @yield('content')


        </div>


        <div class="row-footer">
            <div>
                @include('components.footer')
            </div>
        </div>


    </div>
</div>


<script src="{{asset('js/jquery-3.3.1.slim.js')}}"></script>
<script src="{{asset('js/popper.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>

<script>

    $(document).ready(function() {

        var $outerwidth = $('.row-header header .outer-width-box');
        var $innerwidth = $('.row-header header .inner-width-box');

        function checkWidth() {

            var outersize = $outerwidth.width();
            var innersize = $innerwidth.width();

            if( innersize > outersize) {

                $('body').addClass("navmobile");

            } else {

                $('body').removeClass("navmobile");
                $('body').removeClass("offcanvas-menu-show");

            }
        }

        checkWidth();
        $(window).resize(checkWidth);

        $('.offcanvas-menu-backdrop').on('click', function(e) {
            $('body').toggleClass("offcanvas-menu-show");
            e.preventDefault();
        });

        $('.wrapper_bottom_footer > .row-header-mobile header a.navtoggler').on('click', function(e) {
            $('body').toggleClass("offcanvas-menu-show");
            e.preventDefault();
        });

    });

</script>

@yield('script')


</body>
</html>



