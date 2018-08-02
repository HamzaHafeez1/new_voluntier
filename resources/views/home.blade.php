@extends('layout.master')


@section('content')


    <!-- -->
    <!-- -->
    <!-- -->



    <div class="wrapper_home_slider clearfix">

        <div class="text-over-slider"> <!-- outer -->
            <div>

                <div class="container">

                    <!-- <div class="content-to-scale">  inner -->

                    <div class="row">
                        <div class="col-7">

                            <div class="content-to-scale">

                                <div class="main-text">
                                    <h1 class="h1">Making Service Easier</h1>
                                    <p>MyVoluntier matches people and organizations together to create positive impacts
                                        in their community, while tracking service hours, projects and generating impact
                                        reports.</p>
                                    <a href="{{route('features')}}" class="learn-more"><span>Learn more</span></a>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- </div> -->

                </div>

            </div>
        </div>

        <div class="slider">
            <div>
                <div class="w-slide-5"><span class="slide-item-01"></span></div>
            </div>
            <div>
                <div class="w-slide-5"><span class="slide-item-02"></span></div>
            </div>
            <div>
                <div class="w-slide-5"><span class="slide-item-03"></span></div>
            </div>
            <div>
                <div class="w-slide-5"><span class="slide-item-04"></span></div>
            </div>
        </div>

    </div>


    <!-- -->

    <div class="our-philosophy-box">
        <div class="container">
            <div class="main-text">

                <h2 class="h2 text-center">Our Philosophy</h2>
                <p class="text-center">Our philosophy is that everyone should have the chance to impact their community.
                    This is why My​Voluntier offers a variety of options for those who have a heart to serve. It’s why
                    we make it easy for volunteers, organizations and institutions to connect with causes they care
                    about.</p>
                <p class="text-center strong"><strong>My​Voluntier was created for three kinds of service
                        members:</strong></p>
                @if(Auth::check())
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <p class="text-center">
                                <span class="service_members vol_registr">
                                    <span class="img volunteer"></span>
                                    <span class="text">Volunteer</span>
                                </span>
                            </p>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="text-center">
                                <span class="service_members org_registr">
                                    <span class="img organization"></span>
                                    <span class="text">Organization</span>
                                </span>
                            </p>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="text-center">
                                <span class="service_members inst_registr">
                                    <span class="img institution"></span>
                                    <span class="text ">Institution</span>
                                </span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <p class="text-center">
                                <a href="#" class="service_members vol_registr">
                                    <span class="img volunteer"></span>
                                    <span class="text">Volunteer</span>
                                </a>
                            </p>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="text-center">
                                <a href="#" class="service_members org_registr">
                                    <span class="img organization"></span>
                                    <span class="text">Organization</span>
                                </a>
                            </p>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="text-center">
                                <a href="#" class="service_members inst_registr">
                                    <span class="img institution"></span>
                                    <span class="text ">Institution</span>
                                </a>
                            </p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- -->


    <div class="full-50-col-box">
        <div class="container">


            <div class="row no-gutters align-items-center">
                <div class="col-12 col-md-6">
                    <div class="what-myvoluntier-banner-1"></div>
                </div>
                <div class="col-12 col-md-6">

                    <div class="main-text panel">

                        <h3 class="h3">What is My​Voluntier?</h3>

                        <p>My​Voluntier is the premiere web application used to find, track, and mobilize individuals to
                            better impact their communities.</p>
                        <p>Through our state-of-the-art reporting and tracking tools, we provide a suite of powerful
                            assets that allow individuals, groups, and organizations to measure the impact of their
                            service across their community.</p>

                    </div>

                </div>
            </div>


        </div>
    </div>

    <!-- -->

    <div class="trust-factor-box">
        <div class="container">
            <div class="main-text">

                <h2 class="h2 text-center">The Trust Factor</h2>
                <p class="text-center">My​Voluntier's focus has always been on the people--which is why we have become a
                    trusted name to a growing list of organizations for tracking community engagement, service hours and
                    service-learning across the country.</p>

            </div>
        </div>
    </div>

    <!-- -->

    <div class="full-50-col-box">
        <div class="container">


            <div class="row no-gutters align-items-center">
                <div class="col-12 col-md-6 order-md-1">
                    <div class="what-myvoluntier-banner-2"></div>
                </div>
                <div class="col-12 col-md-6 order-md-0">

                    <div class="main-text panel">

                        <h3 class="h3">My​Voluntier's Big Picture</h3>

                        <p>At My​Voluntier, we believe that a better world is possible, when you can connect people who
                            serve with causes they care about.</p>
                        <p>My​Voluntier was created to be a virtual hub for the service community to connect and
                            mobilize to be a driving force for positive change in our communities. Our goal? To take
                            away barriers between volunteers and organizations and bring the focus back to what matters:
                            the community.</p>

                    </div>

                </div>
            </div>

        </div>
    </div>


    <!-- -->
    <!-- -->
    <!-- -->


    <div class="row-footer">
        <div>

            <!-- -->
            <!-- -->
            <!-- -->

            <!-- -->
            @if(!Auth::check())
                <div class="request-a-demo mt-0">
                    <div class="container">

                        <a class="registration_button" href="#"><span>Create Account</span></a>

                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')




    <script src="{{ asset('front-end/js/jquery.bxslider-rahisified.js') }}"></script>


    <script>

        $(document).ready(function () {


            $('.wrapper_home_slider > div.slider').bxSlider({
                pager: true,
                slideMargin: 0,
                speed: 1000,
                hideControlOnEnd: true,
                auto: true,
                infiniteLoop: true,
                autoReload: true,
                controls: false,
                breaks: [{screen: 0, slides: 1}],
                onSliderLoad: function(){
                    $(".wrapper_home_slider").css("visibility", "visible");
                }
            });


        });

    </script>
@endsection