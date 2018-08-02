<div class="wrapper-messages-box wrapper-account-setting-box">

    <div class="messages-list-outer">
        <div class="messages-list-inner">
            <ul>
                <li class="border-bottom-0 pb-0">
                    @if(Auth::user()->user_role === 'organization')
                    <div class="avatar" style="background-image:url('{{Auth::user()->logo_img == NULL ? asset('front-end/img/org/001.png') : asset('uploads') . '/'. Auth::user()->logo_img}}')"></div>
                    @else
                        <div class="avatar" style="background-image:url('{{Auth::user()->logo_img == NULL ? asset('img/logo/member-default-logo.png') : asset('uploads') . '/'. Auth::user()->logo_img}}')"></div>
                    @endif
                        <div>
                        <p class="name">
                            <span id="name_profile_user"class="name">{{Auth::user()->first_name ? Auth::user()->first_name .' '. Auth::user()->last_name : Auth::user()->org_name}}</span>
                        </p>
                        <p>
                            <a href="mailto:{{Auth::user()->email}}">{{Auth::user()->email}}</a>
                        </p>
                    </div>
                </li>
                <li>
                    <div class="pl-0">
                        <p class="text-center">
                            <a href="{{Auth::user()->user_role === 'organization' ? route('view-organization-profile') : route('view-voluntier-profile')}}" class="my_profile"><i class="fa fa-user"></i></span>My Profile</a></a>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="read-all">
        <a href="{{route('signout_user')}}" class="sign_out"><i class="fa fa-sign-out"></i> <span>Sign out</span></a>
    </div>

</div>