
    <div class="wrapper-friends">


        <div class="wrapper-friends-list pb-0">

            <div class="main-text">
                <p class="title">Organization Members</p>
            </div>


            <div class="wrapper-sort-table">
                <div>

                    <table id="example21" class="table sortable member-table">
                        <thead>
                        <tr>
                            <th>
                                <div class="main-text"><p>Member Name</p></div>
                            </th>
                            <th>
                                <div class="main-text"><p>Gender</p></div>
                            </th>
                            <th>
                                <div class="main-text"><p>Zipcode</p></div>
                            </th>
                            <th>
                                <div class="main-text"><p>Email</p></div>
                            </th>
                            <th>
                                <div class="main-text"><p>Phone</p></div>
                            </th>
                            <th>
                                <div class="main-text"><p>Rating</p></div>
                            </th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($members as $f)

                            <tr>

                                <td>
                                    @if($f->logo_img == null)

                                        <div class="avatar"
                                             style="background-image:url('{{url('/img/logo/member-default-logo.png')}}')"></div>

                                    @else

                                        <div class="avatar"
                                             style="background-image:url('{{url('/uploads')}}/{{$f->logo_img}}')"></div>

                                    @endif

                                    <div class="main-text"><p><a
                                                    href="{{$f->user_role === 'organization' ? route('view-organization-profile', [$f->user_id]) : route('view-voluntier-profile', [$f->user_id]) }}">{{$f->first_name}} {{$f->last_name}}</a>
                                        </p></div>
                                </td>


                                <td>
                                    <div class="main-text"><p class="light">{{$f->gender}}</p></div>
                                </td>


                                <td>
                                    <div class="main-text"><p class="light">{{$f->zipcode}}</p></div>
                                </td>


                                <td>
                                    <div class="main-text"><p class="light">{{$f->email}}</p></div>
                                </td>


                                <td>
                                    <div class="main-text"><p class="light">{{$f->contact_number}}</p></div>
                                </td>


                                <td class="text-center">
                                    <div class="main-text">
                                        <p>{{(property_exists($f, 'mark') and $f->mark != null) ? $f->mark : 0}}</p>
                                    </div>
                                </td>


                            </tr>

                        @endforeach


                        </tbody>
                    </table>

                </div>
            </div>


        </div>


    </div>

