@if(Auth::check())
    @if(Auth::user()->user_role == 'volunteer')
        <li {{ active_class(if_route_pattern('home-volunteer')) }}>
            <a class="page-scroll" href="{{route('home-volunteer')}}">Dashboard</a>
        </li>
    @else
        <li {{ active_class(if_route_pattern('home-organization')) }}>
            <a class="page-scroll" href="{{route('home-organization')}}">Dashboard</a>
        </li>
    @endif
@endif
<li class="nav-item {{ active_class(if_route_pattern('features')) }}">
    <a class="nav-link" href="{{route('features')}}"><span>Features</span></a>
</li>
@if(!Auth::check())
    <li class="nav-item">
        <a data-toggle="modal" data-target="#login_dig" class="nav-link" id="login_button" href="#"><span>Sign In</span></a>
    </li>
@else
    <li class="nav-item">
        <a class="page-scroll" href="{{route('signout_user')}}"><span>Log Out</span></a>
    </li>
@endif