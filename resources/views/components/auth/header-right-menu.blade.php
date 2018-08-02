<div class="header-right-menu">

    <ul class="nav">
        <li class="nav-item dropdown {{ active_class(if_route_pattern('view-organization-profile') | if_route_pattern('view-voluntier-profile')) }}">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="{{ Auth::user()->user_role === 'organization' ? route('view-organization-profile'): route('view-voluntier-profile') }}" role="button" aria-haspopup="true"
               aria-expanded="false">
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
                    <span class="text">Post Opportunity</span>
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

        <li class="nav-item dropdown" id="message-box-mobile">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="gl-icon-envelope"></span>
                <span class="text">Messages Box</span>
                <span class="badge label-warning"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <div class="wrapper-messages-box">

                    <div class="messages-list-outer">
                        <div class="messages-list-inner" id="unread-messages-list-mobile">
                            <ul>
                            </ul>
                        </div>
                    </div>

                    <div class="read-all">
                        <a href="{{Auth::user()->user_role === 'organization' ? route('organization-chat') : route('volunteer-chat')}}"><span>Read All Messages</span></a>
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
