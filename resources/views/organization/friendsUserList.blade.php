<ul class="friends-list clearfix {{$nameClassUl}}">
    @if(count($friends))
        @foreach($friends as $friend)
            <li>
                @if($friend->user_role == 'organization')
                    @if($nameClassUl === 'friend_requests')
                    <a href="{{url('/') . "/organization/profile/" . $friend->user_id}}">
                        @else
                            <a href="{{url('/') . "/organization/profile/" . $friend->friend_id}}">
                        @endif
                        @else
                            @if($nameClassUl === 'friend_requests')
                            <a href="{{url('/') . "/volunteer/profile/" . $friend->user_id}}">
                                @else
                                    <a href="{{url('/') . "/volunteer/profile/" . $friend->friend_id}}">
                                @endif
                                @endif

                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar"
                                            @if($friend->user_role === 'organization')
                                                style="background-image:url({{$friend->logo_img === null ? asset('front-end/img/org/001.png') : asset('uploads'. '/' . str_replace (' ','%20',$friend->logo_img)) }})">
                                            @else
                                                style="background-image:url({{$friend->logo_img === null ? asset('img/noprofilepic.png') : asset('uploads'. '/' . str_replace (' ','%20',$friend->logo_img)) }})">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="main-text">
                                            <p class="name">{{ $friend->org_name ? ucfirst($friend->org_name) :  ucfirst($friend->first_name) . ' ' . ucfirst($friend->last_name)}}</p>
                                            <p class="light">{{ implode(', ', array_filter([ucfirst($friend->city), ucfirst($friend->state)]))}}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="times"><span onclick="request_update({{ $friend->id }}, {{ $friend->friend_id }}, 0, 0)">&times;</span></a>
                        @if($nameClassUl === 'friend_requests')
                                <div class="dashboard_org  ul.notifications-list">
                                    <div class="news-followed-box">
                                        <ul class="notifications-list">
                                            <a  class="process" href="#" onclick="request_update({{ $friend->id }}, {{ $friend->user_id }}, 2)"><span>Accept</span></a>

                                            <a class="process" href="#" onclick="request_update({{ $friend->id }}, {{ $friend->user_id }}, 0, 1)">Dismiss</a>
                                        </ul>

                                    </div>
                                </div>
                        @endif
                    </a>
            </li>
        @endforeach
    @endif
</ul>