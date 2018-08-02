<li class="nav-item {{ active_class(if_route_pattern('home')) }}">
    <a class="nav-link" href="{{route('home')}}"><span>Home</span></a>
</li>
<li class="nav-item {{ active_class(if_route_pattern('features')) }}">
    <a class="nav-link" href="{{route('features')}}"><span>Features</span></a>
</li>
<li class="nav-item {{ active_class(if_route_pattern('request')) }}">
    <a class="nav-link" href="{{route('request')}}"><span>Request A Demo</span></a>
</li>
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