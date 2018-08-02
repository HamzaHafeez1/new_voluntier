@extends('layout.masterForAuthUser')

@section('css')
    <style>
        .opp-public{
            text-decoration: none;
            cursor: pointer;
            height: 40px;
            font-size: 14px;
            line-height: 24px;
            text-transform: uppercase;
            font-weight: 700;
            font-family: 'Open Sans',sans-serif;
            color: #fff;
            margin: 0;
            padding: 8px 30px;
            background: #3bb44a;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            max-width: 100%;
            -webkit-box-shadow: 0 6px 16px 0 rgba(29,125,41,0.3);
            -moz-box-shadow: 0 6px 16px 0 rgba(29,125,41,0.3);
            box-shadow: 0 6px 16px 0 rgba(29,125,41,0.3);
        }

        .opp-public:hover{
            background: #fff;
            color: #3bb44a;
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
    </style>
    <link rel="stylesheet" href="{{asset('front-end/css/star-rating.css')}}">
@endsection



@section('content')
    <div class="wrapper-friends">
        <div class="search-friends">
            <div class="container">


                <div class="search">
                    <label><span class="gl-icon-search"></span></label>

                    <input type="text" class="form-control m-b" id="filter" placeholder="Search in table">
                </div>

            </div>
        </div>

        <div class="wrapper-friends-list">
            <div class="container">


                <div class="wrapper-sort-table">
                    <div >

                        <table id="example" data-filter=#filter class="table sortable confirm-table" >
                            <thead>
                            <tr>
                                <th>
                                    <div class="main-text"><p>Volunteer</p></div>
                                </th>
                                <th>
                                    <div class="main-text"><p>Opportunity</p></div>
                                </th>
                                <th>
                                    <div class="main-text"><p>Date</p></div>
                                </th>
                                <th>
                                    <div class="main-text"><p>Mins</p></div>
                                </th>
                                <th>
                                    <div class="main-text"><p>Submitted Time</p></div>
                                </th>
                                <th class="text-center" data-defaultsort="disabled">
                                    <div class="main-text"><p>&nbsp;</p></div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach($tracks as $t)
                                <tr id="track{{$t['track_id']}}">
                                    <td>
                                        <a href="{{url('/')}}/volunteer/profile/{{$t['volunteer_id']}}" target="_blank">
                                            <div class="avatar"
                                                 @if($t['volunteer_logo'] == null)
                                                 style="background-image:url('{{asset('img/logo/member-default-logo.png')}}')"
                                                 @else
                                                 style="background-image:url('{{asset('uploads'. '/' . $t['volunteer_logo'])}}')"
                                                 @endif
                                            ></div>
                                            <div class="main-text"><p>{{$t['volunteer_name']}}</p></div>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{url('/')}}/organization/edit_opportunity/{{$t['opportunity_id']}}"
                                           target="_blank">
                                            <div class="avatar"
                                                 @if($t['opportunity_status'] != 0)

                                                 @if($t['opportunity_logo'] == null)
                                                 style="background-image:url('{{asset('front-end/img/org/001.png')}}')"
                                                 @else
                                                 style="background-image:url('{{asset('uploads'. '/' . $t['opportunity_logo'])}}')"
                                                 @endif

                                                 @else
                                                 style="background-image:url('{{asset('front-end/img/org/001.png')}}')"

                                                 @endif
                                            ></div>
                                            <div class="main-text"><p>{{$t['opportunity_name']}}</p></div>
                                        </a>
                                    </td>

                                    <td data-dateformat="YYYY-MM-DD">

                                        <div class="main-text"><p class="light">{{$t['logged_date']}}</p></div>

                                    </td>

                                    <td>
                                        <div class="main-text"><p class="light">{{$t['logged_mins']}}</p></div>
                                    </td>

                                    <td data-dateformat="YYYY-MM-DD HH:mm:ss">
                                        <div class="main-text"><p class="light">{{$t['updated_at']}}</p></div>
                                    </td>

                                    <td class="text-center">
                                        <input type="hidden" class="track_id" value="{{$t['track_id']}}">
                                        <input type="hidden" class="volunteer_name" value="{{$t['volunteer_name']}}">
                                        <input type="hidden" class="volunteer_logo" value="{{str_replace (' ','%20',$t['volunteer_logo'])}}">
                                        <input type="hidden" class="opportunity_id" value="{{$t['opportunity_id']}}">
                                        <input type="hidden" class="opportunity_name"
                                               value="{{$t['opportunity_name']}}">
                                        <input type="hidden" class="opportunity_logo"
                                               value="{{$t['opportunity_logo']}}">
                                        <input type="hidden" class="worked_date" value="{{$t['logged_date']}}">
                                        <input type="hidden" class="started_time" value="{{$t['started_time']}}">
                                        <input type="hidden" class="ended_time" value="{{$t['ended_time']}}">
                                        <input type="hidden" class="worked_mins" value="{{$t['logged_mins']}}">
                                        <input type="hidden" class="submitted_time" value="{{$t['updated_at']}}">
                                        <input type="hidden" class="volunteer_comment" value="{{$t['comment']}}">
                                        <input type="hidden" class="opportunity_type"
                                               value="{{$t['opportunity_status']}}">
                                        <a href="#" class="action btn_action"><span>Action</span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('components.auth.modal_pop_up_action_track_org')

@endsection



@section('script')
    <!--<script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script>-->
    <script src="<?=asset('js/plugins/dataTables/jquery.dataTables.js')?>"></script>
    <script src="{{asset('front-end/js/star-rating.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('.confirm-table').dataTable({
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
            /*$('.confirm-table').footable({
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

            /*if($('.footable-page-arrow:last').text() < 5) $('.footable-page-arrow:last').hide();
            else $('.footable-page-arrow:last').show();

                $(document).on('click', 'a[data-page]', function () { //, .footable-page-arrow
                    if($('.footable-page:first a').data('page') == 0) $('.footable-page-arrow:first').hide();
                    else $('.footable-page-arrow:first').show();
                    if(parseInt($('.footable-page:last a').data('page')) + 1 == $('.footable-page-arrow:last').text()) $('.footable-page-arrow:last').hide();
                    else $('.footable-page-arrow:last').show();
                });*/


                /*$('.confirm-table').footable({
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


                $('.search-input').on('keyup', function (e) {
                    if (e.keyCode == 13) {
                        $('#btn_search_page').trigger('click');
                    }
                })


                $('.filter').on('click', function () {
                    console.log('change')
                    $('#btn_search_page').trigger('click');

                });



            $('.volunteer-rate').rating();



            $('.btn_action').on('click', function (e) {
                e.preventDefault()

                setTimeout(function () {
                    $('body').removeClass('modal-open')
                }, 200)

                $('#wrapper_div').hide();
                $('#myModalTrackedHours').modal('show');

                $('#checkbox_div').attr("checked", false);
                $('.review-comment').val('');
                $('.review').hide();
                $('.private-opp').hide();


                var track = $(this).parent().find('.track_id').val();
                var v_name = $(this).parent().find('.volunteer_name').val();
                var v_logo = $(this).parent().find('.volunteer_logo').val();
                var o_id = $(this).parent().find('.opportunity_id').val();
                var o_name = $(this).parent().find('.opportunity_name').val();
                var o_logo = $(this).parent().find('.opportunity_logo').val();
                var w_date = $(this).parent().find('.worked_date').val();
                var s_time = $(this).parent().find('.started_time').val();
                var e_time = $(this).parent().find('.ended_time').val();
                var w_mins = $(this).parent().find('.worked_mins').val();
                var submit_t = $(this).parent().find('.submitted_time').val();
                var v_comment = $(this).parent().find('.volunteer_comment').val();
                var o_type = $(this).parent().find('.opportunity_type').val();
                $('#track_id').val(track);
                if (v_logo != '') {
                    var string = 'url(' + SITE_URL + "uploads/" + v_logo + ')';
                    string = string.replace(/ /g, '%20')
                    $('.v-logo').css('background-image', string);
                } else {
                    var string = 'url(' + SITE_URL + "img/logo/member-default-logo.png" + ')'
                    $('.v-logo').css('background-image', string);
                }

                if (o_logo != '') {
                    var stringOpp = 'url(' +'"' + SITE_URL + "uploads/" + o_logo + '"' + ');';
                    stringOpp = stringOpp.replace(/ /g, '%20');
                    console.log(stringOpp)
                    // $('#o-logo-modal').css('background-image', stringOpp);
                    // console.log($('#o-logo-modal').css('background-image', stringOpp))
                    // $('#o-logo-modal').hide()
                    $('#o-logo-modal').attr("style", 'background-image: ' + stringOpp)

                } else {
                    var stringOpp = 'url(' + SITE_URL + "front-end/img/org/001.png" + ')';
                    $('#o-logo-modal').css('background-image', stringOpp);
                }
                $('.opp-public').attr('href', SITE_URL + "organization/edit_opportunity/" + o_id);
                $('.v-name').text(v_name);
                $('.o-name').text(o_name);
                $('.w-mins').text(w_mins + " mins");
                $('.track-comment').text(v_comment);
                $('.submitted-time').text(submit_t);
                $('.worked-time').text(w_date + ' ' + s_time + ' to ' + e_time);
                if (o_type == 0) {
                    $('.private-opp').show();
                }
            })

            $('#btn_approve').on('click', function () {
                var track_id = $('#track_id').val();
                var is_review = 0;
                if ($('#checkbox_div').is(":checked")) {
                    is_review = 1;
                }
                var review_score = $('#input-rating').val();
                var review_comment = $('.review-comment').val();
                var url = API_URL + 'organization/track/approve';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                var type = "post";
                var formData = {
                    track_id: track_id,
                    is_review: is_review,
                    review_score: review_score,
                    review_comment: review_comment,
                }
                $.ajax({
                    type: type,
                    url: url,
                    data: formData,
                    success: function (data) {
                        $('#' + 'track' + track_id).remove();
                        $('#track_process').modal('toggle');
                        $('.close').click()
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

            $('#btn_decline').on('click', function () {
                var track_id = $('#track_id').val();
                var url = API_URL + 'organization/track/decline';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                console.log();
                var type = "post";
                var formData = {
                    track_id: track_id,
                }
                $.ajax({
                    type: type,
                    url: url,
                    data: formData,
                    success: function (data) {
                        $('#' + 'track' + track_id).remove();
                        $('#track_process').modal('toggle');
                        $('.close').click()
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

        });

        $("#checkbox_div").click(function () {
            if ($(this).is(":checked")) {
                $('#wrapper_div').css("display","block");
            } else {
                $('#wrapper_div').css("display","none");
            }
        });

        $('.kv-fa').rating({
            clearButton: '<i class="fa fa-minus-circle"></i>',
            filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>'
        });

    </script>
@endsection
