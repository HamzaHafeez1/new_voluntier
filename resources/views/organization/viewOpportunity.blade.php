@extends('layout.masterForAuthUser')



@section('css')
    <link rel="stylesheet" href="{{asset('front-end/css/bootstrap-sortable.css')}}">
@endsection



@section('content')

    <div class="wrapper-profile-box">


        <!-- -->

        <div class="dashboard_org">
            <div class="org-info-box">

                <div class="container">

                    <div class="row align-items-center">
                        <div class="col-12 col-md-5">

                            <div class="big-org-logo"><span
                                        style="background-image:url('{{$oppr_info->logo_img == NULL ?  asset('front-end/img/org/001.png') : asset('uploads') . '/' . $oppr_info->logo_img}}')"></span>
                            </div>

                        </div>
                        <div class="col-12 col-md-7">

                            <div class="main-text">

                                <h2 class="h2">{{$oppr_info->title}}</h2>

                                <p class="mb-0"><b>Time Info:</b></p>
                                <p>{{$oppr_info->start_date}} to {{$oppr_info->end_date}}</p>

                                <p class="mb-0"><b>Hosted By:</b></p>
                                <p>{{$oppr_info->org_name}}</p>

                                <p class="mb-0"><b>Status:</b></p>
                                <p>{{$oppr_info->end_date < date("Y-m-d") ? 'Expired' :  'Active'}}</p>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- -->

        <div class="text-profile-info">

            <div class="container">


                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" href="#details" role="tab"
                           data-toggle="tab"><span>Details</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#members" role="tab" data-toggle="tab"><span>Members</span></a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="details">


                        <div class="row">
                            <div class="col-12 col-md-8">

                                <div class="main-text">
                                    <p class="title">Opportunity Details</p>

                                    <p class="bold">Opportunity Type:</p>
                                    <p>@if(array_key_exists('opportunity_type',$oppr_info->toArray())){{$oppr_info->opportunity_type}}@endif</p>

                                    <p class="bold">Opportunity Code:</p>
                                    <p>{{$oppr_info->id}}</p>

                                    <p class="bold">Contact Name:</p>
                                    <p>{{$oppr_info->contact_name}}</p>

                                    <p class="bold">Contact Email:</p>
                                    <p>{{$oppr_info->contact_email}}</p>

                                    <p class="bold">Phone number:</p>
                                    <p>{{$oppr_info->contact_number}}</p>

                                    <p class="bold">Qualifications:</p>
                                    <p>{{$oppr_info->qualification}}</p>

                                    <p class="bold">Description:</p>
                                    <p>{{$oppr_info->description}}</p>


                                </div>

                            </div>
                            <div class="col-12 col-md-4">


                                <div class="dashboard_org">
                                    <!--
                                    <div class="track-it-time_slider">


                                        <div class="slider">
                                            <div>

                                                <div class="slider-wrapper">
                                                <div>
                                                    <div class="slider-item-scale">

                                                        <div>
                                                            <span>IMPACTS</span>
                                                            <span>22</span>
                                                            <span>HOURS</span>
                                                            <a href="#"><span>Add hours</span></a>
                                                        </div>

                                                    </div>
                                                </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    -->
                                    <!--
                                                                    <div class="wrapper_green_bg">
                                                                        <div class="main-text">
                                                                            <p>IMPACTS</p>
                                                                            <p class="bold">22</p>
                                                                            <p class="light">HOUR(S)</p>
                                                                            <a href="#"><span>Add hours</span></a>
                                                                        </div>
                                                                    </div>
                                    -->

                                </div>

                                <div class="details_content">
                                    <div class="map-box" id="pos_map">
                                        <input type="hidden" id="lat_val" value="{{$oppr_info->lat}}">
                                        <input type="hidden" id="lng_val" value="{{$oppr_info->lng}}">
                                    </div>
                                    <div class="main-text">
                                        <p class="bold">Address:</p>
                                        <p>{{$oppr_info->street_addr1}}, {{$oppr_info->city}}, {{$oppr_info->state}}
                                            , {{$oppr_info->zipcode}}</p>

                                        <p class="bold">Date:</p>
                                        <p>{{$oppr_info->start_date}} - {{$oppr_info->end_date}}</p>

                                        <p class="bold">Time:</p>
                                        <p>{{$oppr_info->start_at}} - {{$oppr_info->end_at}}</p>

                                        <p class="bold">Days of Week:</p>
                                        <p>{{$oppr_info->weekdays}}</p>

                                        <p class="bold">Minimum Age:</p>
                                        <p>{{$oppr_info->min_age}}</p>

                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="members">

                        <!-- -->
                        <!-- -->
                        <!-- -->

                        <div class="wrapper-friends">

                            <!--
                            <div class="search-friends">
                                <div class="container">


                                    <div class="search send_invitation clearfix">
                                        <input type="text" placeholder="Type name to invite">
                                        <a href="#" class="send_invitation"><span>Send invitation</span></a>
                                    </div>

                                </div>
                            </div>
                            -->

                            <div class="wrapper-friends-list pb-0 pt-0">

                                <div class="main-text">
                                    <p class="title">Opportunity Members</p>
                                </div>


                                <div class="wrapper-sort-table">
                                    <div>

                                        <table id="example" class="table sortable">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <div class="main-text"><p>Member Name</p></div>
                                                </th>
                                                <th>
                                                    <div class="main-text"><p>Email</p></div>
                                                </th>
                                                <th>
                                                    <div class="main-text"><p>Phone</p></div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($oppr_info->opportunity_member as $om)
                                                <tr>

                                                    <?php $member_info = \App\User::find($om->user_id); ?>


                                                    <td>{{$member_info->first_name}} {{$member_info->last_name}}</td>

                                                    <td>{{$member_info->email}}</td>

                                                    <td>{{$member_info->contact_number}}</td>

                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <!--
                                <div class="wrapper-pagination">

                                      <ul class="pagination flex-wrap justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>

                                        <li class="page-item disabled">
                                          <span class="page-link">…</span>
                                        </li>

                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">7</a></li>
                                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                                        <li class="page-item"><a class="page-link" href="#">9</a></li>

                                        <li class="page-item disabled">
                                          <span class="page-link">…</span>
                                        </li>

                                        <li class="page-item"><a class="page-link" href="#">17</a></li>
                                      </ul>

                                </div>
                                -->

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


@endsection



@section('script')

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es"></script>
    <script src="{{asset('front-end/js/bootstrap-sortable.js')}}"></script>


    <script>
        $('.wrapper_input.fa-icons input').datepicker({
            'format': 'mm/dd/yyyy',
            'autoclose': true,
            'orientation': 'right',
            'todayHighlight': true
        });
    </script>
    <script>
        var latLng = new google.maps.LatLng(parseFloat($('#lat_val').val()), parseFloat($('#lng_val').val()));

        var myOptions = {
            zoom: 16,
            center: latLng,
            styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}],
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("pos_map"), myOptions);
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: '{{asset('front-end/img/pin.png')}}'
        });
    </script>

@endsection