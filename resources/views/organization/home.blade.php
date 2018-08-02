@extends('layout.masterForAuthUser')


@section('content')
    <div class="dashboard_org">


        <div class="container">

            <div class="news-followed-box mt25">

                <div class="main-text"><h2 class="h2">News Feeds</h2></div>

                <div class="row">
                    <div class="col-12 col-md-8">


                        <ul class="news-feeds-list">
                            @if (count($feedNewsArr) > 0)
                                @foreach($feedNewsArr as $nawfVal)
                                    <li><a href="{{url( $nawfVal['userurl']) }}">
                                            <span >
                                                <i class="fa {{ !preg_match("/left/", $nawfVal['reason']) ? 'fa-check' : 'fa-exclamation-triangle'}}" aria-hidden="true">
                                                </i>
                                            </span>

                                            <span>
                                                <span> {{  ucfirst($nawfVal['reason']) }} by {{ $nawfVal['who_joined'] }} on {{ $nawfVal['name'] }}</span>
                                                <span class="light">{{ $nawfVal['created_at'] }}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                        <div class="col-12 col-md-4">


                            <div class="wrapper-right-text-info ads-banner"></div>

                        </div>


                    </div>


            </div>


        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/jquery.bxslider-rahisified.js')}}"></script>

    <script>
        $(document).ready(function() {
        $('.dashboard_org .track-it-time_slider > div.slider').bxSlider({
            pager: true,
            slideMargin: 0,
            speed: 1000,
            hideControlOnEnd: true,
            auto: true,
            infiniteLoop: true,
            autoReload: true,
            controls: false,
            breaks: [{screen:0, slides:1}]

        });

        /* --------------- */

        function doResize($wrapper,$el) {

            var scale = Math.min(
                $wrapper.outerWidth() / $el.outerWidth(),
                $wrapper.outerHeight() / $el.outerHeight()
            );

            if ( scale < 1) {

                $el.css({
                    '-webkit-transform' : 'scale(' + scale + ')',
                    '-moz-transform'    : 'scale(' + scale + ')',
                    '-ms-transform'     : 'scale(' + scale + ')',
                    '-o-transform'      : 'scale(' + scale + ')',
                    'transform'         : 'scale(' + scale + ')'
                });

            } else {

                $el.removeAttr( "style" );

            }

        }



        $('.dashboard_org .track-it-time_slider .slider-wrapper > div').each(function() {
            doResize($(this),$(this).find('.slider-item-scale > div'));
        });

        $(window).resize(function () {
            $('.dashboard_org .track-it-time_slider .slider-wrapper > div').each(function() {
                doResize($(this),$(this).find('.slider-item-scale > div'));
            });
        });

        });

    </script>
@endsection