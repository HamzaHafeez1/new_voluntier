@extends('layout.masterForAuthUser')


@section('css')
    <link rel="stylesheet" href="{{asset('front-end/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/chat.css')}}">
@endsection

@section('content')

    <div class="row-content wrapper-chat-box">


        <!-- -->
        <!-- -->
        <!-- -->

        <div class="wraper_ie_frame">

            <div class="space_frame">
            </div>
            <div id="frame" class="frame">
                <div id="sidepanel" class="sidepanel">

                    <div class="search">
                        <label><span class="gl-icon-search"></span></label>
                        <input type="text" placeholder="Search&hellip;">
                    </div>

                    <div class="top-bar"><ul>
                            <li><a href="#" class="active"><span>Groups</span></a></li>
                            <li><a href="#"><span>Friends</span></a></li>
                        </ul></div>

                    <div id="contacts" class="contacts">
                        <ul>

                            <!-- -->

                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Louis Litt</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact active">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Harvey Specter</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Rachel Zane</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Donna Paulsen</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Jessica Pearson</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Harold Gunderson</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Daniel Hardman</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Katrina Bennett</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Charles Forstman</p>
                                    </div>
                                </div>
                            </li>
                            <li class="contact">
                                <div class="wrap">
                                    <div class="avatar" style="background-image:url('{{asset('img/people/louislitt.png')}}')"></div>
                                    <div class="meta">
                                        <p class="name">Jonathan Sidwell</p>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
                <div class="content">
                    <div class="contact-profile">
                        <p><a href="#" class="navtoggler"><span>Menu</span></a> Harvey Specter</p>
                    </div>
                    <div class="messages">
                        <ul>
                            <li class="sent">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name"><span>Emma Smith</span></p>
                                    <p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
                                </div>
                            </li>
                            <li class="replies">
                                <div class="avatar" style="background-image:url({{asset('img/people/mikeross.png')}})"></div>
                                <div>
                                    <p class="name"><span>Emma Smith</span></p>
                                    <p>When you're backed against the wall, break the god damn thing down.</p>
                                </div>
                            </li>
                            <li class="replies">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name"><span>Emma Smith Emma Smith Emma Smith Emma Smith Emma Smith Emma Smith</span></p>
                                    <p>Excuses don't win championships.</p>
                                </div>
                            </li>
                            <li class="sent">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name"><span>Emma Smith</span></p>
                                    <p>Oh yeah, did Michael Jordan tell you that?</p>
                                </div>
                            </li>
                            <li class="replies">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name"><span>Emma Smith</span></p>
                                    <p>No, I told him that.</p>
                                </div>
                            </li>
                            <li class="replies">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name"><span>Emma Smith</span></p>
                                    <p>What are your choices when someone puts a gun to your head?</p>
                                </div>
                            </li>
                            <li class="sent">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name"><span>Emma Smith</span></p>
                                    <p>What are you talking about? You do what they say or they shoot you.</p>
                                </div>
                            </li>
                            <li class="replies">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name"><span>Emma Smith</span></p>
                                    <p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
                                </div>
                            </li>

                            <li class="sent">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name">
                                        <span>Emma Smith Emma Smith Emma Smith Emma Smith Emma Smith Emma Smith</span>
                                        <span class="date">19 April 4:20 PM</span>
                                    </p>
                                    <p>Pityful a rethoric question ran over her cheek, then.</p>
                                </div>
                            </li>
                            <li class="replies">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name">
                                        <span>Jacob Davies</span>
                                        <span class="date">17 April 3:20 PM</span>
                                    </p>
                                    <p>
                                        Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
                                        there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics,
                                        a large language ocean. A small river named Duden flows by their place and supplies it
                                        with the necessary regelialia.
                                    </p>
                                </div>
                            </li>
                            <li class="sent">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name">
                                        <span>Emma Smith</span>
                                        <span class="date">17 April 3:21 PM</span>
                                    </p>
                                    <p>
								<span class="attachment">
									<a data-fancybox="gallery" href="img/people/harveyspecter.png"><img src="img/people/harveyspecter.png" alt=""></a>
									<a data-fancybox="gallery" href="img/myvoluntier/myvoluntier-banner-1.png"><img src="img/myvoluntier/myvoluntier-banner-1.png" alt=""></a>
									<a data-fancybox="gallery" href="img/people/mikeross.png"><img src="img/people/mikeross.png" alt=""></a>
									<a data-fancybox="gallery" href="img/home/001.png"><img src="img/home/001.png" alt=""></a>
									<a data-fancybox="gallery" href="img/people/harveyspecter.png"><img src="img/people/harveyspecter.png" alt=""></a>
								</span>
                                    </p>
                                </div>
                            </li>
                            <li class="sent">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name">
                                        <span>Daniel Wilson</span>
                                        <span class="date">18 April 5:18 PM</span>
                                    </p>
                                    <p>
                                        Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.
                                    </p>
                                </div>
                            </li>
                            <li class="replies">
                                <div class="avatar" style="background-image:url('{{asset('img/people/mikeross.png')}}')"></div>
                                <div>
                                    <p class="name">
                                        <span>Emma Smith</span>
                                        <span class="date">19 April 4:20 PM</span>
                                    </p>
                                    <p>Pityful a rethoric question ran over her cheek, then.</p>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="message-input">
                        <div class="wrap clearfix">
                            <textarea placeholder="Enter your message here&hellip;"></textarea>
                            <a href="#" class="attachment"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                            <a href="#" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidepanel-backdrop"></div>
            </div>

        </div>


        <!-- -->
        <!-- -->
        <!-- -->


    </div>
@endsection

@section('script')
    <script src="front-end/js/jquery.fancybox.js"></script>

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


            $('.sidepanel-backdrop').on('click', function (e) {
                $('#frame').toggleClass("sidepanel-show");
                e.preventDefault();
            });

            $('.wrapper-chat-box .frame a.navtoggler').on('click', function (e) {
                $('#frame').toggleClass("sidepanel-show");
                e.preventDefault();
            });

        });

    </script>
@endsection