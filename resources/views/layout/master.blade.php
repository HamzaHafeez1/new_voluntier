@extends('layout.frame')

@section('css')

    <style>
        .p_invalid {
            display: none;
            color: red;
            text-align: center;
            font-size: 10px;
        }

        .error-has {
            border: 1px solid #ff0000 !important;
        }
    </style>
    @yield('css')
@endsection

@section('body')
    <body>
    <div class="offcanvas-menu">
        <div class="container">


            <div class="header-center-menu">

                <ul class="nav">


                    @include('components.non-auth.buttons_registration_and_login')
                </ul>

            </div>

        </div>
    </div>
    <div class="offcanvas-menu-backdrop"></div>

    <div class="offcanvas-contentarea">

        <div class="wrapper_bottom_footer">
            @include('components.non-auth.header')

            <div class="row-content">
                <input class="type-user" type="hidden" value="Volunteer">
                @yield('content')
            </div>

            @include('components.footer')


        </div>

    </div>


    @include('components.non-auth.modal_login')
    @include('components.non-auth.modal_user_tipe')
    @include('components.non-auth.modal_pop_up_sign_org')
    @include('components.non-auth.modal_pop_up_sign_vol')
    @include('components.non-auth.modal_pop_up_sign_forg_pass')
    @include('components.non-auth.modal_org_tipe')
    @include('components.non-auth.modal_terms_and_conditions')
    @include('components.non-auth.modal_successful_reg_pop_up')

    <script src="{{asset('front-end/js/jquery-3.3.1.slim.js')}}"></script>
    <script src="{{asset('js/jquery-2.1.1.js')}}"></script>
    <script src="{{asset('front-end/js/popper.js')}}"></script>
    <script src="{{asset('front-end/js/bootstrap.js')}}"></script>
    <script src="{{asset('js/global.js')}}"></script>
    <script src="{{asset('js/check_validate.js')}}"></script>
    <script src="{{asset('js/home-action.js')}}"></script>
    <script src="{{asset('front-end/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('front-end/js/select2.full.js')}}"></script>

    <script>

        $(document).ready(function () {



            var $outerwidth = $('.row-header header .outer-width-box');
            var $innerwidth = $('.row-header header .inner-width-box');

            function checkWidth() {

                var outersize = $outerwidth.width();
                var innersize = $innerwidth.width();

                if (innersize > outersize) {

                    $('body').addClass("navmobile");

                } else {

                    $('body').removeClass("navmobile");
                    $('body').removeClass("offcanvas-menu-show");

                }


            }

            checkWidth();
            $(window).resize(checkWidth);


            $('.offcanvas-menu-backdrop').on('click', function (e) {
                $('body').toggleClass("offcanvas-menu-show");
                e.preventDefault();
            });

            $('.wrapper_bottom_footer > .row-header-mobile header a.navtoggler').on('click', function (e) {
                $('body').toggleClass("offcanvas-menu-show");
                e.preventDefault();
            });

            function doResize($wrapper, $el) {

                var scale = Math.min(
                    $wrapper.outerWidth() / $el.outerWidth(),
                    $wrapper.outerHeight() / $el.outerHeight()
                );

                if (scale < 1) {

                    $el.css({
                        '-webkit-transform': 'scale(' + scale + ')',
                        '-moz-transform': 'scale(' + scale + ')',
                        '-ms-transform': 'scale(' + scale + ')',
                        '-o-transform': 'scale(' + scale + ')',
                        'transform': 'scale(' + scale + ')'
                    });

                } else {

                    $el.removeAttr("style");

                }

            }


            doResize($(".wrapper_home_slider .text-over-slider"), $(".wrapper_home_slider .content-to-scale"));
            $(window).resize(function () {
                doResize($(".wrapper_home_slider .text-over-slider"), $(".wrapper_home_slider .content-to-scale"));
            });

            $('body').on('click', '.close_open', function () {
               $('#myModalSuccessfulReg').modal('hide');
            });

            $('body').on('change', '.type-user-select', function () {
                $('.type-user').val( $('.type-user-select').val() )
            });

            $('body').on('click', '.login_button_class', function () {
                $('.close').click()

                setTimeout(function () {
                    $('#myModalLogin').modal('show');
                    setTimeout(function () {
                        $('body').addClass('modal-open');
                        $('body').removeClass('offcanvas-menu-show')

                    }, 500);

                }, 200);
            });

            $('body').on('click', '.termsAndConditions', function (e) {
                e.preventDefault()
                $('#type_tab').val($(this).data('type'))
                $('#myModalSingOrgRegistration').modal('hide');
                $('#myModalSingVolRegistration').modal('hide');
                setTimeout(function () {
                    $('#myModalTermsAndConditions').modal('show')
                    $('body').removeClass('offcanvas-menu-show')
                    setTimeout(function () {
                        $('body').addClass('modal-open');
                    }, 500);
                }, 200);
            })


            $('#btn_agree').on('click',function () {
                $('#o_accept_terms').prop('checked', true);
                $('#v_accept_terms').prop('checked', true);
                $('#myModalTermsAndConditions').modal('hide')
                setTimeout(function () {
                    if($('#type_tab').val() == 'org'){
                        $('#myModalSingOrgRegistration').modal('show');
                        $('body').removeClass('offcanvas-menu-show')
                        setTimeout(function () {
                            $('body').addClass('modal-open');
                        }, 500);
                    }
                    else{
                        $('#myModalSingVolRegistration').modal('show');
                        $('body').removeClass('offcanvas-menu-show')
                        setTimeout(function () {
                            $('body').addClass('modal-open');
                        }, 500);
                    }
                }, 200);
            });


            @if(!Auth::check())
                $(document).on('click', '.vol_registr', function (e) {
                e.preventDefault()
                scroll(0, 0)
                setTimeout(function () {
                    var text = 'Volunteer';
                    $('.type-user').val(text)
                    $('#myModalSingVolRegistration').modal('show');
                    $('body').removeClass('offcanvas-menu-show')
                    setTimeout(function () {
                        $('body').addClass('modal-open');
                    }, 500);
                }, 200)
                });

                $(document).on('click', '.org_registr', function (e) {
                    scroll(0, 0)
                    setTimeout(function () {
                    e.preventDefault()
                    var text = 'Organization';
                    $('.type-user').val( text )
                    $('#myModalOrgType').modal('show');
                        $('body').removeClass('offcanvas-menu-show')
                        setTimeout(function () {
                            $('body').addClass('modal-open');
                        }, 500);

                    }, 200)
                });

                $(document).on('click', '.inst_registr', function (e) {
                    e.preventDefault()
                    scroll(0, 0)
                    var text = 'Organization';
                    $('.type-user').val(text)
                    $('#org_type').val(1);
                    $('#chooseTypeOrg').click();
                    setTimeout(function () {

                    }, 200);
                });
            @endif


            $('body').on('click', '#chooseTypeOrg', function (e) {
                e.preventDefault()
                var typeOrg = $('#org_type').val();

                if (typeOrg == 1) {

                    $('.ein_div').hide();
                    $('.org_name_label').text('School Name:')
                    $('.org_type_div').hide()
                    $('.non-org-type').hide();
                    $('.school_type').show();
                }

                else if (typeOrg == 2) {
                    $('.org_type_div').hide()
                    $('.ein_div').show();
                    $('.org_name_label').text('Organization Name:')
                    $('.school_type').hide();
                    $('.non-org-type').show();
                }

                else if (typeOrg == 3) {
                    $('.ein_div').hide();
                    $('.org_type_div').show();
                    $('.school_type').hide();
                    $('.non-org-type').hide();
                }

                else{
                    $('.org_type_div').hide()
                    $('.ein_div').hide();
                    $('.school_type').hide();
                    $('.non-org-type').hide();
                }

                $('#myModalOrgType').modal('hide');
                setTimeout(function () {
                    $('#myModalSingOrgRegistration').modal('show');
                    $('body').removeClass('offcanvas-menu-show')
                    setTimeout(function () {
                        $('body').addClass('modal-open');
                    }, 500);
                }, 200);
            });


            $('body').on('click', '#login_button', function () {
                console.log(54)
                $('.close').click()
                $('#myModalLogin').modal('show');
                $('body').removeClass('offcanvas-menu-show')
                setTimeout(function () {
                    $('body').addClass('modal-open');
                }, 500);
            });



            $('body').on('click', '#forPass', function (e) {
                e.preventDefault()
                $('#myModalLogin').modal('hide');
                setTimeout(function () {
                    $('#myModalForgotPassword').modal('show');
                    $('body').removeClass('offcanvas-menu-show')
                    setTimeout(function () {
                        $('body').addClass('modal-open');
                    }, 500);
                }, 200);
            });

            $('body').on('click', '.registration_button', function () {
                $('#myModalUserTipe').modal('show');
                $('body').removeClass('offcanvas-menu-show')
                setTimeout(function () {
                    $('body').addClass('modal-open');
                }, 500);
            });

            $('body').on('click', '.registration_button_on_modal_form', function (e) {
                e.preventDefault()
                $('#myModalLogin').modal('hide');
                setTimeout(function () {
                    $('#myModalUserTipe').modal('show');
                    $('body').removeClass('offcanvas-menu-show')
                    setTimeout(function () {
                        $('body').addClass('modal-open');
                    }, 500);
                }, 200);
            });

            $("select").select2({
                theme: "bootstrap",
                minimumResultsForSearch: -1
            });



            $('body').on('click', '#chooseType', function (e) {
                e.preventDefault()
                var typeUser = $('.type-user').val();
                if (typeUser === 'Volunteer') {
                    $('#myModalUserTipe').modal('hide');
                    setTimeout(function () {
                        $('#myModalSingVolRegistration').modal('show');
                        $('body').removeClass('offcanvas-menu-show')
                        setTimeout(function () {
                            $('body').addClass('modal-open');
                        }, 500);
                    }, 200);
                }
                else if (typeUser === 'Organization') {

                    $('#myModalUserTipe').modal('hide');
                    setTimeout(function () {
                        $('#myModalOrgType').modal('show');
                        $('body').removeClass('offcanvas-menu-show')
                        setTimeout(function () {
                            $('body').addClass('modal-open');
                        }, 500);
                        // $('#myModalSingOrgRegistration').modal('show');
                    }, 200);
                }
            });

            $('body').on('click', '.previous', function () {
                $('#myModalSingVolRegistration').modal('hide');

                $('#myModalSingOrgRegistration').modal('hide');
                setTimeout(function () {
                    if ($('.type-user').val() == 'Volunteer'){
                        $('#myModalUserTipe').modal('show');
                        $('body').removeClass('offcanvas-menu-show')
                        setTimeout(function () {
                            $('body').addClass('modal-open');
                        }, 500);
                    }
                    else{
                        $('#myModalOrgType').modal('show');
                        $('body').removeClass('offcanvas-menu-show')
                        setTimeout(function () {
                            $('body').addClass('modal-open');
                        }, 500);
                    }
                }, 200);
            });

            $('.wrapper_input.fa-icons input').datepicker({
                'format': 'mm/dd/yyyy',
                'autoclose': true,
                'orientation': 'right',
                'todayHighlight': true
            });

            $('body').on('click', '.gender', function () {
                if ($('.gender-radio').val() == 'male') {
                    $('.gender-radio').val('female')

                }
                else {
                    $('.gender-radio').val('male')

                }

            });


        });
        $(document).ready(function () {
            $('.terms-conditions-vol').click(function () {
                if ($('.terms-conditions-vol-value').val() == 0) {
                    $('.terms-conditions-vol-value').val(1)

                } else {
                    $('.terms-conditions-vol-value').val(0)

                }
            });

            $('.years-old-check').click(function () {
                if ($('.years-old-check-value').val() == 0) {
                    $('.years-old-check-value').val(1)

                } else {
                    $('.years-old-check-value').val(0)

                }
            });

            $('.terms-conditions-org').click(function () {
                if ($('.terms-conditions-org-value').val() == 0) {

                    $('.terms-conditions-org-value').val(1);

                } else {

                    $('.terms-conditions-org-value').val(0);
                }

            });
        });

    </script>

    @yield('script')

    </body>

@endsection
