@extends('layout.masterForAuthUser')



@section('css')
    <style>
        a {
            text-decoration: none !important;
        }
        .pagination .flex-wrap .justify-content-center{
            margin: 0;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            padding: 0;
        }

        .footable-page-arrow, .footable-page{
            display: list-item;
            text-align: -webkit-match-parent;
        }

        .footable-page-arrow a, .footable-page a{
            position: relative;
            display: block;
            padding: 10px;
            margin: 10px 5px;
            font-size: 16px;
            line-height: 20px;
            font-family: 'Open Sans',sans-serif;
            color: #5f5f5f;
            background: none;
            border: 0 none;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            text-decoration: none;
            cursor: auto;
            outline: none;
            z-index: auto;
        }

        .footable-page-arrow a:hover, .footable-page a:hover{
            z-index: auto;
            color: #fff;
            text-decoration: none;
            background-color: #38b348;
            border: 0 none;
        }

        .footable-page-arrow a[data-page=prev], .footable-page-arrow a[data-page=next], .footable-page-arrow.disabled{
            display: none;
        }

        .footable-page.active a{
            z-index: auto;
            color: #fff;
            text-decoration: none;
            background-color: #38b348;
            border: 0 none;
        }
    </style>


@endsection



@section('content')


    <div class="wrapper-friends">


        <div class="search-friends">
            <div class="container">


                <div class="search">
                    <label><span class="gl-icon-search"></span></label>
                    <input class="search-input" type="text" placeholder="Type and Press Search" value="{{$keyword}}">
                </div>

            </div>
        </div>

        <div class="search-checkbox-list">
            <div class="container">


                <div class="wrapper-checkbox filter"><label>
                        <input class="filter" type="checkbox" name="vol" id="vol"
                               value="v" {{ (in_array('v', $filter))?"checked" : '' }}>
                        <i></i>
                        <span class="label-checkbox-text">Volunteer</span>
                    </label></div>
                <div class="wrapper-checkbox filter"><label>
                        <input class="filter" type="checkbox" name="grp" id="grp"
                               value="g" {{ (in_array('g', $filter))?"checked" : '' }}>
                        <i></i>
                        <span class="label-checkbox-text">Group</span>
                    </label></div>
                <div class="wrapper-checkbox filter"><label>
                        <input class="filter" type="checkbox" name="org" id="org"
                               value="r" {{ (in_array('r', $filter))?"checked" : '' }}>
                        <i></i>
                        <span class="label-checkbox-text">Organization</span>
                    </label></div>
                <div class="wrapper-checkbox filter"><label>
                        <input class="filter" type="checkbox" name="opp" id="opp"
                               value="p" {{ (in_array('p', $filter))?"checked" : '' }}>
                        <i></i>
                        <span class="label-checkbox-text">Opportunities</span>
                    </label></div>


            </div>
        </div>


        <div class="wrapper-friends-list">
            <div class="container">

                <div class="main-text search-result">
                    <h2 class="h2">Search result</h2>
                </div>


                <div class="wrapper-sort-table">
                    <div>
                        <button type="button" id="btn_search_page" class="btn btn-primary" style="display:none"
                        ></button>

                        <table id="example" class="table sortable search-table" data-paging="true" data-paging-limit="5">


                            @if(count($result)<1)

                                <thead><tr>
                                    <th></th></tr></thead>
                                <tbody>
                                <tr>

                                    <td>Search result does not exist...</td>

                                </tr>

                            @else
                                <thead><tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th></tr></thead>
                                <tbody>
                                @foreach($result as $r)
                                    <tr id="tr{{$r['id']}}">
                                        <td>
                                            <?php

                                            if ($r['logo_img'] == null) {


                                                //dd($r);die();

                                                $profile_pics = asset('front-end/img/org/001.png');

                                                if (($r['user_role'] == 'organization') || ($r['user_role'] == 'groups') || ($r['user_role'] == 'opportunity')) {

                                                    $profile_pics = asset('front-end/img/org/001.png');

                                                }
                                                if ($r['user_role'] == 'volunteer') {

                                                    $profile_pics = asset('img/logo/member-default-logo.png');

                                                }


                                            } else {

                                                if ($r['user_role'] == 'group') {

                                                    $profile_pics = asset('uploads/volunteer_group_logo/thumb') . '/' . $r['logo_img'];

                                                } else {

                                                    $profile_pics = asset('uploads') . '/' . $r['logo_img'];

                                                }


                                            }

                                            ?>

                                            @if($r['user_role'] == 'organization')

                                                <a href="{{url('/')}}/{{Auth::user()->user_role === 'organization' ? 'organization'  : 'organization'}}/profile/{{$r['id']}}"
                                                   target="_blank">


                                                    @elseif($r['user_role'] == 'volunteer')

                                                        <a href="{{url('/')}}/{{Auth::user()->user_role === 'organization' ? 'organization'  : 'volunteer'}}/profile/{{$r['id']}}"
                                                           target="_blank">


                                                            @elseif($r['user_role'] == 'group')

                                                                <?php

                                                                $encoded_id = base64_encode($r['id']);

                                                                ?>

                                                                <a href="{{url('/')}}/sharegroup/{{$encoded_id}}"
                                                                   target="_blank">


                                                                    @elseif($r['user_role'] == 'opportunity')
                                                                        <a href="{{url('/')}}/{{Auth::user()->user_role === 'organization' ? 'organization'  : 'volunteer'}}/view_opportunity/{{$r['id']}}"
                                                                           target="_blank">


                                                                            @endif
                                                                            <div class="avatar"
                                                                                 style="background-image:url('{{$profile_pics}}')"></div>
                                                                            <div class="main-text"><p>{{$r['name']}}</p>
                                                                            </div>
                                                                        </a>
                                        </td>


                                        <td>

                                            <div class="main-text"><p class="light">{{$r['user_role']}}</p></div>

                                        </td>
                                        <td>

                                            <div class="main-text"><p
                                                        class="light">{{ implode(', ', array_filter([$r['city'], $r['state'], $r['country']  ] )  )}}</p>
                                            </div>

                                        </td>

                                        <td class="text-center">

                                            @if($r['user_role'] == 'opportunity')

                                            @elseif($r['user_role'] != 'group')
                                                @if($r['is_friend'] == 0)

                                                    <a href="#"
                                                       class="action btn-action-connect"><span>connect</span></a>
                                                    <span style="display: none"
                                                          class="pending btn-action-connect-pending"><span>pending&hellip;</span></span>
                                                @elseif($r['is_friend'] == 1)
                                                    <span class="pending"><span>pending&hellip;</span></span>
                                                @endif

                                            @elseif($r['user_role'] == 'group')

                                                @if($r['is_friend']==1)

                                                    <div class="main-text"><p class="joined">Already Joined</p></div>

                                                @else
                                                    <a href="#" class="action btn-action-join"
                                                       data-id="{{$r['group_id']}}"><span>Join</span></a>

                                                @endif
                                            @endif
                                                @if(($r['user_role'] == 'volunteer' or $r['user_role'] == 'organization') && $r['is_friend']==2)
                                                    <div class="main-text"><p class="joined">Already Joined</p></div>

                                                    @endif

                                        </td>

                                        <td><input class="current-id" type="hidden" value="{{$r['id']}}"></td>


                                    </tr>
                                @endforeach
                            @endif


                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection



@section('script')

    <script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script>
    <script src="//cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>




    <script>
        function resetadd() {
            $("#content_error").hide();
            var fm = document.getElementById('addFormSendMessage');
            fm.reset();
        }

        function contectval(val) {
            if (val.search(/\S/) == -1) {
                $("#content_error").show();
                $("#content_error").html("Please enter message");
            }
            else {
                $("#content_error").hide();
            }
        }

        function submitMessage() {
            var content = $("#content").val();
            if (content == '') {
                document.getElementById('content').style.border = '1px solid red !important';
                $("#content_error").css("display", "block");
                document.getElementById("content_error").innerHTML = "Please enter message";
                document.getElementById('content').focus();
                return false
            } else {
                $("#content_error").css("display", "none");
                document.getElementById('content').style.border = '';
                document.getElementById("content_error").innerHTML = "";
            }


            $("#addFormSendMessage").unbind('submit').submit(function (event) {
                event.preventDefault();
                document.getElementById('checkoutloading').style.display = '';
                var formData12 = new FormData($(this)[0]);
                $.ajax({
                    url: API_URL + "{{Auth::user()->user_role === 'organization' ? 'organization'  : 'volunteer'}}/sendmessage",
                    type: 'POST',
                    data: formData12,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (return_data) {
                        document.getElementById('checkoutloading').style.display = 'none';
                        var result = $.parseJSON(return_data);
                        if (result.status == 1) {

                            $(".resultupdatemsg").css("display", "block");

                            $(".resultupdatemsg").removeClass("alert-danger");

                            $(".resultupdatemsg").addClass("alert-success");

                            $(".resultupdatemsg").html(result.msg);

                            setTimeout(function () {
                                $("#content").val('');
                                $('.resultupdatemsg').fadeOut('fast');
                                $("#add_message").modal('hide');
                            }, 2000);

                        } else {

                            $(".resultupdatemsg").css("display", "block");

                            $(".resultupdatemsg").removeClass("alert-success");

                            $(".resultupdatemsg").addClass("alert-danger");

                            $(".resultupdatemsg").html(result.msg);

                            setTimeout(function () {

                                $('.resultupdatemsg').fadeOut('fast');

                            }, 2000);

                        }

                    },
                    error: function (html) {
                        alert(return_data);
                    }
                });
            });
        }

        $(document).ready(function () {

            $('.search-table').dataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": true,
                "pageLength": 10,
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "",
                        "next": '',
                        "previous": '',
                        "last": ''
                    }
                }
            });

            /*$('.search-table').footable({
                "paging": {
                    "limit": 3
                }
            });*/
            /*$('ul.pagination').each(function(){
                if (Math.abs((parseInt($(this).find('.footable-page:last a').data('page')) + 1) - parseInt($(this).find('.footable-page-arrow:last a').text())) < 0.01) $(this).find('.footable-page-arrow:last').hide();
                else $(this).find(' .footable-page-arrow:last').show();
            });

            $('.pagination').on('click', 'li a[data-page]', function () { //, .footable-page-arrow
                var pagination = $(this).parents('.tab-pane.active .pagination');
                if (pagination.find('.footable-page:first a').data('page') == 0) pagination.find('.footable-page-arrow:first').hide();
                else pagination.find('.footable-page-arrow:first').show();
                if (Math.abs((parseInt(pagination.find('.footable-page:last a').data('page')) + 1) - parseInt(pagination.find('.footable-page-arrow:last a').text())) < 0.01) pagination.find('.footable-page-arrow:last').hide();
                else pagination.find('.footable-page-arrow:last').show();
            });*/


            $('.search-input').on('keyup', function (e) {
                if (e.keyCode == 13) {
                    $('#btn_search_page').trigger('click');
                }
            })


            $('.filter').on('click', function () {
                console.log('change')
                $('#btn_search_page').trigger('click');

            });

        });


        $('#btn_search_page').on('click', function (e) {

            var keyword = $('.search-input').val();
            console.log(keyword)


            var filter = '';

            $('.filter').each(function () {

                if ($(this).is(':checked')) {

                    filter += $(this).val() + '+';

                }

            });

            if (keyword != '') {
                @if(Auth::user()->user_role === 'organization')
                    var url = SITE_URL + 'organization/search?keyword=' + keyword;
                @else
                    var url = SITE_URL + 'volunteer/search?keyword=' + keyword;
                @endif
                if (filter != '') {

                    url += '&filter=' + filter.slice(0, -1);

                }

                window.location.replace(url);

            }

            if (keyword == '' && filter != '') {
                        @if(Auth::user()->user_role === 'organization')
                             var url = SITE_URL + 'organization/search?filter=' + filter.slice(0, -1);
                        @else
                            var url = SITE_URL + 'volunteer/search?filter=' + filter.slice(0, -1);
                        @endif



                window.location.replace(url);

            }

            if (keyword == '' && filter == '') {
                @if(Auth::user()->user_role === 'organization')
                    window.location.replace(SITE_URL + 'organization/search');
                @else
                    window.location.replace(SITE_URL + 'volunteer/search');
                @endif


            }
        });


        $('#search_box_page').keyup(function (e) {

            var keyword = $('#search_box_page').val();

            if (e.keyCode == 13) {

                if (keyword != '') {
                    @if(Auth::user()->user_role === 'organization')
                         var url = SITE_URL + 'organization/search?keyword=' + keyword;
                    @else
                         var url = SITE_URL + 'volunteer/search?keyword=' + keyword;
                    @endif


                    window.location.replace(url);

                }

            }

        });


        $('.btn-action-follow').on('click', function () {
                    @if(Auth::user()->user_role === 'organization')
                        var url = API_URL + 'organization/followOrganization';
                    @else
                        var url = API_URL + 'volunteer/followOrganization';
                    @endif

            var id = $(this).parent().parent().find('.current-id').val();

            var current_button = $(this);

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


            console.log();

            var type = "POST";

            var formData = {

                id: id

            }

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {

                    current_button.hide();

                    current_button.parent().find('.btn-action-unfollow').show();

                },

                error: function (data) {

                    $('.login-first').show();

                    console.log('Error:', data);

                }

            });

        });


        $('.btn-action-unfollow').on('click', function () {
                    @if(Auth::user()->user_role === 'organization')
                        var url = API_URL + 'organization/unfollowOrganization';
                    @else
                        var url = API_URL + 'volunteer/unfollowOrganization';
                    @endif


            var id = $(this).parent().parent().find('.current-id').val();

            var current_button = $(this);

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


            console.log();

            var type = "POST";

            var formData = {

                id: id

            }

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {

                    current_button.hide();

                    current_button.parent().find('.btn-action-follow').show();

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        });


        $('.btn-action-connect').on('click', function () {
                    @if(Auth::user()->user_role === 'organization')
                        var url = API_URL + 'organization/connectOrganization';
                    @else
                        var url = API_URL + 'volunteer/connectOrganization';
                    @endif


            var id = $(this).parent().parent().find('.current-id').val();

            var current_button = $(this);

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


            console.log();

            var type = "POST";

            var formData = {

                id: id

            }

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {

                    current_button.hide();

                    current_button.parent().find('.btn-action-connect-pending').show();

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        });

        $('.btn-action-join').click(function () {
                    @if(Auth::user()->user_role === 'organization')
                        var url = API_URL + 'organization/joinGroup';
                    @else
                         var url = API_URL + 'volunteer/joinGroup';
                    @endif

            var group_id = $(this).data('id');

            var this1 = $(this);

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


            console.log();

            var type = "POST";

            var formData = {

                group_id: group_id

            }

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {

                    this1.parent().html('<p class="form-control-static">Joined</p>');

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        })

    </script>

@endsection

