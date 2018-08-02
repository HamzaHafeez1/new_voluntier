@extends('layout.frame')

@section('css')
    <style>
        .modal {
            position: absolute;
            overflow: visible;
        }
    </style>
@endsection
@section('body')
    <body>
    <div class="offcanvas-menu">
        <div class="container">

            <div class="wrapper-search">

                    <div class="form-group">
                        <div class="wrapper_input">
                            <input class="search-input-modal" type="input" placeholder="Search User/Org">
                        </div>
                    </div>

            </div>

            <div class="header-center-menu">

                <ul class="nav">
                    @include('components.auth.nav_bar')
                </ul>

            </div>

            @include('components.auth.header-right-menu')

        </div>
    </div>
    <div class="offcanvas-menu-backdrop"></div>

    <div class="offcanvas-contentarea">

        <div class="wrapper_bottom_footer">
            @include('components.auth.header')

            @if(!if_route_pattern('volunteer-opportunity') and !if_route_pattern('volunteer-opportunity-search') )
                <div class="row-content">
                    @endif
                    @yield('content')
                    @if(!if_route_pattern('volunteer-opportunity') and !if_route_pattern('volunteer-opportunity-search') )
                </div>
            @endif


        </div>
        <div class="row-footer">
            <div>
                @include('components.footer')
            </div>
        </div>


    </div>
    @include('components.shareYourProfile')
    @yield('modal');
    <script src="{{asset('front-end/js/jquery-3.3.1.slim.js')}}"></script>
    <script src="{{asset('front-end/js/popper.js')}}"></script>
    <script src="{{asset('front-end/js/select2.full.js')}}"></script>
    <script src="{{asset('js/jquery-2.1.1.js')}}"></script>
    <script src="{{asset('front-end/js/bootstrap.js')}}"></script>
    <script src="{{asset('front-end/js/jquery.bxslider-rahisified.js')}}"></script>
    <script src="{{asset('front-end/js/select2.full.js')}}"></script>
    <script src="{{asset('front-end/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('front-end/js/bootstrap-slider.js')}}"></script>
    <script src="{{asset('js/global.js')}}"></script>
    <script src="{{asset('js/check_validate.js') }}"></script>
    <script src="{{asset('front-end/js/bootstrap-sortable.js')}}"></script>

    <script>
        $('#close_share_profile_hide').on('click', function () {
            $('#myModal').modal('hide')
        });

        $('#share_profile').on('click', function () {
            var url = API_URL + 'share_profile';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })


            var emailsVal = $("#share_emails").val();


            // var checkEmail = emailsVal.replace(/^\s+|\s+$/g, '');

            var type = "POST";
            if ($("#share_emails").val() !== '') {
                console.log('15')
                $('.wrap_input_email').removeClass('has-error');
                $('.text-error').hide();

                var formData = {
                    emails: $("#share_emails").val(),
                    comments: $('#comments').val(),
                }

                $.ajax({
                    type: type,
                    url: url,
                    data: formData,

                    success: function (data) {
                        console.log('ok')
                        $('.success-first').show();
                        $('.hide-email-comment').hide()
                        $("#share_emails").val('');
                        $('#share_profile').hide()
                        $('#close_share_profile_hide').show()
                        $('#comments').val('');
                        $('.modal-content .modal-footer .wrapper-link')
                        $('.top-50').css('margin-top', '50px')
                    },

                    error: function (data) {
                        console.log('no')
                        $('.wrap_input_email').addClass('has-error');
                        $('.text-error').show();
                        console.log('Error:', data);
                    }
                });

            } else {
                $('.wrap_input_email').addClass('has-error');
                $('.text-error').show();
            }
        })


        function getMessages() {
            var url = API_URL + 'getMessages';
            var user_id = {{Auth::user()->id}};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log();

            var type = "post";
            var formData = {
                user_id: user_id,
            };

            $.ajax({
                type: type,
                url: url,
                data: formData,

                success: function (data) {

                    if (data.result.length > 0) {

                        $('.label-warning').show();
                        $('.label-warning').html(data.result.length);

                        $.each(data.result, function (index, value) {
                            var logo = SITE_URL + 'uploads/' + value.sender_logo;
                            if (value.sender_logo == null) {
                                if (value.sender_role == 'volunteer') {
                                    logo = SITE_URL + 'img/logo/member-default-logo.png';
                                } else {
                                    logo = SITE_URL + 'front-end/img/org/001.png';
                                }
                            }

                            /* var mydate5 = new Date(value.created_at);
                            var dtyu = mydate5.getMonth()+'-'+mydate5.getDay()+'-'+mydate5.getFullYear();
                            alert(dtyu); */

                            var content = value.content;

                            if (content.length > 25) {
                                content = content.slice(0, 25) + '...';
                            }

                            $('.dropdown-messages').append($('<li><div class="dropdown-messages-box"><a href="#" class="pull-left"><img alt="image" class="img-circle" src="' + logo + '"></a><a style="padding: 0"><div class="media-body"><strong>' + value.sender_name + '</strong><br> ' + content + ' <br><small class="text-muted">' + value.created_at + '</small></div></a></div></li><li class="divider"></li>'));

                        });

                        $('.dropdown-messages').append($('<li><div class="text-center link-block"><a href="{{Auth::user()->user_role === 'organization' ? route('organization-chat') : route('volunteer-chat')}}"><i class="fa fa-envelope"></i> <strong>Read All Messages</strong> <i class="fa fa-angle-right"></i></a></div></li>'));

                    }

                    else {
                        $('.label-warning').hide();
                        $('.dropdown-messages').append($('<li><div class="text-center link-block"><a href="{{Auth::user()->user_role === 'organization' ? route('organization-chat') : route('volunteer-chat')}}"><i class="fa fa-envelope"></i> <strong>Read All Messages</strong> <i class="fa fa-angle-right"></i></a></div></li>'));
                    }

                },

                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }


        function getAlert() {
            var url = API_URL + 'getAlert';
            var user_id = {{Auth::user()->id}};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var type = "post";
            var formData = {
                user_id: user_id,
            };


            $.ajax({
                type: type,
                url: url,
                data: formData,


                success: function (data) {
                    if (data.result != 0) {
                        $('.label-alert').show();
                        $('.label-alert').html(data.result);
                    }

                },

                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }


        $(document).ready(function () {

            var $outerwidth = $('.row-header header .outer-width-box');
            var $innerwidth = $('.row-header header .inner-width-box');

            function checkWidth() {

                var outersize = $outerwidth.width();
                var innersize = $innerwidth.width();

                if (innersize > outersize) {

                    $('body').addClass("navmobile");

                } else {

                    $('body').removeClass("navmobile");
                    $('body').removeClass("offcanvas-menu-show");

                }


            }

            checkWidth();
            $(window).resize(checkWidth);

            $('.offcanvas-menu-backdrop').on('click', function (e) {
                $('body').toggleClass("offcanvas-menu-show");
                e.preventDefault();
            });

            $('.wrapper_bottom_footer > .row-header-mobile header a.navtoggler').on('click', function (e) {
                $('body').toggleClass("offcanvas-menu-show");
                e.preventDefault();
            });

            $('.search-input-modal').on('keyup', function (e) {
                if (e.keyCode == 13) {

                    var keyword = $('.search-input-modal').val();
                    console.log(keyword)

                    if (keyword != '') {
                                @if(Auth::user()->user_role === 'organization')
                        var url = '{{route('organization-search')}}' + '?keyword=' + keyword;
                                @else
                        var url = '{{route('volunteer-search')}}' + '?keyword=' + keyword;
                        @endif


                        window.location.replace(url);

                    }

                    if (keyword == '' && filter != '') {
                                @if(Auth::user()->user_role === 'organization')
                        var url = '{{route('organization-search')}}' + '?keyword=' + filter.slice(0, -1);
                                @else
                        var url = '{{route('volunteer-search')}}' + '?filter=' + filter.slice(0, -1);
                        @endif



                        window.location.replace(url);

                    }

                    if (keyword == '' && filter == '') {
                        @if(Auth::user()->user_role === 'organization')
                        window.location.replace('{{route('organization-search')}}');
                        @else
                        window.location.replace('{{route('volunteer-search')}}');
                        @endif


                    }
                    console.log(keyword ,url)
                }
            })

        });

        $('body').on('click', '.share-profile-modal-send', function (e) {
            e.preventDefault();
            $('.wrap_input_email').removeClass('has-error');
            $('.text-error').hide();
            $('#myModal').modal('show');
        });

        getMessages();
        getAlert();

        setInterval(function () {

            //getMessages();
            getAlert()

        }, 5000);


        getAlert()

            $(document).ready(function() {
                $.get('<?php echo route( 'chat-token', [ 'uid' => Auth::user()->user_name ] )?>', function (token) {
                    chat.login(token, function (data) {
                        chat.getUser(data.uid, function (usr) {
                            user = usr.val();
                            if (user == null) {
                                user = chat.addUser('{{Auth::user()->first_name . ' ' . Auth::user()->last_name}}', '{{asset('uploads/' . Auth::user()->logo_img)}}', data.uid);
                            }
                            chat.getUserChats(user.Id, function (chats) {
                                chats = chats.val();
                                for(var type in chats) {
                                    for (var c in chats[type]) {
                                        chat.getUnreadCount(user.Id, c, function (unread) {
                                            unread = unread.val();
                                            //total_unread += unread.unread;
                                            if (unread != null && unread.unread > 0) {
                                                chat.getChatMessages(unread.chatId, function(messages){
                                                    messages = messages.val();
                                                    for(var mi in messages) {
                                                        var m = messages[mi];
                                                        if(typeof cid != 'undefined' && cid != null && m.chatId == cid.Id) continue;
                                                        if($('#unread_' + m.chatId).length > 0) continue;
                                                        var date = new Date(m.created);
                                                        var hours = date.getHours();
                                                        var ampm = 'AM';
                                                        var month = ['January', 'February', 'March', ' April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                        if (hours > 12) {
                                                            hours -= 12;
                                                            ampm = 'PM';
                                                        }
                                                        var base_path = "{{asset('uploads')}}/";
                                                        var date_formatted = date.getDate() + ' ' + month[date.getMonth()] + ' ' + hours + ':' + date.getMinutes() + ' ' + ampm;
                                                        var chatUsers = JSON.parse(window.sessionStorage.getItem('chatUsers'));
                                                        var photo = '';
                                                        if (chatUsers == null || typeof chatUsers[m.uid] == 'undefined') {
                                                            chat.getUser(m.uid, function (u) {
                                                                var chatUsers = JSON.parse(window.localStorage.getItem('chatUsers'));
                                                                if (chatUsers == null) chatUsers = {};
                                                                u = u.val();
                                                                chatUsers[u.Id] = u;
                                                                window.sessionStorage.setItem('chatUsers', JSON.stringify(chatUsers));
                                                                $('#unread_' + m.chatId + ' .avatar').css('background-image', "url('" + u.photo + "')");
                                                            });
                                                        }
                                                        else {
                                                            photo = chatUsers[m.uid].photo;
                                                        }
                                                        var link = '<?php echo route( Auth::user()->user_role . '-chat', [] )?>';
                                                        link += '?chatId=' + encodeURI(m.chatId);
                                                        var message = '<li id="unread_' + m.chatId + '" onclick="window.location.href=\'' + link + '\';">\
                                                        <div class="avatar" style="background-image:url(\'' + photo + '\')"></div>\
                                                        <div>\
                                                        <p class="name">\
                                                        <span>' + m.name + '</span>\
                                                    <span class="date">' + date_formatted + '</span>\
                                                    </p>\
                                                    <p>' + htmlEncode(m.message) + '</p>\
                                                    </div>\
                                                    </li>';
                                                        $('#unread-messages-list').append(message);
                                                        $('#unread-messages-list-mobile ul').append(message);
                                                        break;
                                                    }
                                                    if($('#unread-messages-list li').length > 0) {
                                                        $('#message-box .badge').text($('#unread-messages-list li').length);
                                                        $('#message-box .badge').show();
                                                        $('#message-box-mobile .badge').text($('#unread-messages-list-mobile li').length);
                                                        $('#message-box-mobile .badge').show();
                                                    }

                                                }, unread.unread);
                                            }
                                        });
                                    }
                                }
                            });
                        });
                    });
                });
            });
            function htmlEncode(value){
                return $('<div/>').text(value).html();
            }
        </script>

    @yield('script')

    </body>
@endsection