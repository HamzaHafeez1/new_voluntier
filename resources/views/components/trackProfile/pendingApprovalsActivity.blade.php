<table id="example21" class="table sortable footable " data-filter="#filter"
       data-page-size="10">
    <thead>
    <tr>
        <th>
            <div class="main-text"><p>Opportunity</p></div>
        </th>
        <th>
            <div class="main-text"><p>Worked Date</p></div>
        </th>
        <th>
            <div class="main-text"><p>Clock In</p></div>
        </th>
        <th>
            <div class="main-text"><p>Clock Out</p></div>
        </th>
        <th>
            <div class="main-text"><p>Mins</p></div>
        </th>
        <th>
            <div class="main-text"><p>Submitted Time</p></div>
        </th>
        <th>
            <div class="main-text"><p>Status</p></div>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($tracks as $tr)
        <tr>
            <td>
                @if(if_route_pattern('view-voluntier-profile'))
                    @if($tr->link !== 0)
                        @if($tr->oppor_id != 0)
                        <a href="{{url('/')}}/volunteer/view_opportunity/{{$tr->oppor_id}}">
                            @if($tr->opportunity->logo_img == null)
                                <div class="avatar"
                                     style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>
                            @else
                                <div class="avatar"
                                     style="background-image:url('<?=asset('uploads')?>/{{$tr->opportunity->logo_img}}')"></div>
                            @endif
                            <div class="main-text"><p>{{$tr->oppor_name}}</p></div>
                        </a>
                        @else
                            <div class="avatar"
                                 style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>
                            <div class="main-text"><p>{{$tr->oppor_name}}</p></div>
                        @endif
                    @else
                        <div class="avatar"
                             style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>
                        <div class="main-text"><p>{{$tr->oppor_name}}</p></div>
                    @endif
                @else
                    @if($tr->link != 0)
                        <a href="{{url('/')}}/volunteer/view_opportunity/{{$tr->oppor_id}}">

                            @if($tr->opp_logo == null)
                                <div class="avatar"
                                     style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>
                            @else
                                <div class="avatar"
                                     style="background-image:url('<?=asset('uploads')?>/{{$tr->opp_logo}}')"></div>
                            @endif
                            <div class="main-text"><p>{{$tr->oppor_name}}</p></div>
                        </a>
                    @else
                        <div class="avatar"
                             style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>
                        <div class="main-text"><p>{{$tr->oppor_name}}</p></div>
                    @endif
                @endif
            </td>
            <td data-dateformat="YYYY-MM-DD">
                <div class="main-text"><p class="light">{{$tr->logged_date}}</p></div>
            </td>
            <td>
                <div class="main-text"><p class="light">{{$tr->started_time}}</p></div>
            </td>
            <td>
                <div class="main-text"><p class="light">{{$tr->started_time}}</p></div>
            </td>
            <td>
                <div class="main-text"><p class="light">{{$tr->logged_mins}}</p></div>
            </td>
            <td data-dateformat="YYYY-MM-DD">
                <div class="main-text"><p class="light">{{$tr->updated_at}}</p></div>
            </td>
            <td>
                @if($tr->approv_status == 0)
                    <div class="main-text orange"><p class="text-center light">Pending</p>
                    </div>
                @elseif($tr->approv_status == 1)
                    <div class="main-text green"><p class="text-center light">Approved</p>
                    </div>
                @else
                    <div class="main-text red"><p class="text-center light">Declined</p>
                    </div>
                @endif
            </td>
        </tr>
    @endforeach


    </tbody>
    <tfoot>
    <tr>
        <td colspan="7" style="padding :20px 0 0">

        </td>
    </tr>
    </tfoot>
</table>

