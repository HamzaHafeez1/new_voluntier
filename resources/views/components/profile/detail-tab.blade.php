@if($user->user_role === 'organization')
    <div class="row">
        <div class="col-12 col-md-8">

            <div class="main-text">
                @if($profile_info['is_my_profile'] == 1)
                    <p class="title">Organization Details</p>
                @else
                    <p class="title">Personal Info</p>
                @endif


                <p class="bold">Organization ID:</p>
                <p class="user_name_detail">{{$user->user_name}}</p>

                <p class="bold">Organization Name:</p>
                <p class="org_name_detail">{{$user->org_name}}</p>

                <p class="bold">Contact Email:</p>
                <p class="user_email_detail">{{$user->email}}</p>

                <p class="bold">Phone Number:</p>
                <p class="user_phone_detail">{{$user->contact_number}}</p>

                <p class="bold">{{$user->type_name}}</p>
                <div class="textarea_box user_education_detail" id="textarea_box">
                    {!!html_entity_decode(strip_tags($user->brif))!!}
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
                                            <span>{{$profile_info['tracks_hours']}}</span>
                                            <span>HOURS</span>

                                            @if($profile_info['is_my_profile'] == 1)
                                                <a href="{{ route('organization-track') }}"><span>Track</span></a>
                                            @else
                                                <div class="wrapper_connect_button">
                                                    @if($profile_info['is_friend'] == 0)

                                                        <a id="btn_connect" href="#"><span>Connect</span></a>

                                                        <a id="btn_pending" style="display: none" href="#"><span>Pending..</span></a>


                                                    @elseif($profile_info['is_friend'] == 1)
                                                        <a id="btn_pending"  href="#"><span>Pending..</span></a>

                                                    @elseif($profile_info['is_friend'] == 3)
                                                        <a id="btn_accept"
                                                           href="#"><span>Accept</span></a>
                                                     @else
		                                                <?php $args = ['chatId' => $chat_id];
		                                                if($chat_deleted){
			                                                $args['create'] = true;
		                                                    $args['opponent'] = $user->id;
		                                                }
		                                                ?>
                                                        <a id="btn_chat"
                                                           href="<?php echo route( Auth::user()->user_role . '-chat', $args )?>"><span>Chat</span></a>
                                                    @endif
                                                </div>
                                            @endif

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
                        <input type="hidden" id="lat_val" value="{{$user->lat}}">
                        <input type="hidden" id="lng_val" value="{{$user->lng}}">
                    </div>
                    <div class="main-text">
                        <p class="bold">Primary Location:</p>
                        <p>{{implode(', ', array_filter([$user->city, $user->state, $user->country, $user->zipcode]))}}</p>

                        @if($user->website)

                            <p class="bold">WebSite:</p>
                            <p>{{$user->website}}</p>

                        @endif


                        <p class="bold">Organization Type:</p>
                        <p>{{$user->type_name}}</p>
                    </div>
                </div>
          


        </div>
    </div>

@else

    <div class="row">
        <div class="col-12 order-0 col-md-8 order-md-0">

            <div class="main-text">
                <form action="{{url('/volunteer/commentStatus')}}" method="post">
                    {{ csrf_field() }}
                    <p class="title">Personal Info</p>

                    <p class="bold">User Name:</p>
                    <p class="user_name_profile">{{$user->user_name}}</p>

                    <p class="bold">Contact Email:</p>
                    <p class="user_email_profile">{{$user->email}}</p>
                    
                    @if(Auth::user()->id  != $user->id)
                        @if($user->post_status)
                            <p class="bold">Status:</p>
                            <p>{{$user->post_status}}</p>
                            <hr>
                            <p class="bold">Comments:</p>
                            @foreach($comments as $c)
                                @if($c->status_user_id == $user->id)
                                    <i>{{$c->commenter_name}}</i>: {{$c->body}} <br><br>
                                @endif
                            @endforeach

                            <input type="hidden" value="{{$user->post_status}}" name="status">
                            <input type="hidden" value="{{$user->id}}" name="friend_id">
                            <p class="bold">Add Comment:</p>

                            <input type="text" name="comment" class="form-control" required><br>
                            <input type="submit" value="Add comment" name="add_comment" class="btn btn-success" style="float:right;">
                        @endif
                    @endif
                </form>

              

                <?php
                $dob = $user->birth_date;
                $diff = (date('Y') - date('Y', strtotime($dob)));
                ?>
                @if($user->show_age == 'Y' && $user->user_role == 'volunteer')
                    <p class="bold">Age:</p>
                    <p>{{$diff}}</p>
                @elseif($user->show_age == 'N' && $user->user_role == 'volunteer')
                    @if(($profile_info['is_my_profile'] == 0) && ($profile_info['is_friend'] == 1))
                        <p class="bold">Birthdate:</p>
                        <p>{{$user->birth_date}}</p>
                    @endif
                @elseif($user->user_role == 'organization')
                    @if(($profile_info['is_my_profile'] == 0) && ($profile_info['is_friend'] == 1))
                        <p class="bold">Birthdate:</p>
                        <p>{{$user->birth_date}}</p>
                    @endif
                @endif
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
                        <p class="bold">{{$profile_info['logged_hours']}}</p>
                        <p class="light">HOUR(S)</p>
                        @if($profile_info['is_my_profile'] == 0)
                            <div class="wrapper_connect_button">
                                @if($profile_info['is_friend'] == 0)

                                    <a id="btn_connect" href="#"><span>Connect</span></a>

                                    <a id="btn_pending" style="display: none" href="#"><span>Pending..</span></a>


                                @elseif($profile_info['is_friend'] == 1)
                                    <a id="btn_pending"  href="#"><span>Pending..</span></a>

                                @elseif($profile_info['is_friend'] == 3)
                                    <a id="btn_accept"  href="#"><span>Accept</span></a>

                                @else
                                    <?php $args = ['chatId' => $chat_id];
                                    if($chat_deleted){
                                        $args['create'] = true;
                                        $args['opponent'] = $user->id;
                                    }
                                    ?>
                                    <a id="btn_chat"
                                       href="<?php echo route( Auth::user()->user_role . '-chat', $args )?>"><span>Chat</span></a>
                                @endif


                            </div>
                        @else
                            <a href="{{url('/volunteer/single_track')}}"><span>Add hours</span></a>
                        @endif


                    </div>
                </div>

            </div>


        </div>
    </div>

@endif