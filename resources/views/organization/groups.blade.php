@extends('layout.masterForAuthUser')

@section('css')
    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/jquery.bxslider.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap-sortable.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/select2-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('front-end/css/print.css')}}" media="print">

    <style>
        .active_group_page {
            color: #3bb44a !important;
            background: #fff;
            text-decoration: none;
        }

        .tab_item {
            display: none;
        }

        .hide {
            display: none;
        }

    </style>
    @if(Auth::user()->user_role !== 'organization')
        <style>

            #sendFrm ul{
                position: relative;
                text-align: left;
            }

            ul {
                list-style-type: none;
            }

        </style>
    @endif
    <style>
        a {
            text-decoration: none !important;
        }

        .pagination .flex-wrap .justify-content-center {
            margin: 0;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            padding: 0;
        }

        .footable-page-arrow, .footable-page {
            display: list-item;
            text-align: -webkit-match-parent;
        }

        .footable-page-arrow a, .footable-page a {
            position: relative;
            display: block;
            padding: 10px;
            margin: 10px 5px;
            font-size: 16px;
            line-height: 20px;
            font-family: 'Open Sans', sans-serif;
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

        .footable-page-arrow a:hover, .footable-page a:hover {
            z-index: auto;
            color: #fff;
            text-decoration: none;
            background-color: #38b348;
            border: 0 none;
        }

        .footable-page:nth-child(4), .footable-page:nth-last-child(4), .footable-page-arrow a[data-page=prev], .footable-page-arrow a[data-page=next], .footable-page-arrow.disabled {
            display: none;
        }

        .footable-page.active a, .footable-page-arrow.disabled:first-child, .footable-page-arrow.disabled:last-child {
            z-index: auto;
            color: #fff;
            text-decoration: none;
            background-color: #38b348;
            border: 0 none;
            display:block;
        }
    </style>

@endsection

@section('content')
    <div class="wrapper-groups_org">
        <div class="container">

            <div class="row row-padding">
                <div class="col-12 col-md-4">

                    <div class="main-text">
                        <div class="row flex-container">
                            <div class="col">
                                <h2 class="h2">Add Group</h2>
                            </div>
                            <div class="col col-auto">
                                <a href="{{Auth::user()->user_role == 'organization' ? route('organization-group-group_add') : route('volunteer-group-group_add')}}"
                                   class="add_opportunity_plus"><span class="fa fa-plus"></span></a>
                            </div>
                        </div>
                    </div>


                    <hr class="mb-0">

                    <div class="link-box">
                        <ul id="tabs" class="tabs_groups nav nav-tabs" role="tablist">
                            @if(count($groupList)>0)
                                @foreach($groupList as $key => $lists)
                                    <li data-groupTab='{{$key}}' class="groupTab tab_groups nav-item"
                                        id="pane-li-{{$key}}"><a id="tab-{{$key}}"
                                                                 href="#pane-{{$key}}" data-toggle="tab"
                                                                 role="tab"><span
                                                    class="group_name_class">{{ $lists->name }}</span></a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-8 border-left">


                    <div id="content" class="tab-content tab-accordion" role="tablist">


                        @if(count($groupList)>0)
                            @foreach($groupList as $key => $lists)

                                <div data-groupTab='{{$key}}' id="pane-{{$key}}"
                                     class="card tab-pane fade {{$key == 0 ? 'active' : 'show'}}" role="tabpanel"
                                     aria-labelledby="tab-1">
                                    <div class="card-header" role="tab" id="heading-{{$key}}">
                                        <a data-toggle="collapse" href="#collapse-{{$key}}" data-parent="#content"
                                           aria-expanded="{{$key == 0 ? 'true' : 'false'}}"
                                           aria-controls="collapse-{{$key}}"><span>{{ $lists->name }}</span></a>
                                    </div>
                                    <div id="collapse-{{$key}}" class="collapse {{$key == 0 ? 'show' : ''}}"
                                         role="tabpanel" aria-labelledby="heading-{{$key}}">
                                        <div class="card-body">


                                            @if(Session::has('success'))
                                                <div class="alert alert-success">{{Session::get('success')}}</div>
                                            @endif
                                            @if(Session::has('error'))
                                                <div class="alert alert-danger">{{Session::get('error')}}</div>
                                            @endif
                                            <div class="line-button">
                                                <div class="main-text">

                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <h2 class="h2">{{ $lists->name }}</h2>
                                                        </div>

                                                        @if($lists->role_id==1)
                                                            <div class="col col-auto">
                                                                <a href="{{Auth::user()->user_role == 'organization' ? route('organization-group-group_add', [$lists->id]) : route('volunteer-group-group_add', [$lists->id])}}"
                                                                   class="main-link"><span>Edit</span></a>
                                                            </div>
                                                            @if($lists->is_public == 1)
                                                                <div class="col col-auto">
                                                                    <a href="javascript:void(0);"
                                                                       data-id="{{$lists->id}}"
                                                                       class="main-link invi_link"><span>Invitation Link</span></a>
                                                                </div>
                                                            @endif
                                                            <div id="invi_div{{$lists->id}}" class="hide"
                                                                 style="margin-left: 20px; padding-top: 5px; padding-bottom: 5px; width: 90%;">
                                                                {{url('/sharegroup/'.base64_encode($lists->id))}}
                                                            </div>
                                                        @else
                                                            <div class="col col-auto">
                                                                <a onclick="return confirm('Are you sure to leave ?')"
                                                                   class="main-link"
                                                                   @if(Auth::user()->user_role == 'organization')
                                                                   href="{{url('organization/leave_group/'.$lists->id)}}">Leave
                                                                    Group</a>
                                                                @else
                                                                    href="{{url('volunteer/leave_group/'.$lists->id)}}
                                                                    ">Leave Group</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>

                                            <!---- ----->

                                            <div class="banner-text-box  shift-15">
                                                <div class="row no-gutters">
                                                    <div class="col-12 col-md-8"
                                                         @if($lists->banner_image!='')style="background-image: url('{{asset('/uploads/volunteer_group_banner/thumb'). '/' . $lists->banner_image}}')"@endif></div>
                                                    <div class="col-12 col-md-4">

                                                        <div class="main-text">
                                                            <p>IMPACTS</p>
                                                            <p class="bold">{{round($lists->tracked_hours/60)}}</p>
                                                            <p class="light">HOUR(S)</p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!---- ----->
                                            @if($lists->role_id==1)
                                                <div class="wrapper-friends  shift-15">
                                                    <div class="search-friends">
                                                        <div class="container">


                                                            <div class="search send_invitation clearfix"
                                                                 data-id="{{$lists->id}}">
                                                                <input type="text" name="invite_name"
                                                                       class="invite_name"
                                                                       placeholder="Type name to invite">
                                                                <a href="#"
                                                                   class="send_invitation send_invitation_user send"><span>Send invitation</span></a>
                                                            </div>
                                                            <span class="input-group-btn" style="display: none">
                                                    <input type="button" value="Send Invitation"
                                                           class="btn btn-primary send">
                                             </span>

                                                        </div>
                                                    </div>
                                                </div>
                                        @endif

                                        <!---- ---->
                                            <div class="wrapper-tablist  shift-15">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active show" href="#members{{$key}}"
                                                           role="tab"
                                                           data-toggle="tab"
                                                           aria-selected="false"><span>Members</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#impact{{$key}}" role="tab"
                                                           data-toggle="tab"
                                                           aria-selected="false"><span>Impact</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!---- ---->

                                            <div class="tab-content">
                                                @if(count($lists->members)>0)
                                                    <div role="tabpanel" class="tab-pane fade in active show"
                                                         id="members{{$key}}">

                                                        <div class="wrapper-friends  shift-15">
                                                            <div class="search-friends">
                                                                <div class="container">


                                                                    <div class="search send_invitation clearfix">
                                                                        <input class="search-mem"
                                                                               id="search-member-group-input{{$key}}"
                                                                               type="text"
                                                                               data-id="{{$lists->id}}"
                                                                               placeholder="Search Members">
                                                                        <a href="#" data-key-id="{{$key}}"
                                                                           class="send_invitation search-member-group"><span>Search</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="main-text">

                                                            <div class="wrapper-sort-table wrapper-table-org">
                                                                <div>

                                                                    <table class="table sortable example3">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>
                                                                                <div class="main-text"><p>Name</p></div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="main-text"><p>Location</p>
                                                                                </div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="main-text"><p>Impact</p>
                                                                                </div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="main-text"><p>Rating</p>
                                                                                </div>
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="members-list-main{{$key}}">

                                                                        @foreach($lists->members as $members)
                                                                            <tr>
                                                                                <td>{{($members->user_role == 'organization') ? $members->org_name : $members->first_name.' '.$members->last_name}}</td>
                                                                                <td>{{implode(', ', array_filter([$members->city, $members->state]))}}</td>
                                                                                <td>
                                                                                    <p class="green">{{$members->impact/60}}
                                                                                        hour(s)</p></td>
                                                                                <td>{{empty($members->mark) ? 0 : $members->mark}}</td>
                                                                            </tr>
                                                                        @endforeach

                                                                        </tbody>
                                                                        <tbody style="display: none"
                                                                               id="members-list-search{{$key}}">

                                                                        </tbody>
                                                                    </table>

                                                                </div>


                                                            </div>
                                                            <div class="wrapper-pagination">

                                                                <ul class="pagination flex-wrap justify-content-center">

                                                                </ul>

                                                            </div>


                                                        </div>


                                                    </div>
                                                @endif

                                                <div role="tabpanel" class="tab-pane fade" id="impact{{$key}}">

                                                    <!------- -->

                                                    <div class="wrapper-impact pb-0 pt-0">


                                                        <div class="row align-items-center border-top-0 border-left-0 border-right-0">
                                                            <div class="col"></div>
                                                            <div class="col col-auto">

                                                                <a href="#" href="javascript:void(0)"
                                                                   onclick="window.print()"
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
                                                                            nd @elseif($lists->rank==3)
                                                                            rd @else th @endif
                                                                    </p>
                                                                    <p class="light text-center">
                                                                        in {{$lists->creatorDetails->country}}</p>

                                                                    <hr>

                                                                    <p class="mb-0 text-center green big">
                                                                        <strong>{{round($lists->tracked_hours/60)}}</strong>
                                                                    </p>
                                                                    <p class="mb-0 text-center green middle">HOUR(S)</p>
                                                                    <p class="light text-center">contributed since
                                                                        creation</p>
                                                                </div>

                                                            </div>
                                                            <div class="col-12 col-md-8 border-left">

                                                                <ul class="nav nav-tabs" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active show"
                                                                           href="#month{{$key}}"
                                                                           role="tab"
                                                                           data-toggle="tab"><span>Last Month</span></a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#month-6{{$key}}"
                                                                           role="tab"
                                                                           data-toggle="tab"><span>Last 6 month</span></a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#year{{$key}}"
                                                                           role="tab"
                                                                           data-toggle="tab"><span>Last year</span></a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" href="#date{{$key}}"
                                                                           role="tab"
                                                                           data-toggle="tab"><span>Year to date</span></a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content">
                                                                    <div role="tabpanel"
                                                                         class="tab-pane fade in active show"
                                                                         id="month{{$key}}">

                                                                        <div id="container-1" class="wrapper-svg"></div>

                                                                    </div>
                                                                    <div role="tabpanel" class="tab-pane fade"
                                                                         id="month-6{{$key}}">

                                                                        <div class="wrapper-svg"></div>

                                                                    </div>
                                                                    <div role="tabpanel" class="tab-pane fade"
                                                                         id="year{{$key}}">

                                                                        <div class="wrapper-svg"></div>

                                                                    </div>
                                                                    <div role="tabpanel" class="tab-pane fade"
                                                                         id="date{{$key}}">

                                                                        <div class="wrapper-svg"></div>

                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                        <div class="row border-top-0 border-left-0 border-right-0 border-bottom-0">
                                                            <div class="col-12 pb-0">
                                                                <div class="main-text">


                                                                    @if(round($lists->tracked_hours/60) != 0)
                                                                        <h3 class="h3">Past Records</h3>


                                                                        @if(in_array($lists->group_id,$lists->arr5))
                                                                            <p class="light mb-0">Top 5 Groups in the
                                                                                State (number
                                                                                of hours contributed during the last
                                                                                year)</p>
                                                                        @endif
                                                                        @if(in_array($lists->group_id,$lists->arr))
                                                                            <p class="light mb-0">Top 10 Groups in the
                                                                                Country
                                                                                (number of hours contributed during the
                                                                                last
                                                                                year)</p>
                                                                        @endif
                                                                        @if(in_array($lists->group_id,$lists->month5))
                                                                            <p class="light mb-0">Top 5 Groups in the
                                                                                State (number
                                                                                of hours contributed during the last
                                                                                month)</p>
                                                                        @endif
                                                                        @if(in_array($lists->group_id,$lists->month))
                                                                            <p class="light mb-0">Top 10 Groups in the
                                                                                Country
                                                                                (number of hours contributed during the
                                                                                last
                                                                                ymonth)</p>
                                                                        @endif
                                                                        @if(in_array($lists->group_id,$lists->volun5))
                                                                            <p class="light mb-0">Top 5 Groups in the
                                                                                State (number
                                                                                of volunteers)</p>
                                                                        @endif
                                                                        @if(in_array($lists->group_id,$lists->volun))
                                                                            <p class="light mb-0">Top 10 Groups in the
                                                                                Country
                                                                                (number of volunteers)</p>
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
                                </div>

                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>


        </div>
        @endsection

        @section('script')



            <script src="{{asset('front-end/js/highcharts.js')}}"></script>
            {{--<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>--}}
            <script src="{{asset('front-end/js/bootstrap-sortable.js')}}"></script>
            <script src="{{asset('js/plugins/footable/footable.all.min.js')}}"></script>
            <script src="//cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
            <script src="//cdn.datatables.net/plug-ins/1.10.19/pagination/ellipses.js"></script>

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

                    // $(document).on('click', '.navtoggler', function () {
                    //     $('body').toggleClass("offcanvas-menu-show");
                    // });
                    // $(document).on('click', '.offcanvas-contentarea', function () {
                    //     $('body').removeClass("offcanvas-menu-show");
                    // });

                    // $(document).on('click', '.offcanvas-contentarea', function () {
                    //     $('body').removeClass('offcanvas-menu-show');
                    // });


                    $('#tab-0').click();

                    // $(document).on('click', '.card', function () {
                    //     var id = $(this).data('grouptab')
                    //     // $('.groupTab').removeClass();
                    //     var string = '#pane-li-' + id
                    //     $(string).click();
                    //     console.log(id)
                    // })
                    //
                    // $(document).on('click', '.groupTab', function () {
                    //     var id = $(this).data('grouptab')
                    //     $('.card').removeClass('active');
                    //     var string = '#pane-li-' + id
                    //     $('#pane-' + string).click();
                    //     console.log(id)
                    // })




                });

                $('.tab_item:eq(' + 0 + ')').show();
                // console.log($('.tab_groups:eq(' + 0 + ')').children('a').children('span').addClass('active_group_page'))
                $('.tab_groups:eq(' + 0 + ')').children('a').children('span').css('color', '#3bb44a');


                $(document).ready(function () {
                    /*$('.example3').footable({
                        "paging": {
                            "limit": 3
                        }
                        //limitNavigation: 5,
                        //firstText: '1'
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
                    $('.example3').dataTable({
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

                    $("#DataTables_Table_0_wrapper").addClass('wrapper-pagination')

                    $('body').on('click', '.send', function (e) {
                        e.preventDefault();
                        if ($("input[type='checkbox']:checked").length > 0) {
                            $('#sendFrm').submit();
                        }
                    })

                    $('.tab_groups').on('click', function (e) {
                        e.preventDefault();
                        var form = $('#sendFrm');
                        if (form != undefined & form != null) {
                            $('#sendFrm').remove();
                            $('.invite_name').val('');
                        }
                    })

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });

                    $(".tab_groups").click(function (e) {
                        e.preventDefault()
                        $('.group_name_class').css('color', '#28292e');
                        $(".tab_groups").eq($(this).index()).addClass("active_group_page");
                        $(".tab_item").hide().eq($(this).index()).hide()

                        $('.tab_item:eq(' + $(this).index() + ')').show();
                        $(this).children('a').children('span').css('color', '#3bb44a');

                    }).eq(0).addClass("active_group_page");


                    $('.invite_name').keyup(function () {
                        if ($(this).val().length > 2) {//alert($(this).val().length);
                            var this1 = $(this);
                            $.ajax({
                                url: "{{ Auth::user()->user_role == 'organization' ? route('api-organization-group-get-user') : route('api-volunteer-group-get-user') }}",
                                data: 'keyword=' + $(this).val() + '&groupId=' + $(this).parent().data('id'),
                                type: 'POST',
                                success: function (res) {
                                    this1.parent().next().html(res);
                                    this1.parent().parent().next().show()
                                    var container = this1.parent().parent()[0];
                                    $(container).children('span').show()
                                }
                            })
                        }
                        else {
                            $(this).parent().next().html('');
                        }
                    })

                    $(".search-member-group").click(function (e) {
                        e.preventDefault();
                        var key = $(this).data('key-id');
                        var input = $(this).siblings()[0];
                        $('.search-members-tr').remove()
                        if ($(input).val() !== "") {

                            var this1 = $(this);
                            $.ajax({
                                url: "{{Auth::user()->user_role == 'organization' ?  route('get_user_by_group') : route('volunteer-get-user-by-group') }}",
                                data: 'keyword=' + $('#search-member-group-input' + key).val() + '&groupId=' + $('#search-member-group-input' + key).data('id'),
                                type: 'POST',
                                success: function (res) {
                                    $('#members-list-main' + key).hide();
                                    $('#members-list-search' + key).show();

                                    $('#members-list-search' + key).append(res)
                                }
                            })
                        }
                        else {
                            $('#members-list-search' + key).hide();
                            $('#members-list-main' + key).show();
                        }


                    });


                    @foreach($groupList as $key => $lists)

                    Highcharts.chart('month{{$key}}', {
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
                            formatter: function () {
                                return '<b>' + this.y + '</b>';
                            }
                        },
                        series: [{
                            name: 'Population',
                            color: '#03a9f4',
                            data: [

                                    @forelse($lists->datewise as $date)

                                ['{{date('d M',strtotime($date->logged_date))}}', {{round($date->SUM/60)}}],
                                    @empty
                                [],
                                @endforelse

                            ],
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    });


                    Highcharts.chart('month-6{{$key}}', {
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
                            formatter: function () {
                                return '<b>' + this.y + '</b>';
                            }
                        },
                        series: [{
                            name: 'Population',
                            color: '#03a9f4',
                            data: [

                                    @forelse($lists->sixmonthwise as $date)

                                ['{{date('d M',strtotime($date->logged_date))}}', {{round($date->SUM/60)}}],
                                    @empty
                                [],
                                @endforelse

                            ],
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    });


                    Highcharts.chart('year{{$key}}', {
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
                            formatter: function () {
                                return '<b>' + this.y + '</b>';
                            }
                        },
                        series: [{
                            name: 'Population',
                            color: '#03a9f4',
                            data: [

                                    @forelse($lists->lastYearwise as $date)

                                ['{{date('d M',strtotime($date->logged_date))}}', {{round($date->SUM/60)}}],
                                    @empty
                                [],
                                @endforelse


                            ],
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    });

                    Highcharts.chart('date{{$key}}', {
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
                            formatter: function () {
                                return '<b>' + this.y + '</b>';
                            }
                        },
                        series: [{
                            name: 'Population',
                            color: '#03a9f4',
                            data: [

                                    @forelse($lists->Yearwise as $date)

                                ['{{date('d M',strtotime($date->logged_date))}}', {{round($date->SUM/60)}} ],
                                    @empty
                                [],
                                @endforelse

                            ],
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    });

                    @endforeach

                });

                $('.invi_link').click(function () {
                    var dis = $(this).data('id');
                    if ($('#invi_div' + dis).hasClass('hide')) {
                        $('#invi_div' + dis).removeClass('hide');
                    } else {
                        $('#invi_div' + dis).addClass('hide')
                    }
                    console.log($(this).data('id'))
                });

            </script>

@endsection
