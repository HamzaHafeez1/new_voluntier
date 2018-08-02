@extends('layout.masterForAuthUser')

@section('css')
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.bxslider.css')}}">

    <style>
        .wrapper-right-text-info ul li a{
            text-decoration: none;
        }


    </style>
@endsection

@section('content')
    <div class="dashboard_org">


        {{--<div class="org-info-box">--}}

            {{--<div class="container">--}}

                {{--<div class="row align-items-center">--}}
                    {{--<div class="col-12 col-md-5">--}}

                        {{--<div class="big-org-logo"><span--}}
                              {{--style="background-image:url({{asset(Auth::user()->logo_img == NULL ?--}}
                               {{--'img/people/noprofilepic.png' :  'uploads/' . Auth::user()->logo_img )}}"></span>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                    {{--<div class="col-12 col-md-7">--}}

                        {{--<div class="main-text">--}}

                            {{--<h2 class="h2">{{Auth::user()->getFullNameVolunteer()}}</h2>--}}
                            {{--<h3 class="h3">Summary</h3>--}}

                            {{--<div>--}}
                                {{--<p>{!!html_entity_decode(Auth::user()->brif)!!}</p>--}}
                            {{--</div>--}}

                            {{--<a href="{{ route('volunteer-account-setting') }}" class="myaccount"><span>My Profile</span></a>--}}

                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}

        {{--</div>--}}


        <div class="container">

            <div class="news-followed-box  mt25">


                <div class="main-text"><h2 class="h2">News Feeds</h2></div>

                <div class="row">
                    <div class="col-12 col-md-8">

                        <ul class="news-feeds-list">
                            @if (count($feedNewsArr) > 0)
                                @foreach($feedNewsArr as $nawfVal)
                            <li><div class="news-feeds-item">
                                    <span><span class="avatar"
                                                style="background-image:url('{{asset($nawfVal['who_joined_imag'])}}')"></span></span>
                                    <span>
                                        <span class="name"><a href="{{url( $nawfVal['userurl'] )}}">{{ ucwords($nawfVal['who_joined']) }}</a></span>
                                        <span class="light">{{ ucwords($nawfVal['reason']) }}</span>
                                        <span><a href="{{url( $nawfVal['utl'] )}}">{{ ucwords($nawfVal['name']) }}</a></span>
                                    </span>
                                </div></li>
                                @endforeach
                            @endif


                        </ul>
                       <div class="wrapper-pagination">
                            {{ $newsFeedPaginate->links('components.pagination') }}
                        </div>


                    </div>
                    <div class="col-12 col-md-4">

                        <div class="wrapper-right-text-info ads-banner"></div>
                        <div class="wrapper-right-text-info">

                            <div class="title bg-01"><p>Opportunities to Your Area</p></div>

                            <ul>
                                @foreach($nearestOpporData as $value)
                                    @if ($value['title'] !== '')
                                        <li><a href="{{url('organization/view_opportunity/'.$value['id'] )}}"><p>{{ ucwords($value['title']) }}</p></a></li>
                                    @endif
                                @endforeach

                            </ul>

                        </div>


                        <div class="wrapper-right-text-info">


                            <div class="title bg-02"><p>Just Joined</p></div>
                            <ul>
                                @foreach($lastOrgData as $orgData)
                                    @if ($lastOrgData[0]['org_name'] !='')
                                        <li>
                                        <a href="{{url('organization/profile/'.$orgData['id'] )}}" target="_blank"><p>{{ ucwords($orgData['org_name']) }}</p></a>
                                        </li>
                                    @endif
                                @endforeach

                        </div>


                    </div>

                </div>

            </div>


        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('js/jquery.bxslider-rahisified.js')}}"></script>
@endsection