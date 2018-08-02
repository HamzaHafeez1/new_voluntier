@extends('layout.masterForAuthUser')

@section('css')

    <link rel="stylesheet" href="{{asset('front-end/css/star-rating.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/print.css')}}" media="print">
    <style>
        a {
            text-decoration: none !important;
        }
        .star{
           cursor: default;
        }
        .rating-xs {
            font-size: inherit !important;
        }
    </style>

@endsection



@section('content')
    <div class="wrapper-impact">
        <div class="container">

            <div class="row align-items-center border-bottom-0">
                <div class="col">

                    <div class="main-text">
                        <h2 class="h2">Impact</h2>
                    </div>

                </div>
                <div class="col col-auto">

                    <a href="#" onclick="myFunction()" class="print"><span><i class="fa fa-print"
                                                                              aria-hidden="true"></i></span></a>

                </div>
            </div>

            <div class="row align-items-center border-bottom-0">
                <div class="col-12 col-md-4">

                    <div class="main-text">
                        {{--<h3 class="h3 text-center">Ranked</h3>--}}
                        <p class="mb-0 text-center green middle"><strong class="big" id="my_ranking">1</strong></p>
                        <p class="light text-center">Your Ranking Among Friends</p>

                        <p class="mb-0 text-center green big"><strong>{{$logged_mins}}</strong></p>
                        <p class="mb-0 text-center green middle">HOUR(S)</p>
                        <p class="light text-center">Your Total Tracked Hours</p>
                    </div>

                </div>
                <div class="col-12 col-md-8 border-left">


                    <div id="container-4" class="wrapper-svg"></div>


                </div>
            </div>

            <div class="row border-bottom-0">
                <div class="col">
                    <div class="main-text"><h2 class="h2">Ranking &amp; Tracking Hours on Organizations</h2></div>
                </div>
            </div>

            <div class="row border-bottom-0">
                <div class="col-12 col-md-4">


                    <div class="main-text">

                        <h3 class="h3">Ranking Among Organization</h3>

                        <div class="wrapper-table-impact">
                            <div>

                                <table>
                                    <thead>
                                    <tr>
                                        <th><p>#</p></th>
                                        <th><p>Organization</p></th>
                                        <th><p class="text-center">Rank</p></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>

                                    @foreach($org_ranking as $ranking)

                                        <tr>

                                            <td><p>{{$i}}</p></td>

                                            <td><p>{{$ranking['org_name']}}</p></td>

                                            <td><p class="text-center">{{$ranking['my_ranking']}}</p></td>

                                        </tr>

                                        <?php $i++; ?>

                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>


                </div>
                <div class="col-12 col-md-8 border-left">


                    <div id="container-5" class="wrapper-svg"></div>


                </div>
            </div>


            <div class="row border-bottom-0">
                <div class="col">
                    <div class="main-text"><h2 class="h2">Performance Awards
                            for {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h2></div>
                </div>
            </div>

            <div class="row border-bottom-0">
                <div class="col">


                    <div class="main-text">

                        <div class="wrapper-table-impact">
                            <div>

                                <table>
                                    <thead>
                                    <tr>
                                        <th><p>#</p></th>
                                        <th><p>Opportunity</p></th>
                                        <th><p>Submission Date</p></th>
                                        <th><p class="text-center">Tracked Hours</p></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $j = 1; ?>

                                    @foreach($opp_hours as $oh)

                                        <tr>

                                            <td><p>{{$j}}</p></td>

                                            <td><p>{{$oh->opp_name}}</p></td>

                                            <td><p>{{$oh->submitted_date}}</p></td>

                                            <td><p class="text-center">{{floatval($oh->logged_hours)}}</p></td>

                                        </tr>

                                        <?php $j++; ?>

                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>


                </div>
            </div>

            <div class="row border-bottom-0">
                <div class="col">
                    <div class="main-text"><h2 class="h2">Comments &amp; Review</h2></div>
                </div>
            </div>


            <div class="row">
                <div class="col">

                    <div class="wrapper-comments-review">
                        <ul class="notifications-list">

                            @foreach($reviews as $r)

                                <?php $date = explode(' ', $r->updated_at); $updated_at = date('F j, Y', strtotime($date[0])); ?>
                                <li>

                                    <div class="row flex-container-1">
                                        <div class="col col-auto flex-item-1">

                                            <div class="avatar"
                                                 @if($r->org_logo == null)
                                                 style="background-image:url('{{asset('front-end/img/org/001.png')}}')"


                                                 @else

                                                 style="background-image:url('<?=asset('uploads')?>/{{$r->org_logo}}')"

                                                    @endif

                                            ></div>
                                        </div>
                                        <div class="col flex-item-1">

                                            <div class="row flex-container-2">
                                                <div class="col flex-item-2">

                                                    <div class="main-text">
                                                        <a href="{{url('/profile')}}/{{$r->review_from}}"><p
                                                                    class="name">{{$r->org_name}}</p></a>
                                                        <p class="star">
                                                        <input type="text" class="kv-fa rating-loading" value="{{$r->mark}}" data-size="xs" title="">
                                                        </p>
                                                        <p class="light">{{$r->comment}}</p>
                                                    </div>

                                                </div>
                                                <div class="col col-auto flex-item-2">
                                                    <div class="rating-stars">
                                                                                    </div>
                                                    <div class="main-text text-right">
                                                        <p class="date"> ({{$updated_at}})</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </li>



                            @endforeach


                        </ul>
                    </div>


                </div>
            </div>


        </div>
    </div>
@endsection



@section('script')

    <script src="{{asset('front-end/js/star-rating.js')}}"></script>
    <script src="{{asset('front-end/js/highcharts.js')}}"></script>


    <script>
        $(document).ready(function() {
            $('.kv-fa').rating({
                displayOnly: true,
                clearButton: '<i class="fa fa-minus-circle"></i>',
                filledStar: '<i class="fa fa-star"></i>',
                emptyStar: '<i class="fa fa-star-o"></i>'
            });

            viewFriendGraph();
        });
    </script>



    <script>





        function viewFriendGraph() {

            var url = '{{route('volunteer-get-friend-info')}}';

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });





            var type = "post";

            $.ajax({

                type: type,

                url: url,

                success: function (data) {

                    var friend_chart = Highcharts.chart('container-4', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Tracked Hours of Your Friends',
                            style:{ "color": "#27282f", "fontSize": "24px",  "fontFamily": 'Open Sans, sans-serif' }
                        },
                        plotOptions: {
                            column: {
                                colorByPoint: true
                            }
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'normal',
                                    fontFamily: 'Open Sans, sans-serif',
                                    color: '#9ca0a1'
                                }
                            },
                            categories: data.friend_name
                        },
                        yAxis: {

                            title: {
                                text: ''
                            },
                            labels: {
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'normal',
                                    fontFamily: 'Open Sans, sans-serif',
                                    color: '#9ca0a1'
                                }
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        series: [{
                            name: 'Tracked Hours',
                            data: data.logged_hours

                        }]
                    });


                    $('#my_ranking').html(data.rank);

                    var org_chart =  Highcharts.chart('container-5', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Ranking Among Organization',
                            style:{ "color": "#27282f", "fontSize": "24px",  "fontFamily": 'Open Sans, sans-serif' }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || '#434348',
                                        fontWeight:'normal',
                                        fontSize:'14px',
                                        fontFamily: 'Open Sans, sans-serif',
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'Tracked Hours',
                            data: data.org_hours

                        }]
                    });

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        }



    </script>
    <script>

    </script>

    <script>

    </script>

    <script>

        function myFunction() {

            window.print();

        }

    </script>


@endsection