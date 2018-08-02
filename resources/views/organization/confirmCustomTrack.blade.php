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
        .approved-alert{max-width: 600px; margin: auto; padding: 20px 10px 20px 10px; border: 1px solid#3bb44a; margin-bottom: 20px; display: none}
        .approved-alert h3{text-align: center; color: #3bb44a}
        .decline-alert{max-width: 600px; margin: auto; padding: 20px 10px 20px 10px; border: 1px solid#ff0000; margin-bottom: 20px; display: none}
        .decline-alert h3{text-align: center; color: red}
    </style>
    <link rel="stylesheet" href="{{asset('front-end/css/star-rating.css')}}">
@endsection
@section('content')
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-dialog-fix">
            <div>


                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h2 class="h2">Process Tracked Hours</h2>
                            <h3 class="h3">Please approve hours, your volunteers logged!</h3>
                        </div>



                    </div>
                    <div class="modal-body">

                        <div class="form-group">


                            <div class="tracked_hours_box">

                                <table>
                                    <tr>

                                        <td><div  @if($track['volunteer_logo'] == null)
                                                  style="background-image:url('{{asset('img/logo/member-default-logo.png')}}')"
                                                  @else
                                                  style="background-image:url('{{asset('uploads'. '/' . $track['volunteer_logo'])}}')"
                                                  @endif
                                                  class="avatar v-logo"></div></td>

                                        <td><div class="main-text"><p class="text-center"><i class="fa fa-long-arrow-right"></i></p></div></td>
                                        <td><div
                                                    @if($track['opportunity_logo'] == null)
                                                    style="background-image:url('{{asset('front-end/img/org/001.png')}}')"
                                                    @else
                                                    style="background-image:url('{{asset('uploads'. '/' . $track['opportunity_logo'])}}')"
                                                    @endif
                                                    id="o-logo-modal" class="avatar o-logo"></div></td>
                                    </tr>
                                    </tr>
                                    <td><div class="main-text"><p class="v-name">{{$track['volunteer_name']}}</p></div></td>
                                    <td><div class="main-text"><p class="red "><strong class="w-mins">{{$track['logged_mins']}} mins</strong></p></div></td>
                                    <td><div class="main-text"><p class="o-name">{{$track['opportunity_name']}}</p></div></td>
                                </table>

                            </div>

                        </div>
                        <div class="form-group private-opp">
                            <p style="float: left; margin-top: 8px;">This is private opportunity volunteer has created to add hours: &nbsp;</p>
                            <a style="float: right" href="{{url('/')}}/organization/edit_opportunity/{{$track['opportunity_id']}}" class="wrapper-link opp-public ">Make Public</a>
                        </div>
                        <div class="form-group">

                            <div class="main-text">
                                <p class="mb-0"><strong>Worked Period:</strong></p>
                                <p class="worked-time">{{$track['logged_date']}} {{$track['started_time']}} to {{$track['ended_time']}}</p>

                                <p class="mb-0"><strong>Submitted Time:</strong></p>
                                <p class="submitted-time">{{$track['updated_at']}}</p>

                                <p class="mb-0"><strong>Comments From Volunteer</strong></p>
                                <p class="track-comment">{{$track['comment']}}</p>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="wrapper-checkbox"><label>
                                    <input id="checkbox_div" type="checkbox">
                                    <i></i>
                                    <span class="label-checkbox-text" id="allow_review">Give Review to Volunteer</span>
                                </label></div>
                        </div>

                        <div id="wrapper_div" style="display:none;">

                            <div class="form-group">
                                <label class="label-text">Review:</label>
                                <input id="input-rating" type="text" class="kv-fa rating-loading" value="4" data-size="xs" title="">
                            </div>

                            <div class="form-group">
                                <label class="label-text">Comments:</label>
                                <div class="wrapper_input">
                                    <textarea class="review-comment" placeholder=""></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <input type="hidden" id="track_id" value="{{$track['track_id']}}">
                    <div class="modal-footer">


                        <div class="wrapper_row_link">
                            <div class="row">
                                <div class="col-12">

                                    <div class="wrapper-link two-link">
                                        <a href="#" id="btn_decline" class="red"><span>Decline</span></a>
                                        <a href="#" id="btn_approve"><span>Approve</span></a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="approved-alert">
                        <h3>Tracked hours approved!</h3>
                    </div>
                    <div class="decline-alert">
                        <h3>Tracked hours declined!</h3>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection


@section('script')

    <script src="{{asset('front-end/js/star-rating.js')}}"></script>
    <script>
        $(document).ready(function () {


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


            $('#btn_approve').on('click', function () {
                var track_id = $('#track_id').val();
                var url = API_URL + 'organization/track/approve';
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
                        $('.approved-alert').show();
                        window.setTimeout(function () {

                            // Move to a new location or you can do something else
                            window.location.href = SITE_URL;

                        }, 3000);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            })

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
                        $('.decline-alert').show();
                        window.setTimeout(function () {

                            // Move to a new location or you can do something else
                            window.location.href = SITE_URL;

                        }, 3000);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

            $("#checkbox_div").click(function () {
                if ($(this).is(":checked")) {
                    $('#wrapper_div').css("display", "block");
                } else {
                    $('#wrapper_div').css("display", "none");
                }
            });

            $('.kv-fa').rating({
                clearButton: '<i class="fa fa-minus-circle"></i>',
                filledStar: '<i class="fa fa-star"></i>',
                emptyStar: '<i class="fa fa-star-o"></i>'
            });
        });
    </script>

@endsection
