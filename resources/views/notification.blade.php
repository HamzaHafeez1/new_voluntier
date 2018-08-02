@extends('layout.masterForAuthUser')

@section('css')
<style>
    .main-text a{
        text-decoration: none;
    }
</style>
@endsection

@section('content')
    <div class="dashboard_org">

        <div class="container">

            <div class="news-followed-box mt25">


                <div class="main-text"><h2 class="h2">Notifications</h2></div>


                <ul class="notifications-list">


                    @foreach($alert as $a)
                        <li>

                            <div class="row flex-container-1">

                                @if($a['alert_type'] == \App\Alert::ALERT_JOIN_OPPORTUNITY || $a['alert_type'] == \App\Alert::ALERT_CREATE_PRIVATE_OPPORTUNITY || $a['alert_type'] == \App\Alert::ALERT_FOLLOW || $a['alert_type'] == \App\Alert::ALERT_ACCEPT || $a['alert_type'] == \App\Alert::ALERT_DECLINE)

                                    @if($a['sender_type']=='organization')
                                        <div class="col col-auto flex-item-1">
                                            @if($a['sender_logo'] == null)

                                                <div class="avatar" style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>

                                            @else

                                                <div class="avatar" style="background-image:url('{{url('/uploads')}}/{{$a['sender_logo']}}')"></div>

                                            @endif
                                        </div>
                                    @elseif($a['sender_type']=='volunteer')
                                        <div class="col col-auto flex-item-1">
                                            @if($a['sender_logo']==null)

                                                <div class="avatar" style="background-image:url('{{asset('img/logo/member-default-logo.png')}}')"></div>

                                            @else

                                                <div class="avatar" style="background-image:url('{{url('/uploads')}}/{{$a['sender_logo']}}')"></div>

                                            @endif
                                        </div>
                                    @endif

                                        <div class="col flex-item-1">

                                            <div class="row flex-container-2">
                                                <div class="col flex-item-2">

                                                    <div class="main-text">
                                                        <a href=" {{url('/organization/profile')}}/{{$a['sender_id']}}">
                                                        <p class="name">

                                                        @if($a['alert_type'] != \App\Alert::ALERT_JOIN_OPPORTUNITY and $a['alert_type'] != \App\Alert::ALERT_CREATE_PRIVATE_OPPORTUNITY)
                                                            {{$a['sender_name']}}
                                                        @endif
                                                            {{$a['contents']}}
                                                        </p>
                                                        </a>
                                                        <p class="light">{{$a['sender_type']}}</p>
                                                    </div>

                                                </div>
                                                <div class="col col-auto flex-item-2">
                                                    <div class="main-text text-center">
                                                        <p class="date">{{$a['date']}}</p>
                                                    </div>
                                                </div>
                                                <div class="col col-auto flex-item-2">
                                                    <div class="main-text text-center">
                                                        <input type="hidden" class="sender_id" value="{{$a['sender_id']}}">

                                                        <input type="hidden" class="alert_type" value="{{$a['alert_type']}}">

                                                     @if($a['alert_type'] == \App\Alert::ALERT_CONNECT_CONFIRM_REQUEST)

                                                        @if($a['status'] == 0)
``
                                                           <a href="#" class="btn-accept"><span>Accept</span></a>
                                                           <p  style="display: none" class="approved"><i class="fa fa-check-square-o"></i> This request is approved.</p>

                                                        @else

                                                            <p class="approved" style="display: block"><i class="fa fa-check-square-o"></i> This request is approved.</p>

                                                        @endif

                                                    @elseif($a['alert_type'] == \App\Alert::ALERT_TRACK_CONFIRM_REQUEST)

                                                        @if($a['status'] == 0)

                                                                <a href="{{url('/organization/track')}}" class="process"><span>Process</span></a>

                                                        @else

                                                                <p class="approved">This request is approved</p>

                                                        @endif

                                                    @elseif($a['alert_type'] == \App\Alert::ALERT_GROUP_INVITATION)

                                                        @if($a['is_apporved'] == 0)

                                                            <a href="{{url('/volunteer/approve/'.$a['related_id'].'/2')}}" type="button" class="btn btn-primary" style="color: white" onclick="return confirm('Are you sure ?');">Approve</a>

                                                            <a href="{{url('/volunteer/approve/'.$a['related_id'].'/0')}}" type="button" class="btn btn-primary" style="color: white" onclick="return confirm('Are you sure ?');">Decline</a>


                                                        @else

                                                                <p class="approved">This request is approved</p>

                                                        @endif

                                                        @endif
                                                    </div>
                                                </div>





                                            </div>

                                        </div>
                                @elseif($a['alert_type'] == \App\Alert::ALERT_CONNECT_CONFIRM_REQUEST || $a['alert_type'] == \App\Alert::ALERT_TRACK_CONFIRM_REQUEST  || $a['alert_type'] == \App\Alert::ALERT_GROUP_INVITATION)
                                    @if($a['sender_type']=='organization')
                                        <div class="col col-auto flex-item-1">
                                            @if($a['sender_logo'] == null)

                                                <div class="avatar" style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>

                                            @else

                                                <div class="avatar" style="background-image:url('{{url('/uploads')}}/{{$a['sender_logo']}}')"></div>

                                            @endif
                                        </div>
                                    @elseif($a['sender_type']=='volunteer')
                                        <div class="col col-auto flex-item-1">
                                            @if($a['sender_logo']==null)

                                                <div class="avatar" style="background-image:url('{{asset('img/logo/member-default-logo.png')}}')"></div>

                                            @else

                                                <div class="avatar" style="background-image:url('{{url('/uploads')}}/{{$a['sender_logo']}}')"></div>

                                            @endif
                                        </div>
                                    @endif

                                    <div class="col flex-item-1">

                                        <div class="row flex-container-2">
                                            <div class="col flex-item-2">

                                                <div class="main-text">
                                                    <a href=" {{url('/organization/profile')}}/{{$a['sender_id']}}">
                                                        <p class="name">

                                                            @if($a['alert_type'] != \App\Alert::ALERT_JOIN_OPPORTUNITY and $a['alert_type'] != \App\Alert::ALERT_CREATE_PRIVATE_OPPORTUNITY)
                                                                {{$a['sender_name']}}
                                                            @endif
                                                            {{$a['contents']}}
                                                        </p>
                                                    </a>
                                                    <p class="light">{{$a['sender_type']}}</p>
                                                </div>

                                            </div>
                                            <div class="col col-auto flex-item-2">
                                                <div class="main-text text-center">
                                                    <p class="date">{{$a['date']}}</p>
                                                </div>
                                            </div>
                                            <div class="col col-auto flex-item-2">
                                                <div class="main-text text-center">
                                                    <input type="hidden" class="sender_id" value="{{$a['sender_id']}}">

                                                    <input type="hidden" class="alert_type" value="{{$a['alert_type']}}">
                                                    @if($a['alert_type'] == \App\Alert::ALERT_CONNECT_CONFIRM_REQUEST)

                                                        @if($a['status'] == 0)
                                                            <a href="#" class="process btn-accept"><span>Accept</span></a>
                                                            <p style="display: none" class="approved"><i class="fa fa-check-square-o"></i> This request is approved.</p>
                                                        @else
                                                            <p class="approved" style="display: block"><i class="fa fa-check-square-o"></i> This request is approved.</p>
                                                        @endif

                                                    @elseif($a['alert_type'] == \App\Alert::ALERT_TRACK_CONFIRM_REQUEST)

                                                        @if($a['status'] == 0)
                                                            <a href="{{url('/organization/track')}}" class="process"><span>Process</span></a>
                                                        @else
                                                            <p class="approved">This request is approved</p>
                                                        @endif

                                                    @elseif($a['alert_type'] == \App\Alert::ALERT_GROUP_INVITATION)

                                                        @if($a['is_apporved'] == 0)
                                                            <a href="{{url('/volunteer/approve/'.$a['related_id'].'/2')}}" class="process" onclick="return confirm('Are you sure ?');"><span>Approve</span></a>
                                                            <a href="{{url('/volunteer/approve/'.$a['related_id'].'/0')}}" class="process" onclick="return confirm('Are you sure ?');"><span>Decline</span></a>
                                                        @elseif($a['is_apporved'] == 1)
                                                            <p class="approved">This request is approved</p>
                                                        @else
                                                            <p class="approved">This request is declined</p>
                                                        @endif

                                                    @endif
                                                </div>
                                            </div>





                                        </div>

                                    </div>

                                @endif

                            </div>
                        </li>
                    @endforeach
                    <li>



                </ul>


                <div class="wrapper-pagination">

                    {{ $paginate->links('components.pagination') }}

                </div>


            </div>


        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.btn-accept').on('click',function () {

            var current_button = $(this);

            var sender_id = $(this).parent().find('.sender_id').val();

            var alert_type = $(this).parent().find('.alert_type').val();
            console.log(sender_id, alert_type)

            if(alert_type == 3){

                var url = '{{Auth::user()->user_role == 'organization' ? route('organization-accept-friend') : route('volunteer-accept-friend') }}';

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });



                console.log();

                var type = "POST";

                var formData = {

                    id: sender_id

                }

                $.ajax({

                    type: type,

                    url: url,

                    data: formData,

                    success: function (data) {

                        current_button.hide();

                        current_button.parent().find('.approved').show();

                    },

                    error: function (data) {

                        console.log('Error:', data);

                    }

                });

            }

        })
    </script>
@endsection