@extends('layout.masterForAuthUser')



@section('css')

    <link rel="stylesheet" href="{{asset('front-end/css/print.css')}}" media="print">
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

                    <a href="javascript:void(0)" onclick="window.print()" class="print"><span><i class="fa fa-print" aria-hidden="true"></i></span></a>

                </div>
            </div>

            <div class="row align-items-center border-bottom-0">
                <div class="col-12 col-md-4">

                    <div class="main-text">
                        <h3 class="h3 text-center">Ranked</h3>
                        <p class="mb-0 text-center green middle"><strong class="big">{{$rank}}</strong>
                            @if($rank>0)

                                @if($rank==1)st

                                @elseif($rank==2)nd

                                @elseif($rank==3)rd

                                @else th

                                @endif

                            @endif</p>
                        <p class="light text-center">in @if($userDetails->country != null)

                                {{ $userDetails->country }}

                            @endif

                        </p>

                        <p class="mb-0 text-center green big"><strong>@if(count($trackedHour)>0) {{ round($trackedHour[0]->SUM/60) }} @else 0 @endif</strong></p>
                        <p class="mb-0 text-center green middle">HOUR(S)</p>
                        <p class="light text-center">contributed since creation</p>
                    </div>

                </div>
                <div class="col-12 col-md-8 border-left">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" href="#month" role="tab"
                               data-toggle="tab"><span>Last Month</span></a>
                        </li>
                        <li class="nav-item second">
                            <a class="nav-link" href="#month-6" role="tab"
                               data-toggle="tab"><span>Last 6 month</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#year" role="tab" data-toggle="tab"><span>Last year</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#date" role="tab" data-toggle="tab"><span>Year to date</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active show" id="month">

                            <div id="container-1" class="wrapper-svg"></div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="month-6">

                            <div id="container-6" class="wrapper-svg"></div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="year">

                            <div id="container-1-year" class="wrapper-svg"></div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="date">

                            <div id="container-year-date" class="wrapper-svg"></div>

                        </div>

                    </div>


                </div>
            </div>

            <div class="row align-items-center border-bottom-0">
                <div class="col-12 col-md-8">

                    <!--
                        Top 5 Opportunities
                        Helping Orphans
                        460 hrs
                        Homeless Animals
                        386 hrs
                        Charity Event NY
                        781 hrs
                        Cleaning Сentral Park
                        522 hrs
                        Charity Event SF
                        814 hrs
                        Charity Event BS
                        140 hrs
                        Helping Orphans
                        40 hrs
                    -->
                    <div id="container-2" class="wrapper-svg"></div>

                </div>
                <div class="col-12 col-md-4 border-left">

                    <div id="container-3" class="wrapper-svg"></div>

                </div>
            </div>


            <div class="row">
                <div class="col-12">

                    <div class="main-text">

                        <h3 class="h3">Past Records</h3>

                        @if(count($trackedHour)>0)

                            @if(round($trackedHour[0]->SUM/60) != 0)


                                    @if($top5_list['is_top5_state_lastYear'] == 1)

                                    <p class="light mb-0">Top 5 Groups in the State (number of hours contributed during the last year)</p>

                                    @endif



                                    @if($top5_list['is_top10_country_lastYear'] == 1)

                                            <p class="light">Top 10 Groups in the Country (number of hours contributed during the last year)</p>

                                    @endif



                                    @if($top5_list['is_top5_state_lastMonth'] == 1)

                                            <p class="light mb-0">Top 5 Groups in the State (number of hours contributed during the last month)</p>

                                    @endif



                                    @if($top5_list['is_top10_country_lastMonth'] == 1)



                                            <p class="light">Top 10 Groups in the Country (number of hours contributed during the last month)</p>

                                    @endif



                                    @if($top5_list['is_top5_state'] == 1)

                                            <p class="light mb-0">Top 5 Groups in the State (number of volunteers)</p>

                                    @endif



                                    @if($top5_list['is_top10_country'] == 1)

                                            <p class="light mb-0">Top 10 Groups in the Country (number of volunteers)</p>

                                    @endif



                            @endif

                        @endif


                    </div>

                </div>
            </div>

        </div>
    </div>


@endsection



@section('script')
    <script src="{{asset('js/highcharts.js')}}"></script>


    <script>
        Highcharts.chart('container-1', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -90,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'normal',
                        fontFamily: 'Open Sans, sans-serif',
                        color: '#9ca0a1'
                    }
                }
            },
            yAxis: {
                min: 0,
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
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>' + this.y + '</b>';
                }
            },
            series: [{
                name: 'Population',
                color: '#03a9f4',
                data: [

                   @foreach($lastMonth as $date)

                    ['{{date('d M',strtotime($date->logged_date))}}', {{round($date->SUM/60)}}],

                    @endforeach

                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });


        Highcharts.chart('container-6', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -90,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'normal',
                        fontFamily: 'Open Sans, sans-serif',
                        color: '#9ca0a1'
                    }
                }
            },
            yAxis: {
                min: 0,
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
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>' + this.y + '</b>';
                }
            },
            series: [{
                name: 'Population',
                color: '#03a9f4',
                data: [

                    @foreach($sixMonth as $sixmonth)

                    ['{{date('M',strtotime($sixmonth->logged_date))}}', {{round($sixmonth->SUM/60)}}],

                    @endforeach

                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });


        Highcharts.chart('container-1-year', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -90,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'normal',
                        fontFamily: 'Open Sans, sans-serif',
                        color: '#9ca0a1'
                    }
                }
            },
            yAxis: {
                min: 0,
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
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>' + this.y + '</b>';
                }
            },
            series: [{
                name: 'Population',
                color: '#03a9f4',
                data: [

                    @foreach($LastYear as $lastYear)

                    ['{{date('M',strtotime($lastYear->logged_date))}}', {{round($lastYear->SUM/60)}}],

                    @endforeach

                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });

        Highcharts.chart('container-year-date', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -90,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'normal',
                        fontFamily: 'Open Sans, sans-serif',
                        color: '#9ca0a1'
                    }
                }
            },
            yAxis: {
                min: 0,
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
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>' + this.y + '</b>';
                }
            },
            series: [{
                name: 'Population',
                color: '#03a9f4',
                data: [

                    @foreach($year as $year)

                    ['{{date('Y',strtotime($year->logged_date))}}', {{round($year->SUM/60)}}],

                    @endforeach

                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });
    </script>



    <script>
        Highcharts.chart('container-2', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Top 5 Opportunities',
                style: {"color": "#27282f", "fontSize": "24px", "fontFamily": 'Open Sans, sans-serif'}
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                lineWidth: 0,
                tickLength: 0,
                categories: [

                @if(count($opportunityList)>0)

                    @for($i=0; $i < count($opportunityList); $i++)
                        @if($i === 5)
                           @break;
                        @endif
                        '{!! $opportunityList[$i]->title !!}',
                    @endfor

                @endif

                ],
                title: {
                    text: ''
                },
                labels: {
                    style: {
                        fontSize: '14px',
                        fontWeight: 'normal',
                        fontFamily: 'Open Sans, sans-serif',
                        color: '#28292e'
                    }
                }
            },
            yAxis: {
                visible: false
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Open Sans, sans-serif',
                            fontWeight: 'normal',
                            color: '#fff',
                            textOutline: ''
                        },
                        align: 'right',
                    },
                    showInLegend: false
                }
            },
            credits: {
                enabled: false
            },
            tooltip: {
                enabled: true,
                    formatter: function() {
                    return '<b>' + this.x +':'+ this.y + '</b>';
                }

            },
            series: [{
                pointWidth: 40,
                color: '#42bd41',
                data: [
                    @if(count($opportunityList)>0)

                     @for($i=0; $i < count($opportunityList); $i++)
                        @if($i === 5)
                            @break;
                        @endif
                         {{$opportunityList[$i]->tracked_hours}},

                     @endfor

                @endif
                ],
                dataLabels: {
                    format: '{y} hrs'
                }
            }]
        });
    </script>

    <script>
        Highcharts.chart('container-3', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                enabled: true,
                formatter: function() {
                    return '<b>' + this.point.name +':'+ this.y + '</b>';
                }

            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                    },
                    showInLegend: true
                }
            },
            legend: {
                itemStyle: {
                    color: '#9ca0a1',
                    fontSize: '14px',
                    fontWeight: 'normal',
                    fontFamily: 'Open Sans, sans-serif',
                    textOverflow: 'ellipsis'
                }
            },




            series: [{
                name: '',
                colorByPoint: true,
                data: [

                    @if (count($opportunityGroupBycategory) > 0)

                            @foreach ($opportunityGroupBycategory as $value)
                                {
                                      name: '{!! $value->name !!}',
                                      y: {{$value->COUNT }}
                                },
                            @endforeach

                    @endif


                ]
            }]
        });
        $("#bars li .bar").each(function (key, bar) {

            var percentage = $(this).data('percentage');

            $(this).css('border', '1px solid #3f5ef8');

            $(this).animate({

                'height': percentage + '%'

            }, 1000);





        })
    </script>



@endsection

