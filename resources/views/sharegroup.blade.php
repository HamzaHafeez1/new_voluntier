@extends('layout.masterForAuthUser')



@section('css')

    <link href="<?=asset('css/plugins/footable/footable.core.css')?>" rel="stylesheet">

    <style>

        img {
            width: 70px;
        }

    </style>
    <style>
        a {
            text-decoration: none !important;
        }
        .pagination .flex-wrap .justify-content-center{
            margin: 0;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            padding: 0;
        }

        .footable-page-arrow, .footable-page{
            display: list-item;
            text-align: -webkit-match-parent;
        }

        .footable-page-arrow a, .footable-page a{
            position: relative;
            display: block;
            padding: 10px;
            margin: 10px 5px;
            font-size: 16px;
            line-height: 20px;
            font-family: 'Open Sans',sans-serif;
            color: #5f5f5f;
            background: none;
            border: 0 none;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            text-decoration: none;
            cursor: auto;
            outline: none;
            z-index: auto;
        }

        .footable-page-arrow a:hover, .footable-page a:hover{
            z-index: auto;
            color: #fff;
            text-decoration: none;
            background-color: #38b348;
            border: 0 none;
        }

        .footable-page-arrow a[data-page=prev], .footable-page-arrow a[data-page=next], .footable-page-arrow.disabled{
            display: none;
        }

        .footable-page.active a{
            z-index: auto;
            color: #fff;
            text-decoration: none;
            background-color: #38b348;
            border: 0 none;
        }
    </style>

@endsection



@section('content')

    <div class="wrapper-groups_org">
        <div class="container">

            <div class="row row-padding">
                <div class="col-12">

                    <!-- -->
                    <!-- -->
                    <!-- -->
                    <!-- -->


                    @if(count($groupList)>0)

                        @foreach($groupList as $key => $lists)

                            <div class="card tab-pane fade show active">


                                <div class="card-body">


                                    <div class="line-button">
                                        <div class="main-text">

                                            <div class="row align-items-center">
                                                <div class="col-12">
                                                    <h2 class="h2">{{$lists->name}}</h2>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!---- ----->

                                    <div class="banner-text-box  shift-15">
                                        <div class="row no-gutters">
                                            <div class="col-12 col-md-8" @if($lists->banner_image!='')style="background-image: url('{{asset('/uploads/volunteer_group_banner/thumb'). '/' . $lists->banner_image}}')"@endif></div>
                                            <div class="col-12 col-md-4">

                                                <div class="main-text">
                                                    <p>IMPACTS</p>
                                                    <p class="bold">{{round($lists->tracked_hours/60)}}</p>
                                                    <p class="light">HOUR(S)</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!---- ---->

                                    <div class="wrapper-tablist  shift-15">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active show" href="#members" role="tab"
                                                   data-toggle="tab" aria-selected="false"><span>Members</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#impact" role="tab" data-toggle="tab"
                                                   aria-selected="false"><span>Impact</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!---- ---->

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active show" id="members">


                                            <div class="main-text">

                                                <div class="wrapper-sort-table wrapper-table-org">
                                                    <div>

                                                        <table  class="table sortable example">
                                                            <thead>
                                                            <tr>
                                                                <th>
                                                                    <div class="main-text"><p>Name</p></div>
                                                                </th>
                                                                <th>
                                                                    <div class="main-text"><p>Location</p></div>
                                                                </th>
                                                                {{--<th>--}}
                                                                    {{--<div class="main-text"><p>Impact</p></div>--}}
                                                                {{--</th>--}}
                                                                <th>
                                                                    <div class="main-text"><p>Rating</p></div>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($lists->members as $members)

                                                                <tr>

                                                                    <td>{{($members->user_role == 'organization') ? $members->org_name : $members->first_name.' '.$members->last_name}}</td>

                                                                    <td>{{implode(', ', array_filter([$members->city ,$members->state]))}}</td>

                                                                    {{--<td>2 h</td>--}}

                                                                    <td>{{empty($members->mark) ? 0 : $members->mark}}</td>

                                                                </tr>

                                                            @endforeach
                                                            </tbody>
                                                        </table>

                                                    </div>


                                                </div>


                                            </div>


                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="impact">

                                            <!------- -->

                                            <div class="wrapper-impact pb-0 pt-0">


                                                <div class="row align-items-center border-top-0 border-left-0 border-right-0">
                                                    <div class="col"></div>
                                                    <div class="col col-auto">

                                                        <a href="javascript:void(0)" onclick="window.print()"
                                                           class="print"><span><i class="fa fa-print"
                                                                                  aria-hidden="true"></i></span></a>

                                                    </div>
                                                </div>


                                                <div class="row align-items-center border-top-0 border-left-0 border-right-0">
                                                    <div class="col-12 col-md-4">

                                                        <div class="main-text">
                                                            <h3 class="h3 text-center">Ranked</h3>
                                                            <p class="mb-0 text-center green middle"><strong
                                                                        class="big">{{$lists->rank}}</strong>@if($lists->rank==1)
                                                                    st @elseif($lists->rank==2)
                                                                    nd @elseif($lists->rank==3) rd @else th @endif</p>
                                                            <p class="light text-center">
                                                                in {{$lists->creatorDetails->country}}</p>

                                                            <hr>

                                                            <p class="mb-0 text-center green big">
                                                                <strong>{{round($lists->tracked_hours/60)}}</strong>
                                                            </p>
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
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#month-6" role="tab"
                                                                   data-toggle="tab"><span>Last 6 month</span></a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#year" role="tab"
                                                                   data-toggle="tab"><span>Last year</span></a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="#date" role="tab"
                                                                   data-toggle="tab"><span>Year to date</span></a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane fade in active show"
                                                                 id="month">

                                                                <div id="container-1" class="wrapper-svg"></div>

                                                            </div>
                                                            <div role="tabpanel" class="tab-pane fade" id="month-6">

                                                                <div class="wrapper-svg"></div>

                                                            </div>
                                                            <div role="tabpanel" class="tab-pane fade" id="year">

                                                                <div class="wrapper-svg"></div>

                                                            </div>
                                                            <div role="tabpanel" class="tab-pane fade" id="date">

                                                                <div class="wrapper-svg"></div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="row border-top-0 border-left-0 border-right-0 border-bottom-0">
                                                    <div class="col-12 pb-0">
                                                        <div class="main-text">

                                                            @if(round($lists->tracked_hours/60)!=0)
                                                                <h3 class="h3">Past Records</h3>
                                                                @if(in_array($lists->group_id,$lists->arr5))
                                                                    <p class="light mb-0">Top 5 Groups in the State (number of hours contributed during the last year)</p>
                                                                @endif
                                                                @if(in_array($lists->group_id,$lists->arr))
                                                                    <p class="light">Top 10 Groups in the Country (number of hours contributed during the last year)</p>
                                                                @endif
                                                                @if(in_array($lists->group_id,$lists->month5))
                                                                    <p class="light mb-0">Top 5 Groups in the State (number of hours contributed during the last month)</p>
                                                                @endif
                                                                @if(in_array($lists->group_id,$lists->month))
                                                                    <p class="light">Top 10 Groups in the Country (number of hours contributed during the last month)</p>
                                                                @endif
                                                                @if(in_array($lists->group_id,$lists->volun5))
                                                                    <p class="light mb-0">Top 5 Groups in the State (number of volunteers)</p>
                                                                @endif
                                                                @if(in_array($lists->group_id,$lists->volun))
                                                                    <p class="light mb-0">Top 10 Groups in the Country (number of volunteers)</p>
                                                                @endif
                                                            @endif

                                                        </div>

                                                    </div>
                                                </div>


                                            </div>

                                            <!-- ---->

                                        </div>
                                    </div>


                                </div>

                            </div>

                    @endforeach

                @endif


                <!-- -->
                    <!-- -->
                    <!-- -->
                    <!-- -->

                </div>
            </div>


        </div>
    </div>

@endsection



@section('script')

    <script src="{{asset('front-end/js/bootstrap-sortable.js')}}"></script>
    <script src="{{asset('js/highcharts.js')}}"></script>
    <!--<script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script>-->
    <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script>
        $('.example').dataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "pageLength": 10,
            "pagingType": "full_numbers",
            "language": {
                "paginate": {
                    "first": "",
                    "next": '',
                    "previous": '',
                    "last": ''
                }
            }
        });
        /*$('.example').footable({
            limitNavigation: 5,
            firstText: '1'
        });
        $('ul.pagination').each(function(){
            if (Math.abs((parseInt($(this).find('.footable-page:last a').data('page')) + 1) - parseInt($(this).find('.footable-page-arrow:last a').text())) < 0.01) $(this).find('.footable-page-arrow:last').hide();
            else $(this).find(' .footable-page-arrow:last').show();
        });

        $('.pagination').on('click', 'li a[data-page]', function () { //, .footable-page-arrow
            var pagination = $(this).parents('.tab-pane.active .pagination');
            if (pagination.find('.footable-page:first a').data('page') == 0) pagination.find('.footable-page-arrow:first').hide();
            else pagination.find('.footable-page-arrow:first').show();
            if (Math.abs((parseInt(pagination.find('.footable-page:last a').data('page')) + 1) - parseInt(pagination.find('.footable-page-arrow:last a').text())) < 0.01) pagination.find('.footable-page-arrow:last').hide();
            else pagination.find('.footable-page-arrow:last').show();
        });*/

        Highcharts.chart('month', {
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

                        @if(count($groupList)>0)

                        @foreach($groupList as $key => $lists)

                        @foreach($lists->datewise as $date)

                    ['{{date('d M',strtotime($date->logged_date))}}', {{round($date->SUM/60)}}],

                    @endforeach
                    @endforeach

                    @endif

                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });


        Highcharts.chart('month-6', {
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

                        @if(count($groupList)>0)

                        @foreach($groupList as $key => $lists)
                        @foreach($lists->sixmonthwise as $sixmonth)

                    ['{{date('M',strtotime($sixmonth->logged_date))}}', {{round($sixmonth->SUM/60)}}],

                    @endforeach
                    @endforeach

                    @endif
                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });


        Highcharts.chart('year', {
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

                        @if(count($groupList)>0)

                        @foreach($groupList as $key => $lists)
                        @foreach($lists->lastYearwise as $lastYear)

                    ['{{date('M',strtotime($lastYear->logged_date))}}', {{round($lastYear->SUM/60)}}],

                    @endforeach
                    @endforeach

                    @endif
                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });

        Highcharts.chart('date', {
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

                        @if(count($groupList)>0)

                        @foreach($groupList as $key => $lists)
                        @foreach($lists->Yearwise as $year)

                    ['{{date('Y',strtotime($year->logged_date))}}', {{round($year->SUM/60)}}],

                    @endforeach
                    @endforeach

                    @endif

                ],
                dataLabels: {
                    enabled: false
                }
            }]
        });


    </script>
@endsection

