@extends('layout.frame')

@section('css')

@endsection

@section('body')
    <div class="row-content">
    <div class="wrapper-profile-box">


        <div class="top-profile-info">
            <form id="upload_logo" role="form" method="post" action="{{url('api/organization/profile/upload_logo')}}"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" accept="image/*" name="file_logo" id="upload_logo_input" hidden="true">
            </form>


            <form id="upload_logo1" role="form" method="post"
                  action="{{url('api/organization/profile/upload_back_img')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" accept="image/*" name="file_logo" id="upload_logo1_input" hidden="true">
            </form>


            <div class="img-box"
                 style="background-image:url('{{$user_info->back_img == NULL ? asset('front-end/img/bg/0002.png') :  asset('uploads' .'/'. $user_info->back_img)}} ')"></div>


            <div class="container mobile-container">
                <div class="avatar"
                     style="background-image:url('{{$user_info->logo_img == NULL ? asset('front-end/img/org/001.png') : asset('uploads' .'/'. $user_info->logo_img)}}')">
                    <span></span></div>


                <div class="link-img">

                </div>

            </div>

            <div class="container">
                <div class="row txt-box">

                    <div class="col-12 col-md-6">

                        <div class="main-text"><p class="h2">{{$user_info->org_name}}</p></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="main-text">

                            <ul class="list-column clearfix">
                                <li>
                                    @if($user_role == 'organization')
                                        <p class="h2">{{count($members)}}</p>
                                        <p class="light">Members</p>
                                    @else
                                        <p class="h2">{{$friend->count()}}</p>
                                        <p class="light">Friends</p>
                                    @endif
                                </li>
                                <li>
                                    <p class="h2">{{$group->count()}}</p>
                                    <p class="light">Groups</p>
                                </li>
                                <li>
                                    @if($user_role == 'organization')
                                        <p class="h2">{{$active_oppr->count()}}</p>
                                        <p class="light">Opportunites</p>
                                    @else
                                        <p class="h2">{{$opportunity->count()}}</p>
                                        <p class="light">Opportunites</p>
                                    @endif



                                </li>
                            </ul>

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
                        <a class="nav-link disabled show" href="#info" role="tab"
                           data-toggle="tab"><span>Info</span></a>
                    </li>


                </ul>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="details">


                        @if($user_info->user_role === 'organization')
                            <div class="row">
                                <div class="col-12 col-md-8">

                                    <div class="main-text">
                                        <p class="title">Personal Info</p>


                                        <p class="bold">Organization ID:</p>
                                        <p class="user_name_detail">{{$user_info->user_name}}</p>

                                        <p class="bold">Organization Name:</p>
                                        <p class="org_name_detail">{{$user_info->org_name}}</p>

                                        <p class="bold">Contact Email:</p>
                                        <p class="user_email_detail">{{$user_info->email}}</p>

                                        <p class="bold">Phone Number:</p>
                                        <p class="user_phone_detail">{{$user_info->contact_number}}</p>

                                        <p class="bold">{{$user_info->type_name}}</p>
                                        <div class="textarea_box user_education_detail">
                                            {!!html_entity_decode(strip_tags($user_info->brif))!!}
                                        </div>

                                    </div>

                                </div>
                                <div class="col-12 col-md-4">


                                    <div class="dashboard_org">
                                        <div class="track-it-time_slider">
                                            <div class="slider">
                                                <div>

                                                    <div class="slider-wrapper">
                                                        <div>
                                                            <div class="slider-item-scale">

                                                                <div>
                                                                    <span>IMPACTS</span>
                                                                    @if($user_role == 'organization')
                                                                        <span>{{$tracks_hours}}</span>
                                                                    @else
                                                                        <span>{{$logged_hours}}</span>
                                                                    @endif

                                                                    <span>HOURS</span>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="details_content">
                                        <div class="map-box" id="pos_map">
                                            <input type="hidden" id="lat_val" value="{{$user_info->lat}}">
                                            <input type="hidden" id="lng_val" value="{{$user_info->lng}}">
                                        </div>
                                        <div class="main-text">
                                            <p class="bold">Primary Location:</p>
                                            <p>{{implode(', ', array_filter([$user_info->city, $user_info->state, $user_info->country, $user_info->zipcode]))}}</p>

                                            @if($user_info->website)

                                                <p class="bold">WebSite:</p>
                                                <p>{{$user_info->website}}</p>

                                            @endif


                                            <p class="bold">Organization Type:</p>
                                            <p>{{$user_info->type_name}}</p>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        @else

                            <div class="row">
                                <div class="col-12 order-0 col-md-8 order-md-0">

                                    <div class="main-text">
                                        <p class="title">Personal Info</p>

                                        <p class="bold">User Name:</p>
                                        <p>{{$user_info->user_name}}</p>

                                        <p class="bold">Contact Email:</p>
                                        <p>{{$user_info->email}}</p>


                                        <?php
                                        $dob = $user_info->birth_date;
                                        $diff = (date('Y') - date('Y', strtotime($dob)));
                                        ?>

                                        @if($user_info->show_age == 'Y' && $user_info->user_role == 'volunteer')



                                            <p class="bold">Age:</p>



                                            <p>{{$diff}}</p>



                                        @elseif($user_info->show_age == 'N' && $user_info->user_role == 'volunteer')






                                        @endif
                                        <p class="bold">Summary</p>
                                    <p>{!!html_entity_decode(strip_tags($user_info->brif))!!}</p>

                                    </div>

                                </div>

                                <div class="col-12 order-2 col-md-4 order-md-1">


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
                                                                <span>37</span>
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

                                        <div class="wrapper_green_bg">
                                            <div class="main-text">
                                                <p>IMPACTS</p>

                                                @if($user_role == 'organization')
                                                    <p class="bold">{{$tracks_hours}}</p>
                                                @else
                                                    <p class="bold">{{$logged_hours}}</p>
                                                @endif



                                                <p class="light">HOUR(S)</p>


                                            </div>

                                        </div>
                                        <div class="details_content">
                                            <div class="map-box" id="pos_map">
                                                <input type="hidden" id="lat_val" value="{{$user_info->lat}}">
                                                <input type="hidden" id="lng_val" value="{{$user_info->lng}}">
                                            </div>
                                            <div class="main-text">
                                                <p class="bold">Primary Location:</p>
                                                <p>{{implode(', ', array_filter([$user_info->city, $user_info->state, $user_info->country, $user_info->zipcode]))}}</p>

                                                @if($user_info->website)

                                                    <p class="bold">WebSite:</p>
                                                    <p>{{$user_info->website}}</p>

                                                @endif

                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>

                        @endif


                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>

    <script src="{{asset('front-end/js/jquery-3.3.1.slim.js')}}"></script>
    <script src="{{asset('js/jquery-2.1.1.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es"></script>
    <script>

        var latLng = new google.maps.LatLng(parseFloat('{{$user_info->lat}}'), parseFloat('{{$user_info->lng}}'));
        var myOptions = {
            zoom: 16,
            center: latLng,
            styles: [{
                "featureType": "water",
                "stylers": [{"saturation": 43}, {"lightness": -11}, {"hue": "#0088ff"}]
            }, {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [{"hue": "#ff0000"}, {"saturation": -100}, {"lightness": 99}]
            }, {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#808080"}, {"lightness": 54}]
            }, {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ece2d9"}]
            }, {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ccdca1"}]
            }, {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{"color": "#767676"}]
            }, {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [{"color": "#ffffff"}]
            }, {"featureType": "poi", "stylers": [{"visibility": "off"}]}, {
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"color": "#b8cb93"}]
            }, {"featureType": "poi.park", "stylers": [{"visibility": "on"}]}, {
                "featureType": "poi.sports_complex",
                "stylers": [{"visibility": "on"}]
            }, {"featureType": "poi.medical", "stylers": [{"visibility": "on"}]}, {
                "featureType": "poi.business",
                "stylers": [{"visibility": "simplified"}]
            }],
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


