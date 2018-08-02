<div class="row-header">
    <header>
        <div class="container">

            <div class="outer-width-box">
                <div class="inner-width-box">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col col-auto">

                            <div class="header-logo"><a href="{{route('home')}}"><img src="{{asset('front-end/img/logo.jpg')}}" width="226"
                                                                                      height="38" alt=""></a></div>

                        </div>
                        <div class="col">

                     

                        </div>
                        <div class="col col-auto">

                            <div class="header-center-menu">

                                <ul class="nav flex-nowrap">

                                    @include('components.non-auth.buttons_registration_and_login')

                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>
</div>

<div class="row-header-mobile">
    <header>
        <div class="container">

            <div class="outer-width-box">
                <div class="inner-width-box">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col col-auto">

                            <a href="#" class="navtoggler"><span>Menu</span></a>

                        </div>
                        <div class="col">

                            <div class="header-logo"><a href="{{route('home')}}"><img src="{{asset('front-end/img/logo.jpg')}}" width="226"
                                                                                      height="38" alt=""></a></div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>
</div>