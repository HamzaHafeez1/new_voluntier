@extends('layout.masterForAuthUser')
@section('css')
    <link href="<?=asset('css/plugins/fullcalendar/fullcalendar.css')?>" rel="stylesheet">
    <link href="<?=asset('css/plugins/fullcalendar/fullcalendar.print.css')?>" rel='stylesheet' media='print'>


    <style>
        @media screen and (max-width: 375px) {
            #calendar .fc-toolbar > div {
                display: table;
                margin: 5px auto;
                float: none;
            }

            #calendar .fc-toolbar {
                position: relative;
                padding-bottom: 80px;
            }

            .fc-toolbar .fc-right, .fc-toolbar .fc-center {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
            }

            .fc-toolbar .fc-right {

                top: 80px;
            }

            .fc-toolbar .fc-center {
                top: 40px;
            }
        }

       @media screen and (max-width: 1024px){
            .modal-share-px {
                width: calc(100% - 270px) !important;
            }
        }

        .modal {
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }

        .modal-open .modal {
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }

        #calendar{
            overflow: auto;
        }

        .wrapper-calendar{
            overflow: auto;
        }
        .p_invalid {
            display: none;
            font-size: 15px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 3px;
            color: red !important;
            margin-left: 20%;
        }

         .fc-time-grid-event .fc-time, .fc-time-grid-event .fc-title, .fc-end-resizer {
             color: #fff !important;
         }

        /*.wrapper-sort-table .table tr td:first-child {*/
            /*white-space: normal !important;*/
            /*word-wrap: break-word !important;*/
            /*max-width: 550px;*/

        /*}*/


        @media screen and (max-width: 524px){
            .wrapper-sort-table .table tr td:first-child{
                width: 100%;
                white-space: nowrap !important;
                word-wrap: normal !important;
                max-width: 100%;
            }
        }


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

        .fc-unthemed .fc-today {
            background: #c9fff4 !important;
        }
    </style>
@endsection
@section('content')
    @if(if_route_pattern('volunteer-track'))
        <div class="wrapper-track">
            <div class="wrapper-tablist">

                <div class="container">

                    <ul class="nav nav-tabs" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active show" href="#hours" role="tab"
                               data-toggle="tab"><span>Add Hours</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#activities" role="tab"
                               data-toggle="tab"><span>My Activities</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#approvals" role="tab"
                               data-toggle="tab"><span>Pending Approvals</span></a>
                        </li>

                    </ul>

                </div>

            </div>
        </div>
    @endif

    <div class="wrapper-friends">

        {{--<div class="search-friends">--}}
        {{--<div class="container">--}}


        {{--<div class="search">--}}
        {{--<label><span class="gl-icon-search"></span></label>--}}
        {{--<input id="filter" type="text" placeholder="Search">--}}
        {{--</div>--}}

        {{--</div>--}}
        {{--</div>--}}

        <div class="wrapper-friends-list wrapper-track pt-0">
            <div class="container">


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="hours">


                        <div class="row row-padding">
                            <div class="col-12 col-md-4">


                                <div class="main-text">

                                    <div class="row flex-container">
                                        <div class="col">
                                            <h2 class="h2">Opportunities</h2>
                                        </div>
                                        <div class="col col-auto">
                                            <a href="#" class="add_opportunity_plus"><span  class="fa fa-plus"></span></a>
                                        </div>
                                    </div>


                                </div>

                                <hr>

                                <div class="link-box">
                                    <ul id='external-events'>

                                        @foreach($oppr as $op)
                                            @if($op->type == 1)
                                                <li class='external-event navy-bg' value="{{$op->id}}"><a
                                                            href="#"><span>{{$op->title}}</span></a></li>

                                            @else
                                                <li class='external-event private-bg'  value="{{$op->id}}"><a style="background: #ff7a39"
                                                            href="#"><span>{{$op->title}}</span></a></li>
                                            @endif
                                        @endforeach

                                    </ul>
                                </div>

                                <div class="help-box">
                                    <div class="main-text">
                                        <h3 class="h3">How to Add Hours?</h3>

                                        <p>It's easy!</p>

                                        <p>1. Click on the calendar for the pop up box</p>
                                        <p>2. Select the opportunity</p>
                                        <p>3. Input time range</p>
                                    </div>
                                </div>


                            </div>
                            <div class="col-12 col-md-8 border-left">

                                <div class="work-calendar-box">

                                    <div class="main-text">
                                        <h2 class="h2">My Work Calendar</h2>
                                    </div>

                                    <hr>

                                    <div class="main-text">

                                        <div class="wrapper-calendar">
                                            <div id="calendar"></div>
                                        </div>

                                        <input type="hidden" id="selected_date">
                                        <input type="hidden" id="is_edit" value="0">
                                        <input type="hidden" id="track_id" value="0">
                                        <input type="hidden" id="is_from_addhour" value="0">
                                        <input type="hidden" id="is_no_org" value="0">
                                        <input type="hidden" id="is_link_exist" value="0">

                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>


                    <div role="tabpanel" class="tab-pane fade" id="activities">

                        <!-- -->
                        <!-- -->
                        <!-- -->

                        <div class="wrapper-track">
                            <div class="wrapper-tablist pt-0">

                                <div class="row justify-content-end">
                                    <div class="col-12 col-md-4">
                                        <div class="wrapper_select">
                                            <select class="custom-dropdown" id="action_range">
                                                <option value="30">Last Month</option>
                                                <option value="7" selected>Last Week</option>
                                                <option value="1">Yesterday</option>
                                                <option value="0">Today</option>
                                            </select>
                                            {{--<table class="table_activity table table-stripped" data-page-size="10" data-filter=#filter>--}}
                                            {{--<tbody class="track-activity-panel">--}}
                                            {{--</tbody>--}}
                                            {{--</table>--}}
                                            {{--<div id="active_pager">--}}
                                            {{--<ul id="activity_pagination" class="pagination pull-right"></ul>--}}
                                            {{--</div>--}}
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="wrapper-sort-table">
                            <div class="conteiner-activity-table">

                                {{--@include('volunteer.trackActivitiesList', ['activity' => $activity])--}}

                            </div>
                        </div>


                        <!-- -->
                        <!-- -->
                        <!-- -->

                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="approvals">


                        <!-- -->
                        <!-- -->
                        <!-- -->


                        <div class="wrapper-friends-list wrapper-track pt-0">
                            <div class="search-friends">
                                <div class="container">


                                    <div class="search">
                                        <label><span class="gl-icon-search"></span></label>
                                        <input id="filter" type="text" placeholder="Search">
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="wrapper-sort-table">
                            <div>

                                @if(if_route_pattern('volunteer-track'))
                                    @include('components.trackProfile.pendingApprovalsActivity', ['tracks' => $tracks])
                                @endif
                                <div id="peending_pager">
                                    {{--<ul id="pendding_pagination" class="pagination pull-right"></ul>--}}
                                </div>

                            </div>
                        </div>

                        <!-- -->
                        <!-- -->
                        <!-- -->

                    </div>
                </div>


            </div>
        </div>
    </div>

    </div>
    @include('components.auth.modal_pop_up_add_opportunities')
    @include('components.auth.modal_pop_up_add_hours_vol')
    @include('components.auth.modal_pop_up_unavailable')
@endsection


@section('script')
    <script src="<?=asset('js/plugins/dataTables/jquery.dataTables.js')?>"></script>
    <script src="{{asset('front-end/js/moment.min.js')}}"></script>
    <script src="<?=asset('js/plugins/fullcalendar/moment.min.js')?>"></script>
    <script src="<?=asset('js/plugins/fullcalendar/fullcalendar.min.js')?>"></script>

    <script src="<?=asset('js/plugins/datapicker/bootstrap-datepicker.js')?>"></script>
    <script src="<?=asset('front-end/js/bootstrap-datepicker.js')?>"></script>

    <script src="<?=asset('js/jquery-ui.custom.min.js')?>"></script>
    <script src="<?=asset('js/plugins/select2/select2.full.min.js')?>"></script>
    <!--<script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script>-->
    <script src="<?=asset('js/plugins/dataTables/jquery.dataTables.js')?>"></script>
    <!--script src="<?=asset('js/plugins/paginate/paginate.js')?>"></script>
    <script src="<?=asset('js/plugins/paginate/jquery-asPaginator.js')?>"></script>
    <script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script-->


    <script>
        function activityChange() {
            var range = $('#action_range').val();
            var url = API_URL + 'volunteer/track/activityView';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var type = "get";
            var formData = {
                range: range,
            };

            $.ajax({
                url: url,
                type: type,
                data: formData,
                success: function (data) {
                    $('#activity_table_del').remove()
                    $('.pag').remove()
                    $('.conteiner-activity-table').append(data)

                }
            });
        }
    </script>

    <script src="{{asset('js/tracking-action.js')}}"></script>


    <script>

        $(document).ready(function () {
            var display = $('.footable-page-arrow:nth-last-child(3)').css('display')

            if(display == 'none'){
                $('.footable-page-arrow:last-child').css('display', 'none')
            }
            else{
                $('.footable-page-arrow:last-child').css('display', 'block')
            }

            if(parseInt($('.footable-page:last a').data('page')) + 1 == $('.footable-page-arrow:last').text()) $('.footable-page-arrow:last').hide();
            else $('.footable-page-arrow:last').show();
            $(document).on('click', '.footable-page, .footable-page-arrow', function () {

                var display = $('.footable-page-arrow:nth-child(3)').css('display')

                if(display == 'none'){
                    $('.footable-page-arrow:first-child').css('display', 'none')
                }
                else{
                    $('.footable-page-arrow:first-child').css('display', 'block')
                }

                if(parseInt($('.footable-page:last a').data('page')) + 1 == $('.footable-page-arrow:last').text()) $('.footable-page-arrow:last').hide();
                else $('.footable-page-arrow:last').show();
            });

            $('.modal').css({'position': 'fixed', 'overflow': 'hidden'})
            activityChange()

            function activityChange() {
                var range = $('#action_range').val();
                var url = API_URL + 'volunteer/track/activityView';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                console.log();
                var type = "get";
                var formData = {
                    range: range,
                };

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $('#activity_table_del').remove()
                        $('.pag').remove()
                        $('.conteiner-activity-table').append(data)

                    }
                });

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
            }


            $('body').on('click', '.pag > .pagination > .page-item > .page-link', function (e) {
                e.preventDefault()
                if (!($(this).parent().hasClass('active'))) {
                    console.log()
                    var range = $('#action_range').val();
                    var url = $(this).attr('href');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    console.log();
                    var type = "get";
                    var formData = {
                        range: range,
                    };

                    $.ajax({
                        url: url,
                        type: type,
                        data: formData,
                        success: function (data) {
                            $('#activity_table_del').remove()
                            $('.pag').remove()
                            $('.conteiner-activity-table').append(data)

                        }
                    });
                }

            })

            $('#action_range').change(function () {

                activityChange()

            })

            /*$('.footable').footable({
                limitNavigation: 5,
                firstText: '1'
            });*/
            $('#add_on_addtime').on('click',function () {
                $('#is_from_addhour').val(1);
                $(".select_organization").select2('val', '');
                $('#org_emails').val('');
                $('.org_email_div').hide();
                $('.opp_div').hide();
                $('.opp_private_div').hide();
                $('#opp_date_div').hide();
                $('#org_not_exist').attr('checked', false);
                $('#opp_not_exist').attr('checked', false);
                $('#org_name').attr('disabled', false);
                $('#opp_name').attr('disabled', false);
                $('#private_opp_name').val('');
                $('#end_date').val('');
            });

            $('.add_opportunity_dlg').on('click', function () {
                console.log(1)

                $('#is_from_addhour').val(0);
                $('#is_no_org').val(0);
                $(".select_organization").select2('val', '');
                $('#org_emails').val('');
                $('.private_opp_div').hide();
                $('.org_email_div').hide();
                $('.opp_div').hide();
                $('.opp_private_div').hide();
                $('#opp_date_div').hide();
                $('#org_not_exist').attr('checked', false);
                $('#opp_not_exist').attr('checked', false);
                $('#org_name').attr('disabled', false);
                $('#opp_name').attr('disabled', false);
            });


            $(".add_opportunity_plus").click(function () {
                $('select').select2("enable");
                $('#org_name').prop('selectedIndex', 0);
                $('#select2-org_name-container').text('Select an Organization')
                $('#opportunity_exist_alert').hide()
                $('#private_org_name').val('')
                $('#opp_date_div').hide()
                // $('#checkbox_div').show()
                $('.org_does_exist').show()
                $('#private_opp_name').val('')
                $('#org_not_exist').click()
                $('#wrapper_div').hide()
                $('#is_from_addhour').val(0);
                $('#is_no_org').val(0);
                $('.org_not_exist').show()
                $('.org_private_div').hide()
                $('.opp_private_div').hide()
                $('.opp_div').hide()
                $('#org_emails').val('')
                $('#end_date').val('')
                $('#checkbox_div').prop('checked', false);
                $('#opp_not_exist').prop('checked', false);

                $('#add_opportunity').modal('show');
            });


            // $('#calendar').click(function() {
            //
            // });
            //

            function doSubmit(track_id) {
                $("#add_hours").modal('hide');
                var selected_val = $('#selected_date').val();
                var date_val = selected_val.slice(0, 11);
                var ext_val = selected_val.slice(16);

                var start_time = $('#start_time').val();
                var end_time = $('#end_time').val();
                var start_val = date_val.concat(start_time, ext_val);
                var end_val = date_val.concat(end_time, ext_val);
                var comments = $('#adding_hours_comments').val();

                var is_no_org = $('#is_no_org').val();
                var title = $('#opp_id option:selected').text();
                if (is_no_org == 1) {
                    title = $('#private_opp_name_hours').val();
                }
                if ($('#is_edit').val() == 1) {
                    $('#calendar').fullCalendar('removeEvents', track_id);
                    $("#calendar").fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start_val,
                            end: end_val,
                            opp_id: $('#opp_id').val(),
                            id: track_id,
                            comments: comments,
                        },
                        true);
                } else {
                    $("#calendar").fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start_val,
                            end: end_val,
                            opp_id: $('#opp_id').val(),
                            id: track_id,
                            comments: comments,
                        },
                        true);
                }
            }

            $('#btn_add_hours').on('click', function (e) {
                e.preventDefault();

                var selected_date = $('#selected_date').val();
                selected_date = selected_date.slice(0, 10);
                var opp_id = $('#opp_id').val();
                var opp_name = $('#opp_id option:selected').text();
                var logged_mins = $('#hours_mins').text();
                logged_mins = (logged_mins.slice(1)).slice(0, -5);
                var start_time = $('#start_time').val();
                var end_time = $('#end_time').val();
                var adding_hours_comments = $('#adding_hours_comments').val();
                // var adding_hours_comments = $('#comments1').val();
                var tracking_id = $('#track_id').val();
                var is_edited = $('#is_edit').val();
                var is_no_org = $('#is_no_org').val();
                if (is_no_org == 1) {
                    opp_id = 'private';
                }
                var private_opp_name = $('#private_opp_name_hours').val();
                var org_email = $('#org_emails').val();
                if (opp_id != 'Select an opportunity') {
                    $('#btn_add_hours').prop('disabled', true);
                    var url = API_URL + 'volunteer/track/addHours';
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var type = "post";
                    var formData = {
                        opp_id: opp_id,
                        opp_name: opp_name,
                        start_time: start_time,
                        end_time: end_time,
                        logged_mins: logged_mins,
                        selected_date: selected_date,
                        comments: adding_hours_comments,
                        is_edit: is_edited,
                        tracking_id: tracking_id,
                        is_no_org: is_no_org,
                        private_opp_name: private_opp_name,
                        org_email: org_email,
                    };

                    $.ajax({
                        type: type,
                        url: url,
                        data: formData,
                        success: function (data) {
                            location.reload()
                            if (data.result == 'approved track') {
                                $('.confirmed_track').show();
                            } else if (data.result == 'declined track') {

                            } else {
                                if (data.opp_logo == null) {
                                    var logo = SITE_URL + 'front-end/img/org/001.png';
                                } else {
                                    var logo = SITE_URL + 'uploads/' + data.opp_logo;
                                }
                                var currentdate = new Date();
                                var current_time = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + ' ' + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
                                var current_date = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getDate();
                                var url = SITE_URL + 'volunteer/view_opportunity/' + opp_id;
                                if (data.is_link_exist == 1) {
                                    var link = '<a href="' + url + '"><strong>' + opp_name + '</strong></a>';
                                } else {
                                    if (is_no_org == 0) {
                                        var link = '<strong>' + opp_name + '</strong>';
                                    } else {
                                        var link = '<strong>' + private_opp_name + '</strong>';
                                    }
                                }
                                if (is_edited == 0) {

                                    $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="' + logo + '"> <i class="fa fa-reply"></i>You Added ' + logged_mins + 'mins on Opportunity ' + link + '</td><td>' + current_time + '</td></tr>'));

                                    $('.table_pending_view').prepend($('<tr class="pending-approval" id="pending' + tracking_id + '"><td style="text-align: left; padding-left: 20px"><img alt="image" class="img-circle" src="' + logo + '"> ' + link + '</td><td>' + selected_date + '</td><td>' + start_time + '</td><td>' + end_time + '</td><td>' + logged_mins + '</td><td>' + current_date + '</td><td class="label label-warning" style="display: table-cell; font-size:13px;">Pending</td></tr>'));
                                } else {

                                    $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="' + logo + '"> <i class="fa fa-reply"></i>You Updated Logged Hours to ' + logged_mins + 'mins on Opportunity ' + link + '</td><td>' + current_time + '</td></tr>'));
                                    $('#' + 'pending' + tracking_id).remove();
                                    $('.table_pending_view').prepend($('<tr class="pending-approval" id="pending' + tracking_id + '"><td style="text-align: left; padding-left: 20px"><img alt="image" class="img-circle" src="' + logo + '"> ' + link + '</td><td>' + selected_date + '</td><td>' + start_time + '</td><td>' + end_time + '</td><td>' + logged_mins + '</td><td>' + current_date + '</td><td class="label label-warning" style="display: table-cell; font-size:13px;">Pending</td></tr>'));
                                }

                                doSubmit(data.track_id);
                            }
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    $('#empty_opportunity_alert').show();
                }
            });


            var $outerwidth = $('.row-header header .outer-width-box');
            var $innerwidth = $('.row-header header .inner-width-box');

            // $('#action_range').change(function () {
            //     active_pagination();
            // });

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

            <!-- -->
            $("select").select2({
                theme: "bootstrap",
                minimumResultsForSearch: 1,
            });

            $('.wrapper_input.fa-icons input').datepicker({
                'format': 'mm/dd/yyyy',
                'autoclose': true,
                'orientation': 'right',
                'todayHighlight': true
            });

            $("#checkbox_div").click(function () {
                console.log($(this).is(":checked"))
                if ($(this).is(":checked")) {
                    $('.org_email_div').show()
                    $('#wrapper_div').show()
                    $('.org_private_div').show()
                    $('select').select2("enable", false);
                    $('#opp_date_div').show()
                } else {
                    $('#opp_date_div').hide()
                    $('#wrapper_div').css("display", "none");
                    $('select').select2("enable");
                }
            });

            $('body').on('click', '#add_on_addtime', function () {
                $('#add_hours').modal('hide');
                setTimeout(function () {
                    $('.add_opportunity_plus').click()
                }, 200);
            });

            $('body').on('click', '.close_button', function () {
                $('.close').click();
            });
        });
        $('#start_time').on('change', function () {

            var current_time = $(this).val();
            var t = current_time.slice(0, 2);

            t = parseInt(t);
            t = t + 1;
            if (t < 10) {
                var forward_time = ("0" + t + current_time.slice(2));
            } else {
                var forward_time = (t + current_time.slice(2));
            }
            if ($('#end_time').val() < current_time) {
                $('#end_time option').filter(function () {
                    return ($(this).val() == forward_time); //To select Blue
                }).prop('selected', true);
            } else {
                forward_time = $('#end_time').val();
            }
            var h = parseInt(forward_time.slice(0, 2)) - parseInt(current_time.slice(0, 2));
            var m = parseInt(forward_time.slice(3)) - parseInt(current_time.slice(3));
            if (m < 0) {
                h = h - 1;
                m = 30;
            }
            var mins = h * 60 + m;
            // $('#hours').text("("+h+"hrs "+m+"mins)");
            $('#hours_mins').text("(" + mins + "mins)");
        });

        $('#end_time').on('change', function () {

            var end_time = $(this).val();
            var start_time = $('#start_time').val();
            var t = start_time.slice(0, 2);
            t = parseInt(t);
            t = t + 1;
            if (t < 10) {
                var forward_time = ("0" + t + start_time.slice(2));
            } else {
                var forward_time = (t + start_time.slice(2));
            }
            if (end_time < start_time) {
                $('#end_time option').filter(function () {
                    return ($(this).val() == forward_time); //To select Blue
                }).prop('selected', true);
            } else {
                forward_time = end_time;
            }
            var h = parseInt(forward_time.slice(0, 2)) - parseInt(start_time.slice(0, 2));
            var m = parseInt(forward_time.slice(3)) - parseInt(start_time.slice(3));
            if (m < 0) {
                h = h - 1;
                m = 30;

            }
            var mins = h * 60 + m;
            // $('#hours').text("("+h+"hrs "+m+"mins)");
            $('#hours_mins').text("(" + mins + "mins)");
        });


    </script>
    <script>
        $(document).on('click', '.fc-more', function () {
            var top = $('.fc-more-popover').css("top");
            var number = top.substring(0,3)
            var px = number + 'px';
            console.log(top)
            console.log(top.substring(0,3))
            $('.fc-more-popover').css("top", px);
        });

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        document.addEventListener('DOMContentLoaded', function () {


            var calendarEl = document.getElementById('calendar');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: 'GET',
                url: '{{route('volunteer-track-view-tracks')}}',
                success: function (data) {

                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },

                        defaultView: 'agendaWeek',
                        height: 700,
                        defaultDate: date,
                        navLinks: true, // can click day/week names to navigate views
                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        events: data,

                        eventClick: function (calEvent, jsEvent, view) {
                            $('#btn_remove_hours').show()
                            $('#opp_id').prop('disabled', false);
                            $('.opp_select_div').show()
                            $('.private_opp_div_add_hours').hide()
                            // alert('Event: ' + calEvent.title);
                            $('#is_edit').val(1);
                            $('#track_id').val(calEvent.id);
                            $('#btn_remove_hours').show();
                            $('#is_no_org').val(0);
                            $('#adding_hours_comments').val(calEvent.comments);
                            $('.private_opp_div').hide();
                            $('.opp_select_div').show();
                            $('.confirmed_track').hide();
                            $('.add_hours_modal_title').text("Do you want make Change?");
                            if (calEvent.opp_id == 0) {
                                $('.opp_select_div').hide();
                                $('.private_opp_div').show();
                                $('#private_opp_name_hours').val(calEvent.title);
                                $('#is_no_org').val(1);
                                $('.private_opp_div_add_hours').show();
                            }
                            if (calEvent.link == 1) {
                                $('#is_link_exist').val(1);
                            } else {
                                $('#is_link_exist').val(0);
                            }
                            var startDate = calEvent.start.format("YYYY-MM-DD HH:mm");
                            $('#selected_date').val(startDate.slice(0, 11));
                            if (calEvent.end == null) {
                                var new_date = startDate.slice(0, 11);
                                var new_hour = startDate.slice(11, 13);
                                var new_mins = startDate.slice(13);
                                new_hour = parseInt(new_hour) + 2;
                                if (new_hour < 10)
                                    new_hour = '0' + new_hour;

                                var endDate = new_date + new_hour + new_mins;
                            } else {
                                var endDate = calEvent.end.format("YYYY-MM-DD HH:mm");
                            }
                            var cur_start_val = startDate.slice(11, 16);
                            $('#start_time option').filter(function () {
                                return ($(this).val() == cur_start_val);
                            }).prop('selected', true);
                            var cur_end_val = endDate.slice(11, 16);
                            $('#end_time option').filter(function () {
                                return ($(this).val() == cur_end_val);
                            }).prop('selected', true);
                            $('#opp_id option').filter(function () {
                                return ($(this).val() == calEvent.opp_id);
                            }).prop('selected', true);

                            var t = cur_start_val.slice(0, 2);
                            t = parseInt(t);
                            t = t + 1;
                            if (t < 10) {
                                var forward_time = ("0" + t + cur_start_val.slice(2));
                            } else {
                                var forward_time = (t + cur_start_val.slice(2));
                            }
                            if (cur_end_val < cur_start_val) {
                                $('#end_time option').filter(function () {
                                    return ($(this).val() == forward_time); //To select Blue
                                }).prop('selected', true);
                            } else {
                                forward_time = cur_end_val;
                            }
                            var h = parseInt(forward_time.slice(0, 2)) - parseInt(cur_start_val.slice(0, 2));
                            var m = parseInt(forward_time.slice(3)) - parseInt(cur_start_val.slice(3));
                            if (m < 0) {
                                h = h - 1;
                                m = 30;
                            }
                            var mins = h * 60 + m;
                            // $('#hours').text("("+h+"hrs "+m+"mins)");
                            $('#hours_mins').text("(" + mins + "mins)");
                            $('#comments').text('');
                            $("select").select2({
                                theme: "bootstrap",
                                minimumResultsForSearch: 1
                            });
                            $('#btn_add_hours').prop('disabled', false);
                            $('#add_hours').modal('show');
                        },

                        dayClick: function (date, allDay, jsEvent, view) {
                            console.log('dwaadw')
                            var currentdate = new Date();
                            // var str_cur_time = currentdate.getTime();
                            // var selected_time = new Date(start);
                            // var str_selected_time = selected_time.getTime();
                            function formatDate(date) {
                                var d = new Date(date),
                                    month = '' + (d.getMonth() + 1),
                                    day = '' + d.getDate(),
                                    year = d.getFullYear();
                                if (month.length < 2) month = '0' + month;
                                if (day.length < 2) day = '0' + day;
                                return [year, month, day].join('-');
                            }
                            var newDate = date;
                            var j = new Date(newDate)
                            var t = j.getTime();

                            var f = new Date(currentdate)
                            var r = f.getTime();


                            var checkDate = t > r;
                            console.log(t , r)

                            if (checkDate) {
                                $('#unavailable').modal('show')
                            }
                            else {

                                $('#btn_remove_hours').hide()
                                $('#opp_id').prop('disabled', false);
                                $('.opp_select_div').show()
                                $('.private_opp_div_add_hours').hide()
                                $('#is_edit').val(0);
                                $('#btn_remove_hours').hide();
                                $('.org_not_exist').show();
                                $('.private_opp_div').hide();
                                $('#is_no_org').val(0);
                                $('.opp_select_div').show();
                                $('.confirmed_track').hide();
                                $('.declined_track').hide();
                                $('#selected_date').val(date.format('YYYY-MM-DD'))


                                // var mDate =  date.format('hh:mm')
                                // var minutes = parseInt(date.format('mm')) + 30
                                // if (minutes == 60){
                                //     date.format('hh')
                                // }else{
                                //
                                // }
                                // var newDate = date.format('hh') + ':' + minutes
                                // var amPmDate = newDate + date.format('a');


                                // console.log(newDate)
                                // console.log(date.format('HH:mm'))
                                // var newDate = new Date(date)
                                // var t = new Date(newDate + 30* 60000);
                                // console.log(newDate)
                                // console.log($(end_time).val())
                                // console.log(date.format('hh:mm'))
                                $('#start_time > option[value="' + date.format('HH:mm') + '"]').attr('selected', 'true').text(date.format('(hh:mm)a'));
                                $('#end_time > option[value="' + $('#start_time > option[value="' + date.format('HH:mm') + '"]').next().val() + '"]').attr('selected', 'true').text($('#start_time > option[value="' + date.format('HH:mm') + '"]').next().text());
                                // calendar.formatDate(date,'h-mm' )
                                $('#hours_mins').text('(30mins)')
                                $('select option[value="Select an opportunity"]').attr('selected', 'true').text('Select an opportunity');
                                $("select").select2({
                                    theme: "bootstrap",
                                    minimumResultsForSearch: 1
                                });
                                // $("select option[value=" + val + "]").attr('selected', 'true').text(text);
                                $('#adding_hours_comments').val("")
                                $('#add_hours').modal('show');
                            }

                        },
                        viewDisplay: function (view) {
                            var now = new Date();
                            var end = new Date();
                            end.setMonth(now.getMonth() + 11); //Adjust as needed

                            var cal_date_string = view.start.getMonth() + '/' + view.start.getFullYear();
                            var cur_date_string = now.getMonth() + '/' + now.getFullYear();
                            var end_date_string = end.getMonth() + '/' + end.getFullYear();

                            if (cal_date_string == cur_date_string) {
                                jQuery('.fc-button-prev').addClass("fc-state-disabled");
                            }
                            else {
                                jQuery('.fc-button-prev').removeClass("fc-state-disabled");
                            }

                            if (end_date_string == cal_date_string) {
                                jQuery('.fc-button-next').addClass("fc-state-disabled");
                            }
                            else {
                                jQuery('.fc-button-next').removeClass("fc-state-disabled");
                            }
                        }
                    });

                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

            $()

            // $('body').on('click', '.fc-day, .fc-day-top, .fc-event-container, td:not(:has(.fc-event-container))', function () {
            //
            //     console.log($(this).data('date'))
            //
            //     if ($(this).data('date') !== undefined) {
            //         $('#selected_date').val($(this).data('date'))
            //     }
            //
            //
            //     if ($(this).data('date') !== undefined && $(this).data('date') == '') {
            //         var thead = $(this).parent().parent().siblings()[0];
            //         var tr = $(thead).children()[0];
            //         var result = $(tr).children()[$(this).index()];
            //
            //         if ($(this).data('date') !== undefined) {
            //             $('#selected_date').val($(result).data('date'))
            //         }
            //
            //     }
            //
            // });


            // var calendar = new FullCalendar.Calendar(calendarEl, {
            //     header: {
            //         left: 'prev,next today',
            //         center: 'title',
            //         right: 'month,basicWeek,basicDay'
            //     },
            //     defaultDate: '2018-04-12',
            //     navLinks: true, // can click day/week names to navigate views
            //     editable: true,
            //     eventLimit: true, // allow "more" link when too many events
            //     events: ''
            // });
            //
            // calendar.render();

        });

        $('#org_name').on('change', function () {
            $('#opp_date_div').hide()
            $('#invalid_org_name_alert').hide();
            var org_id = $(this).val();
            if (org_id != '') {
                var url = API_URL + 'volunteer/track/getOpportunities';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                var type = "post";
                var formData = {
                    org_id: org_id,
                }
                $.ajax({
                    type: type,
                    url: url,
                    data: formData,
                    success: function (data) {

                        $('#opp_name').find('option')
                            .remove()
                            .end();
                        // if(data.oppors != 'not exist'){
                        $('#opp_name')
                            .append($("<option></option>"));
                        $.each(data.oppor, function (index, value) {
                            $('#opp_name')
                                .append($("<option></option>")
                                    .attr("value", value.id)
                                    .text(value.title));
                        });
                        $("select").select2({
                            theme: "bootstrap",
                            minimumResultsForSearch: 1
                        });
                        //
                        // }
                        $('.org_does_exist').hide();
                        $('.opp_div').show();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
        //
        //
        // function OpptoggleStatus() {
        //
        //     if ($('#opp_not_exist').is(':checked')) {
        //         $('#opp_name').attr('disabled', true);
        //         $('.opp_private_div').show();
        //         $('#opp_date_div').show();
        //         $('.org_email_div').hide()
        //
        //     } else {
        //         $('#opp_name').removeAttr('disabled');
        //         $('.opp_private_div').hide();
        //         $('#opp_date_div').hide();
        //         $('.org_email_div').hide()
        //     }
        // }

        //
        // $('#btn_add_opp').on('click', function () {
        //
        //     var flag = 0;
        //     var is_org_exist = 0;
        //     var is_opp_exist = 0;
        //     if ($('#checkbox_div').is(':checked')) {
        //         if ($('#org_emails').val() == '') {
        //             $('#invalid_org_email_alert').show();
        //             flag++;
        //         }
        //         if ($('#private_opp_name').val() == '') {
        //             $('#invalid_private_name_alert').show();
        //             flag++;
        //         }
        //     } else {
        //         is_org_exist = 1;
        //         if ($('#org_name').val() == '') {
        //             $('#invalid_org_name_alert').show();
        //             flag++;
        //         }
        //         if ($('#opp_not_exist').is(':checked')) {
        //             if ($('#private_opp_name').val() == '') {
        //                 $('#invalid_private_name_alert').show();
        //                 flag++;
        //             }
        //         } else {
        //             is_opp_exist = 1;
        //             if ($('#opp_name').val() == '') {
        //                 $('#invalid_opp_name_alert').show();
        //                 flag++;
        //             }
        //         }
        //     }
        //
        //     if (flag == 0) {
        //         if (is_org_exist == 0) {
        //             $('#is_no_org').val(1);
        //             $('#add_opportunity').modal('toggle');
        //             $('.opp_select_div').hide();
        //             $('.private_opp_div').show();
        //             var private_opp = $('#private_opp_name').val();
        //             $('#private_opp_name_hours').val(private_opp);
        //             $('#add_hours').modal('toggle');
        //         } else {
        //             var url = API_URL + 'volunteer/track/joinToOpportunity';
        //             $.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });
        //             var org_id = $('#org_name').val();
        //             var opp_id = $('#opp_name').val();
        //             var opp_name = $('#opp_name option:selected').text();
        //             var org_email = $('#org_emails').val();
        //             var private_opp = $('#private_opp_name').val();
        //             var end_date = $('#end_date').val();
        //
        //             var type = "post";
        //             var formData = {
        //                 is_opp_exist: is_opp_exist,
        //                 org_id: org_id,
        //                 opp_id: opp_id,
        //                 opp_name: opp_name,
        //                 org_email: org_email,
        //                 private_opp: private_opp,
        //                 end_date: end_date,
        //             };
        //             console.log(formData)
        //             $.ajax({
        //                 type: type,
        //                 url: url,
        //                 data: formData,
        //                 success: function (data) {
        //                     var logo = SITE_URL + 'img/logo/opportunity-default-logo.png';
        //                     var currentdate = new Date();
        //                     var current_time = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + ' ' + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
        //                     var link = SITE_URL + 'volunteer/view_opportunity/' + opp_id;
        //
        //                     if (data.result == 'already exist') {
        //                         $('#opportunity_exist_alert').show().delay(5000).fadeOut();
        //                     } else if (data.result == 'public opportunity added') {
        //                         $('#external-events').append($('<div class="external-event navy-bg" value="' + opp_id + '">' + opp_name + '</div>'));
        //                         $('#opp_id').append($('<option value="' + opp_id + '">' + opp_name + '</option>'));
        //                         $('#add_opportunity').modal('toggle');
        //
        //                         if (data.opp_logo == null) {
        //                             logo = SITE_URL + 'img/logo/opportunity-default-logo.png';
        //                         } else {
        //                             logo = SITE_URL + 'uploads/' + data.opp_logo;
        //                         }
        //                         $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="' + logo + '"> <i class="fa fa-chain"></i>You Joined on Opportunity <a href="' + link + '"><strong>' + opp_name + '</strong></a></td><td>' + current_time + '</td></tr>'));
        //                         if ($('#is_from_addhour').val() == 1) {
        //                             $('#opp_id').select2().select2('val', opp_id);
        //                             $('#add_hours').modal('toggle');
        //                         }
        //                     } else if (data.result == 'private opportunity added') {
        //                         $('#external-events').append($('<div class="external-event private-bg" value="' + data.opp_id + '">' + private_opp + '</div>'));
        //                         $('#opp_id').append($('<option value="' + data.opp_id + '">' + private_opp + '</option>'));
        //                         $('#add_opportunity').modal('toggle');
        //
        //                         $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="' + logo + '"> <i class="fa fa-certificate"></i>You created Private Opportunity<strong>' + private_opp + '</strong></td><td>' + current_time + '</td></tr></i> <strong>' + private_opp + '</strong></a></span></div><div class="activity-buttons"><p>' + current_time + '</p></div></div>'));
        //                         $('.track-activity-panel').prepend($('<tr><td style="padding-left: 50px;"><img alt="image" class="img-circle" src="' + logo + '"> <i class="fa fa-chain"></i>You Joined on Private Opportunity <strong>' + private_opp + '</strong></td><td>' + current_time + '</td></tr>'));
        //
        //                         if ($('#is_from_addhour').val() == 1) {
        //                             $('#opp_id').select2().select2('val', data.opp_id);
        //                             $('#add_hours').modal('toggle');
        //                         }
        //                     }
        //                     // active_pagination();
        //                     $('#external-events div.external-event').each(function () {
        //
        //                         // store data so the calendar knows to render an event upon drop
        //                         $(this).data('event', {
        //                             title: $.trim($(this).text()), // use the element's text as the event title
        //                             stick: true, // maintain when user navigates (see docs on the renderEvent method)
        //
        //                         });
        //
        //                         // make the event draggable using jQuery UI
        //                         $(this).draggable({
        //                             zIndex: 1111999,
        //                             revert: true,      // will cause the event to go back to its
        //                             revertDuration: 0  //  original position after the drag
        //                         });
        //                     });
        //                 },
        //                 error: function (data) {
        //                     console.log('Error:', data);
        //                 }
        //             });
        //         }
        //     }
        // });


    </script>

@endsection