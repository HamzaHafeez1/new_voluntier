<div class="row-header">


    <header>
        <div class="container">

            <div class="outer-width-box">
                <div class="inner-width-box">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col col-auto">

                            <div class="header-logo"><a href="{{ route('home') }}"><img src="{{ asset('front-end/img/logo.jpg') }}" width="226" height="38" alt=""></a></div>

                        </div>
                        <div class="col">

                            <div class="header-center-menu">

                                <ul class="nav flex-nowrap">

                                    @include('components.auth.nav_bar')

                                </ul>

                            </div>

                        </div>
                        <div class="col col-auto">

                            <div class="header-right-menu">

                                <ul class="nav flex-nowrap">
                                    @if(Auth::user()->user_role === 'organization')
                                        <li class="nav-item {{ active_class(if_route_pattern('organization-search')) }}">
                                    @else
                                        <li class="nav-item {{ active_class(if_route_pattern('volunteer-search')) }}">
                                    @endif
                                        <a class="nav-link"  href="{{ Auth::user()->user_role === 'organization' ? route('organization-search') : route('volunteer-search') }}">
                                            <span class="gl-icon-search"></span>
                                            <span class="text">Search User/Org</span>
                                        </a>
                                    </li>

                                    <li class="nav-item dropdown {{ active_class((if_route_pattern('view-organization-profile') and (if_route_param('id', null) or if_route_param('id', Auth::id()))) | (if_route_pattern('view-voluntier-profile') and (if_route_param('id', null) or if_route_param('id', Auth::id()) ))) }}">
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ Auth::user()->user_role === 'organization' ? route('view-organization-profile'): route('view-voluntier-profile') }}" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="gl-icon-person"></span>
                                            <span class="text">Account Setting</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">

                                           @include('components.messagesListOuter')


                                        </div>
                                    </li>


                                    @if(Auth::user()->user_role === 'organization')
                                        <li class="nav-item {{active_class(if_route_pattern('organization-opportunity-post'))}}">
                                            <a class="nav-link" href="{{route('organization-opportunity-post')}}">
                                                <span class="gl-icon-clock"></span>
                                                <span class="text">Add Hours</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="nav-item {{active_class(if_route_pattern('volunteer-single_track'))}}">
                                            <a class="nav-link" href="{{route('volunteer-single_track')}}">
                                                <span class="gl-icon-clock"></span>
                                                <span class="text">Add Hours</span>
                                            </a>
                                        </li>
                                    @endif

                                    <li class="nav-item share-profile-modal-send">
                                        <a class="nav-link" href="#">
                                            <span class="gl-icon-sharing"></span>
                                            <span class="text">Share Profile</span>
                                        </a>
                                    </li>





                                    <li class="nav-item dropdown" id="message-box">
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="gl-icon-envelope"></span>
                                            <span class="text">Messages Box</span>
                                            <span class="badge label-warning"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            <div class="wrapper-messages-box">

                                                <div class="messages-list-outer">
                                                    <div class="messages-list-inner">
                                                        <ul id="unread-messages-list">

                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="read-all">
                                                    <a href="<?php echo route( Auth::user()->user_role . '-chat', [] )?>"><span>Read All Messages</span></a>
                                                </div>

                                            </div>


                                        </div>
                                    </li>


                                    <li class="nav-item dropdown {{active_class(if_route_pattern('view-alert')) }}">
                                        <a class="nav-link dropdown-toggle" href="{{route('view-alert')}}" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="gl-icon-bell"></span>
                                            <span class="text">Alerts</span>
                                            <span class="badge label-alert"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                    </li>
                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>


</div>

<div class="row-header-mobile">

    <header>
        <div class="container">

            <div class="outer-width-box">
                <div class="inner-width-box">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col col-auto">

                            <a href="#" class="navtoggler"><span>Menu</span></a>

                        </div>
                        <div class="col">

                            <div class="header-logo"><a href="{{ route('home') }}"><img src="{{ asset('front-end/img/logo.jpg') }}" width="226" height="38" alt=""></a></div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>

</div>
<script src="//www.gstatic.com/firebasejs/4.13.0/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyB-dJAxQJ1K4XG38bV9q-_H3grri86_mz4",
        authDomain: "myvoluntierproject-cd034.firebaseapp.com",
        databaseURL: "https://myvoluntierproject-cd034.firebaseio.com",
        projectId: "myvoluntierproject-cd034",
        storageBucket: "",
        messagingSenderId: "632239583862"
    };
    firebase.initializeApp(config);
    var user = {};
    var cid;
    var current = null;
    var total_unread = 0;
</script>

<script src="/js/firebase-chat.js"></script>
