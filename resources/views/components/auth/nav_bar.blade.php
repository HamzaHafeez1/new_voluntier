@if(Auth::user()->org_type === null)
    <li class="nav-item {{ active_class(if_route_pattern('home-volunteer')) }}">
        <a class="nav-link active" href="{{route('home-volunteer')}}"><span>Home</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('volunteer-opportunity')) }}">
        <a class="nav-link" href="{{route('volunteer-opportunity')}}"><span>Opportunities</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('volunteer-track')) }}">
        <a class="nav-link" href="{{route('volunteer-track')}}"><span>Track</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('volunteer-friend')) }}">
        <a class="nav-link" href="{{route('volunteer-friend')}}"><span>Friends</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('volunteer-impact')) }}">
        <a class="nav-link" href="{{route('volunteer-impact')}}"><span>Impact</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('volunteer-group')) }}">
        <a class="nav-link" href="{{route('volunteer-group')}}"><span>Groups</span></a>
    </li>
@else
    <li class="nav-item {{ active_class(if_route_pattern('home-organization')) }}">
        <a class="nav-link active" href="{{route('home-organization')}}"><span>Home</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('organization-opportunity')) }}">
        <a class="nav-link" href="{{route('organization-opportunity')}}"><span>Opportunities</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('organization-track')) }}">
        <a class="nav-link" href="{{route('organization-track')}}"><span>Track</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('organization-friend')) }}">
        <a class="nav-link" href="{{route('organization-friend')}}"><span>Friends</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('organization-impact')) }}">
        <a class="nav-link" href="{{route('organization-impact')}}"><span>Impact</span></a>
    </li>
    <li class="nav-item {{ active_class(if_route_pattern('organization-group')) }}">
        <a class="nav-link" href="{{route('organization-group')}}"><span>Groups</span></a>
    </li>
@endif
