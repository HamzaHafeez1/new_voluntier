@extends('layout.masterForAuthUser')

@section('css')
    <style>

        .wrapper-sort-table .table tr td:first-child {
            white-space: normal !important;
            word-wrap: break-word !important;
            max-width: 550px;

        }


        @media screen and (max-width: 524px){
            .wrapper-sort-table .table tr td:first-child{
                width: 100%;
                white-space: nowrap !important;
                word-wrap: normal !important;
                max-width: 100%;
            }
        }

        a {
            text-decoration: none !important;
        }

        .pagination .flex-wrap .justify-content-center {
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

        .footable-page-arrow a, .footable-page a {
            position: relative;
            display: block;
            padding: 10px;
            margin: 10px 5px;
            font-size: 16px;
            line-height: 20px;
            font-family: 'Open Sans', sans-serif;
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

        .footable-page-arrow a:hover, .footable-page a:hover {
            z-index: auto;
            color: #fff;
            text-decoration: none;
            background-color: #38b348;
            border: 0 none;
        }

        .footable-page-arrow a[data-page=prev], .footable-page-arrow a[data-page=next], .footable-page-arrow.disabled {
            display: none;
        }

        #first_name, #last_name{
            background-color:#D3D3D3;

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

    <div class="wrapper-profile-box">


        <div class="top-profile-info">
            <form id="upload_logo" role="form" method="post" action="{{$user->user_role === 'volunteer' ? url('api/volunteer/profile/upload_logo') : url('api/organization/profile/upload_logo')}}"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" accept="image/*" name="file_logo" id="upload_logo_input" hidden="true">
            </form>


            <form id="upload_logo1" role="form" method="post"
                  action="{{$user->user_role === 'volunteer' ? url('api/volunteer/profile/upload_back_img') : url('api/organization/profile/upload_back_img')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" accept="image/*" name="file_logo" id="upload_logo1_input" hidden="true">
            </form>


            <div class="img-box"

                 style="background-image:url('{{$user->back_img == NULL ? asset('front-end/img/bg/0002.png') :  asset('uploads' .'/'. $user->back_img)}} ')"></div>


            <div class="container mobile-container">
                <div class="avatar"
                     @if($user->user_role === 'organization')
                        style="background-image:url('{{$user->logo_img == NULL ? asset('front-end/img/org/001.png') : asset('uploads' .'/'. $user->logo_img)}}')">
                     @else
                         style="background-image:url('{{$user->logo_img == NULL ? asset('img/logo/member-default-logo.png') : asset('uploads' .'/'. $user->logo_img)}}')">
                     @endif
                    <span></span></div>


                <div class="link-img">
                    @if($profile_info['is_my_profile'] == 1)
                        <a id="upload_logo_icon" href="#"><i class="fa fa-camera" aria-hidden="true"></i></a>
                        <a id="upload_logo1_icon" href="#"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                    @endif
                </div>

            </div>

            <div class="container">
                <div class="row txt-box">

                    <div class="col-12 col-md-6">

                        <div class="main-text"><p class="h2">{{Auth::user()->user_role == 'organization' ? $user->org_name : $user->first_name ." ". $user->last_name}}</p></div>
                        <p class="bold">User Name: {{$user->user_name}}</p>

                        <p class="bold">Contact Email: {{$user->email}}</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="main-text">

                            <ul class="list-column clearfix">
                                <li>
                                    <p class="h2">{{$friend->count()}}</p>
                                    <p class="light">Friends </p>
                                </li>
                                <li>
                                    <p class="h2">{{$group->count()}}</p>
                                    <p class="light">Groups</p>
                                </li>
                                <li>
                                    <p class="h2">{{$active_oppr->count()}}</p>
                                    <p class="light">Opportunites</p>
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- -->

        <div class="text-profile-info">

            <div class="container">


                <ul class="nav nav-tabs" role="tablist">
                    @if($profile_info['is_my_profile'] == 1)
                        <li class="nav-item">
                            <a class="nav-link active show" href="#details" role="tab"
                               data-toggle="tab"><span>{{$user->user_role === 'organization' ? 'Details' : 'Info' }}</span></a>
                        </li>

                        {{--@if($user->user_role === 'organization')--}}
                            {{--<li class="nav-item">--}}
                                {{--<a class="nav-link" href="#members" role="tab"--}}
                                   {{--data-toggle="tab"><span>Members</span></a>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                            <li class="nav-item">
                                <a class="nav-link" href="#activity" role="tab" data-toggle="tab"><span>Activity</span></a>
                            </li>

                    @else
                        <li class="nav-item">
                            <a class="nav-link disabled show" href="#info" role="tab"
                               data-toggle="tab"><span>Info</span></a>
                        </li>
                    @endif

                </ul>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="details">


                        @include('components.profile.detail-tab')
                        <hr>
                        @include('components.profile.account-tab')

                    </div>
                    @if($profile_info['is_my_profile'] == 1)
                        <div role="tabpanel" class="tab-pane fade" id="members">

                            <!-- -->
                            <!-- -->
                            <!-- -->
                        {{--@if($user->user_role == 'organization')--}}
                        {{--@include('components.profile.members-tab')--}}
                        {{--@endif--}}
                        <!-- -->
                            <!-- -->
                            <!-- -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="activity">

                            <!-- -->
                            <!-- -->
                            <!-- -->

                            @include('components.profile.activity-tab')

                            <!-- -->
                            <!-- -->
                            <!-- -->

                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>

@endsection



@section('script')

    {{--@if($user->user_role !== 'volunteer')--}}
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3n1_WGs2PVEv2JqsmxeEsgvrorUiI5Es"></script>



    {{--@endif--}}
    {{--<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>--}}
    <!--<script src="{{asset('js/plugins/footable/footable.all.min.js')}}"></script>-->

    @if($profile_info['is_my_profile'] == 1)
    <script src="{{asset('front-end//js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('front-end/js/ckeditor/sample.js')}}"></script>
    @endif

    <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script>
        $('#btn_accept').on('click', function (e) {
            e.preventDefault();

            var typeUser = '{{Auth::user()->user_role}}';

            var url = API_URL + typeUser + '/acceptFriend';
            ;

            var id = {{$user->id}};

            var current_button = $(this);

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


            var type = "POST";

            var formData = {

                id: id

            }

            $.ajax({

                type: type,

                url: url,

                data: formData,

                success: function (data) {

                    $('.wrapper_connect_button').hide();
                    window.location.reload();

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        });

        $('body').on('click', '#btn_connect', function (e) {
            e.preventDefault()

            var typeUser = '{{Auth::user()->user_role}}';
            var url = API_URL + typeUser + '/connectOrganization';

            var id = {{$user->id}};

            var current_button = $(this);
            console.log(typeUser, url, id)
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

                    $('#btn_pending').show();

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        });
    </script>

    <script type="text/javascript">
        var _URL = window.URL || window.webkitURL;
        $('#upload_logo_icon').on('click', function () {
            $('#upload_logo_input').click()
        });
        $('#upload_logo1_icon').on('click', function () {
            $('#upload_logo1_input').click()
        });
        $('#upload_logo_input').on('change', function () {
            $('#upload_logo').submit()
        });
        $('#upload_logo1_input').on('change', function () {
            var file, img;


            if ((file = this.files[0])) {

                img = new Image();

                img.onload = function () {


                    if (this.width < 1500 || this.height < 300) {

                        $('#banner_size').val(1);

                        alert('Recomended banner size 1500 X 300. Please try another');

                    }

                    else {

                        $('#upload_logo1').submit()

                        //alert(this.width+'=='+this.height);

                    }

                };

                img.src = _URL.createObjectURL(file);

            }

        });
        $('.footable').dataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
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
        /*$('.footable').footable({
            limitNavigation: 5,
            firstText: '1'
        });
        $('ul.pagination').each(function(){
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
        @if($profile_info['is_my_profile'] == 1)
        initSample();
        @endif
        $(document).ready(function () {
            @if($user->user_role === 'volunteer' and   $profile_info['is_my_profile'] == 1)
                 CKEDITOR.replace( 'editor');
            @endif





            /*$('.footable').footable({
                limitNavigation: 5,
                firstText: '1'
            });
            $('ul.pagination').each(function(){
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

                /*.dataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });*/

            function doResize($wrapper, $el) {

                var scale = Math.min(
                    $wrapper.outerWidth() / $el.outerWidth(),
                    $wrapper.outerHeight() / $el.outerHeight()
                );

                if (scale < 1) {

                    $el.css({
                        '-webkit-transform': 'scale(' + scale + ')',
                        '-moz-transform': 'scale(' + scale + ')',
                        '-ms-transform': 'scale(' + scale + ')',
                        '-o-transform': 'scale(' + scale + ')',
                        'transform': 'scale(' + scale + ')'
                    });

                } else {

                    $el.removeAttr("style");

                }

            }

            $('.wrapper_input.fa-icons input').datepicker({
                'format': 'mm/dd/yyyy',
                'autoclose': true,
                'orientation': 'right',
                'todayHighlight': true
            });


            $('.dashboard_org .track-it-time_slider .slider-wrapper').each(function () {
                doResize($(this), $(this).find('.slider-item-scale > div'));
            });

            $(window).resize(function () {
                $('.dashboard_org .track-it-time_slider .slider-wrapper').each(function () {
                    doResize($(this), $(this).find('.slider-item-scale > div'));
                });
            });

            $('.member-table').dataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
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
           /* $('.member-table').footable({
                limitNavigation: 5,
                firstText: '1'
            });
            $('ul.pagination').each(function(){
                if (Math.abs((parseInt($(this).find('.footable-page:last a').data('page')) + 1) - parseInt($(this).find('.footable-page-arrow:last a').text())) < 0.01) $(this).find('.footable-page-arrow:last').hide();
                else $(this).find(' .footable-page-arrow:last').show();
            });

            $('.pagination').on('click', 'li a[data-page]', function () { //, .footable-page-arrow
                var pagination = $(this).parents('.tab-pane.active .pagination');
                if (pagination.find('.footable-page:first a').data('page') == 0) pagination.find('.footable-page-arrow:first').hide();
                else pagination.find('.footable-page-arrow:first').show();
                if (Math.abs((parseInt(pagination.find('.footable-page:last a').data('page')) + 1) - parseInt(pagination.find('.footable-page-arrow:last a').text())) < 0.01) pagination.find('.footable-page-arrow:last').hide();
                else pagination.find('.footable-page-arrow:last').show();
            });

            if ($('.footable-page-arrow:last').text() < 5) $('.footable-page-arrow:last').hide();
            else $('.footable-page-arrow:last').show();
            console.log($('.footable-page-arrow:last').text())

            $(document).on('click', 'a[data-page]', function () { //, .footable-page-arrow
                if ($('.footable-page:first a').data('page') == 0) $('.footable-page-arrow:first').hide();
                else $('.footable-page-arrow:first').show();
                if (parseInt($('.footable-page:last a').data('page')) + 1 == $('.footable-page-arrow:last').text()) $('.footable-page-arrow:last').hide();
                else $('.footable-page-arrow:last').show();
                console.log($('.footable-page-arrow:last').text())
            });

            $('.member-table').footable({
                limitNavigation: 5,
                firstText: '1'
            });
            $('ul.pagination').each(function(){
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


            var $image = $(".profile-back-image > img")




            $("#inputImage").change(function (e) {

                var file, img;

                if ((file = this.files[0])) {

                    img = new Image();

                    img.onload = function () {


                        if (this.width < 1500 || this.height < 300) {

                            $('#banner_size').val(1);

                            alert('Recomended banner size 1500 X 300. Please try another');

                        }

                        else {

                            $('#banner_size').val(0);

                            $('#upload_logo').submit();

                            //alert(this.width+'=='+this.height);

                        }

                    };

                    img.src = _URL.createObjectURL(file);

                }

            });


        });


        // Get all html elements for map
        @if($user->user_role !== 'volunteer')
        var latLng = new google.maps.LatLng(parseFloat($('#lat_val').val()), parseFloat($('#lng_val').val()));

        var myOptions = {
            zoom: 16,
            center: latLng,
            styles: [{
                "featureType": "water",
                "stylers": [{"saturation": 43}, {"lightness": -11}, {"hue": "#0088ff"}]
            }, {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [{"hue": "#ff0000"}, {"saturation": -100}, {"lightness": 99}]
            }, {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#808080"}, {"lightness": 54}]
            }, {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ece2d9"}]
            }, {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ccdca1"}]
            }, {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{"color": "#767676"}]
            }, {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [{"color": "#ffffff"}]
            }, {"featureType": "poi", "stylers": [{"visibility": "off"}]}, {
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [{"visibility": "on"}, {"color": "#b8cb93"}]
            }, {"featureType": "poi.park", "stylers": [{"visibility": "on"}]}, {
                "featureType": "poi.sports_complex",
                "stylers": [{"visibility": "on"}]
            }, {"featureType": "poi.medical", "stylers": [{"visibility": "on"}]}, {
                "featureType": "poi.business",
                "stylers": [{"visibility": "simplified"}]
            }],
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("pos_map"), myOptions);
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: '{{asset('front-end/img/pin.png')}}'
        });
@endif

        $('#btn_follow').on('click', function () {

            var url = API_URL + 'organization/followOrganization';

            var id = $('#current_id').val();

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

                    $('#btn_unfollow').show();

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        });


        $('#btn_unfollow').on('click', function () {

            var url = API_URL + 'organization/unfollowOrganization';

            var id = $('#current_id').val();

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

                    $('#btn_follow').show();

                },

                error: function (data) {

                    console.log('Error:', data);

                }

            });

        });


    </script>

    @if($profile_info['is_my_profile'] == 1)
    <script>
        var display = $('.footable-page-arrow:nth-last-child(3)').css('display')

        if(display == 'none'){
            $('.footable-page-arrow:last-child').css('display', 'none')
        }
        else{
            $('.footable-page-arrow:last-child').css('display', 'block')
        }

        /*if(parseInt($('.footable-page:last a').data('page')) + 1 == $('.footable-page-arrow:last').text()) $('.footable-page-arrow:last').hide();
        else $('.footable-page-arrow:last').show();
        $(document).on('click', '.footable-page, .footable-page-arrow', function () {

            var display = $('.footable-page-arrow:nth-child(3)').css('display')

            if(display == 'none'){
                $('.footable-page-arrow:first-child').css('display', 'none')
            }
            else{
                $('.footable-page-arrow:first-child').css('display', 'block')
            }

            if(parseInt($('.footable-page:last a').data('page')) + 1 == $('.footable-page-arrow:last').text()) $('.footable-page-arrow:last').hide();
            else $('.footable-page-arrow:last').show();
        });*/
        
        $('#submit-update-account').on('click', function () {
            $('.org_name_detail').text($('#org_name').val())
            $('.user_name_detail').text($('#user_id').val())
            $('.user_email_detail').text($('#email').val())
            $('.user_phone_detail').text($('#contact_num').val())
            $('.user_education_detail').text(CKEDITOR.instances.editor.getData());
            $('#orgSum').val(CKEDITOR.instances.editor.getData())

            $('#textarea_box').html(CKEDITOR.instances.editor.getData());
            $('#update_account_oug').submit();
        });

        $("#update_account_oug").unbind('submit').submit(function (event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);


            $.ajax({
                url: API_URL + 'organization/update_account',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (return_data) {
                    var result = $.parseJSON(return_data);
                    if (result.status == 1) {
                        $(".resultupdatemsg").css("display", "block");
                        $(".resultupdatemsg").removeClass("alert-danger");
                        $(".resultupdatemsg").addClass("alert-success");
                        $(".resultupdatemsg").html(result.msg);
                        setTimeout(function () {
                            $('.resultupdatemsg').fadeOut('fast');
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
                }
            });
        });

        $('#btn_edit').click(function(){
            var modal = document.getElementById('myModal');
            var btn = document.getElementById('btn_edit');
            var span = document.getElementsByClassName("close")[0];
            btn.onclick = function() {
                modal.style.display = "block";
            }
            span.onclick = function() {
                modal.style.display = "none";
            }
            window.onclick = function(event) {
               if (event.target == modal) {
                modal.style.display = "none";
                }
            }
        });

        $('#btn_save').on('click',function(e){

            e.preventDefault();

            var flags = 0;

            if($('#email').val()=='') {
                $('#email').css("border", "1px solid #ff0000");
                flags++;
            }

            if (!ValidateEmail($('#email').val())) {
                flags++;
                $('#invalid_email_alert').show();
            }

            if($('#birth_day').val()=='') {
                $('#birth_day').css("border", "1px solid #ff0000");
                flags++;
            }

            if($('#address').val()=='') {
                $('#address').css("border", "1px solid #ff0000");
                flags++;
            }

            if($('#zipcode').val()=='') {
                $('#zipcode').css("border", "1px solid #ff0000");
                flags++;
            }

            if (!ValidateZipcode($('#zipcode').val())) {
                flags++;
                $('#zipcode').css("border", "1px solid #ff0000");
                $('#invalid_zipcode_alert').show();
            }

            if($('#contact_num').val()=='') {
                $('#contact_num').css("border", "1px solid #ff0000");
                flags++;
            }

            if (!ValidatePhonepumber($('#contact_num').val())) {
                flags++;
                $('#invalid_contact_number').show();
                $('#contact_num').css("border", "1px solid #ff0000");
            }



            if($('#new_password').val()!='') {
                if (!ValidatePassword($('#new_password').val())) {
                    flags++;
                    $('#invalid_password').show();
                    $('#new_password').css("border", "1px solid #ff0000");
                }

                if($('#new_password').val() != $('#confirm_password').val()){
                    flags++;
                    $('#invalid_confirm').show();
                    $('#confirm_password').css("border", "1px solid #ff0000");
                }

            }

            if(flags == 0){
                // $('#update_account').submit();
                $('.user_name_profile').text($('user_id').val())
                $('.user_email_profile').text($('#email').val())

                $('.my_summary_acount').val(CKEDITOR.instances.editor.getData())
                $('#textarea_box').html(CKEDITOR.instances.editor.getData())

                $('#update_account').submit()
            }

        });

        $("#update_account").unbind('submit').submit(function (event) {

            event.preventDefault();

            var formData = new FormData($(this)[0]);
            console.log($(this)[0])
            $.ajax({

                url: API_URL + "volunteer/update_account",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (return_data)

                {
                    var result = $.parseJSON(return_data);
                    console.log(return_data)
                    if(result.status == 1) {
                        $(".resultupdatemsg").css("display", "block");
                        $(".resultupdatemsg").removeClass("alert-danger");
                        $(".resultupdatemsg").addClass("alert-success");
                        $(".resultupdatemsg").html(result.msg);

                        setTimeout(function() {
                            $('.resultupdatemsg').fadeOut('fast');
                        }, 2000);
                    }else{
                        $(".resultupdatemsg").css("display", "block");
                        $(".resultupdatemsg").removeClass("alert-success");
                        $(".resultupdatemsg").addClass("alert-danger");
                        $(".resultupdatemsg").html(result.msg);

                        setTimeout(function() {
                            $('.resultupdatemsg').fadeOut('fast');
                        }, 2000);

                    }

                }

            });

        });

    </script>
@endif
@endsection