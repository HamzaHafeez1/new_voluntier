@extends('volunteer.layout.master')



@section('css')

<link href="<?= asset('css/plugins/footable/footable.core.css') ?>" rel="stylesheet">

<style>

    img{width: 70px;}

    .btn-action-follow{min-width: 85px;}

    .btn-action-unfollow{min-width: 85px;}

    .btn-action-connect{min-width: 85px;}

    .impact-tracked-hours{padding-bottom: 0 !important;}

    .filter-text{font-size: 18px; padding-right: 10px;}
    .img-circle {
        max-height: 70px;
    }
.checkoutloading{
position: fixed;
left: 0;
top: 0;
z-index: 999;
width: 100%;
height: 100%;
overflow: visible;
background: rgba(0,0,0,0.7) url(../img/logo/ajax_loder.jpg) no-repeat center center;
}

</style>

@endsection



@section('content')

<div class="content-panel">

    <div class="wrapper wrapper-content">

        <div class="row">

            <div class="col-lg-12 animated fadeInRight impact-panel" style="margin-top: 0">

                <div class="impact-tracked-hours">

                    <h2 class=""><i class="fa fa-search"></i> Search Result</h2>
                    <div class="clearfix"></div>

                    <div class="text-center link-block ">

                        <div class="row">

                            <div class="col-md-8">
                                <div class="pull-left">
                                <strong class="filter-text">Filters:</strong>
                                <label for="vol" class="filters-label">

                                    <input type="checkbox" class="filter" name="vol" id="vol" value="v" {{ (in_array('v', $filter))?"checked" : '' }}/>

                                    <strong>Volunteer</strong>

                                </label>

                                <label for="org" class="filters-label">

                                    <input type="checkbox" class="filter" name="org" id="org"  value="r" {{ (in_array('r', $filter))?"checked" : '' }}/>

                                    <strong>Organization</strong>

                                </label>

                                <label for="grp" class="filters-label">

                                    <input type="checkbox" class="filter" name="grp" id="grp"  value="g" {{ (in_array('g', $filter))?"checked" : '' }}/>

                                    <strong>Group</strong>

                                </label>

                                <label for="opp" class="filters-label">

                                    <input type="checkbox" class="filter" name="opp" id="opp"  value="p" {{ (in_array('p', $filter))?"checked" : '' }}/>

                                    <strong>Opportunities</strong>

                                </label>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="search-box pull-right">

                                    <div class="input-group">

                                        <input type="text" id="search_box_page" name="keyword" class="form-control" placeholder="People/group/org/opportunities" value="{{$keyword}}">

                                        <span class="input-group-btn">

                                            <button type="button" id="btn_search_page" class="btn btn-primary" style="padding: 6px 12px;"><i class="fa fa-search"></i></button>

                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>



                    </div>

                    <div style="clear: both"></div>

                </div>



                <div class="panel-body">

                    <div class="detail_header">

                        <table class="search-table table table-stripped" data-page-size="10" data-filter=#filter>

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

                                    <td style="text-align: left; padding-left: 50px">

                                        <?php

                                        if ($r['logo_img'] == null) {
											 $profile_pics = asset('front-end/img/org/001.png');
                                            if (($r['user_role'] == 'organization')

                                                || ($r['user_role'] == 'groups')

                                                || ($r['user_role'] == 'opportunity')) {

                                                $profile_pics = asset('front-end/img/org/001.png');

                                            }if ($r['user_role'] == 'volunteer') {

                                                $profile_pics = asset('img/logo/member-default-logo.png');

                                            }

                                        } else {

                                            if ($r['user_role'] == 'group') {

                                                $profile_pics = asset('uploads/volunteer_group_logo/thumb/').'/'.$r['logo_img'];

                                            } else {

                                                $profile_pics = asset('uploads').'/'.$r['logo_img'];

                                            }

                                        }

                                        ?>

                                        @if($r['user_role'] == 'organization')

                                        <a href="{{url('/')}}/organization/profile/{{$r['id']}}" target="_blank">
                                        {{--<a href="javascript:void(0);" >--}}

                                            <img alt="image" class="img-circle" src="{{$profile_pics}}"> <strong>{{$r['name']}}</strong>

                                        </a>

                                        @elseif($r['user_role'] == 'volunteer')

                                        <!--<a href="{{url('/')}}/volunteer/profile/{{$r['id']}}" target="_blank">-->
                                        <a href="javascript:void(0);">

                                            <img alt="image" class="img-circle" src="{{$profile_pics}}"> <strong>{{$r['name']}}</strong>

                                        </a>

                                        @elseif($r['user_role'] == 'group')

                                        <?php

                                        $encoded_id = base64_encode($r['id']);

                                        ?>

                                        <a href="{{url('/')}}/sharegroup/{{$encoded_id}}" target="_blank">

                                            <img alt="image" class="img-circle" src="{{$profile_pics}}"> <strong>{{$r['name']}}</strong>

                                        </a>

                                        @elseif($r['user_role'] == 'opportunity')

                                        <a href="{{url('/')}}/organization/view_opportunity/{{$r['id']}}" target="_blank">

                                            <img alt="image" class="img-circle" src="{{$profile_pics}}"> <strong>{{$r['name']}}</strong>

                                        </a>

                                        @endif

                                        <!-- @if($r['logo_img'] == null)



                                                @if($r['user_role'] == 'organization')

                                                    <a href="{{url('/')}}/organization/profile/{{$r['id']}}" target="_blank">

                                                        <img alt="image" class="img-circle" src="<?= asset('front-end/img/org/001.png') ?>"> <strong>{{$r['name']}}</strong>

                                                    </a>

                                                @elseif($r['user_role'] == 'volunteer')

                                                    <a href="{{url('/')}}/volunteer/profile/{{$r['id']}}" target="_blank">

                                                        <img alt="image" class="img-circle" src="<?= asset('img/logo/member-default-logo.png') ?>"> <strong>{{$r['name']}}</strong>

                                                    </a>

                                                @elseif($r['user_role'] == 'group')

                                        <?php

                                        $encoded_id = base64_encode($r['id']);

                                        ?>

                                                    <a href="{{url('/')}}/sharegroup/{{$encoded_id}}" target="_blank">

                                                        <img alt="image" class="img-circle" src="<?= asset('img/logo/member-default-logo.png') ?>"> <strong>{{$r['name']}}</strong>

                                                    </a>

                                                @elseif($r['user_role'] == 'opportunity')

                                                    <a href="{{url('/')}}/organization/profile/{{$r['id']}}" target="_blank">

                                                        <img alt="image" class="img-circle" src="<?= asset('img/logo/member-default-logo.png') ?>"> <strong>{{$r['name']}}</strong>

                                                    </a>

                                                @endif



                                        @else

                                            @if($r['user_role'] == 'group')

                                            <?php

                                            $encoded_id = base64_encode($r['id']);

                                            ?>

                                                <a href="{{url('/')}}/sharegroup/{{$encoded_id}}" target="_blank">

                                                    <img alt="image" class="img-circle" src="<?= asset('uploads/volunteer_group_logo/thumb') ?>/{{$r['logo_img']}}"> <strong>{{$r['name']}}</strong>

                                                </a>

                                            @else

                                                {{--<a href="{{url('/')}}/organization/profile/{{$r['id']}}" target="_blank">--}}

                                                    {{--<img alt="image" class="img-circle" src="<?= asset('uploads') ?>/{{$r['logo_img']}}"> <strong>{{$r['name']}}</strong>--}}

                                                {{--</a>--}}

                                            @endif

                                        @endif -->

                                    </td>

                                    <td>{{$r['user_role']}}</td>

                                    @if(isset($r['show_address']) && !empty($r['show_address']) && $r['show_address'] == 'Y' && $r['user_role'] == 'volunteer')

                                    <td>{{$r['city']}}, {{$r['state']}}, {{$r['country']}}</td>

                                    @elseif(($r['user_role'] == 'organization') || ($r['user_role'] == 'group') || ($r['user_role'] == 'opportunity'))

                                    <td>{{implode(', ', array_filter([$r['city'], $r['state'], $r['country']]))}}</td>

                                    @else

                                    <td>-------</td>

                                    @endif





                                    <td style="text-align: right; padding-right: 50px;">

                                        @if($r['user_role'] == 'organization')
                                        <?php /* <a href="javascript:void(0)" onclick="sendMessage('{{$r['id']}}')"  class="btn btn-primary">Message</a> */ ?>
                                        <?php /*
                                        @if($r['is_followed'] == 0)

                                        <a class="btn btn-primary btn-action-follow">Follow</a>

                                        <a class="btn btn-danger btn-action-unfollow" style="display: none">Unfollow</a>

                                        @else

                                        <a class="btn btn-primary btn-action-follow" style="display: none">Follow</a>

                                        <a class="btn btn-danger btn-action-unfollow">Unfollow</a>

                                        @endif
                                        */ ?>

                                        @if($r['is_friend'] == 0)

                                        <a class="btn btn-primary btn-action-connect">Connect</a>

                                        <a class="btn btn-default btn-action-connect-pending" style="display: none">Pending..</a>

                                        @elseif($r['is_friend'] == 1)

                                        <a class="btn btn-default btn-action-connect-pending">Pending..</a>

                                        @endif

                                        @elseif($r['user_role'] == 'volunteer')

                                       <?php /* <a href="javascript:void(0)" onclick="sendMessage('{{$r['id']}}')"  class="btn btn-primary">Message</a> */ ?>

                                        @if($r['is_friend'] == 0)

                                        <a class="btn btn-primary btn-action-connect">Connect</a>

                                        <a class="btn btn-default btn-action-connect-pending" style="display: none">Pending..</a>

                                        @elseif($r['is_friend'] == 1)

                                        <a class="btn btn-default btn-action-connect-pending">Pending..</a>

                                        @endif

                                        @elseif($r['user_role'] == 'group')

                                        @if($r['is_friend']==1)

                                        <p class="form-control-static">Already joined</p>

                                        @else

                                        <a class="btn btn-primary btn-action-join" data-id="{{$r['group_id']}}">Join</a>

                                        @endif

                                        @endif

                                    </td>

                            <td><input class="current-id" type="hidden" value="{{$r['id']}}"></td>

                            </tr>

                            @endforeach

                            @endif

                            </tbody>

                            <tfoot>

                                <tr>

                                    <td colspan="8" style="padding :20px 0 0">


                                    </td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <script>

    function sendMessage(receiver_id){
        $("#add_message").modal('show');
        $("#receiver_id").val(receiver_id);

    }
    </script>

    <div class="modal inmodal" id="add_message" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="checkoutloading" class="checkoutloading" style="display:none;"></div>
                <div class="modal-header">
                    <button type="button" onclick="resetadd()" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Send Message</h4>
                </div>
                <form class="form-horizontal" id="addFormSendMessage">
                    <div class="modal-body">
                    <div class="alert alert-success fade in alert-dismissable resultupdatemsg" id="d" style="display:none"></div>
                        <div class="col-md-12 reg-content">
                            <p><strong>Message: </strong></p>
                            <textarea name="content" id="content" onkeyup="return contectval(this.value)" class="form-control" placeholder="Enter message"  autocomplete="off"></textarea>
                            <div class="alert alert-danger fade in alert-dismissable" id="content_error" style="display:none; margin-top:5px;">
                            </div>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <input type="hidden" name="receiver_id" id="receiver_id" value="">
                            <button type="button" onclick="resetadd()" class="btn btn-primary" data-dismiss="modal" id="btn_close">Close</button>
                            <button onclick="return submitMessage();" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection



    @section('script')

        <!--<script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script>-->
            <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script>
    function resetadd()
    {
         $("#content_error").hide();
        var fm=document.getElementById('addFormSendMessage');
        fm.reset();
    }
    function contectval(val)
    {
        if(val.search(/\S/) == -1)
        {
            $("#content_error").show();
            $("#content_error").html("Please enter message");
        }
        else
        {
            $("#content_error").hide();
        }
    }

    function submitMessage(){
    var content = $("#content").val();
    if(content ==''){
        document.getElementById('content').style.border = '1px solid red !important';
        $("#content_error").css("display", "block");
        document.getElementById("content_error").innerHTML = "Please enter message";
        document.getElementById('content').focus();
        return false
    }else{
        $("#content_error").css("display", "none");
        document.getElementById('content').style.border = '';
        document.getElementById("content_error").innerHTML = "";
    }



        $("#addFormSendMessage").unbind('submit').submit(function (event) {
            event.preventDefault();
            document.getElementById('checkoutloading').style.display = '';
            var formData12 = new FormData($(this)[0]);
            $.ajax({
                url: API_URL + "volunteer/sendmessage",
                type: 'POST',
                data: formData12,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (return_data)
                {
                    document.getElementById('checkoutloading').style.display = 'none';
                    var result = $.parseJSON(return_data);
                    if(result.status == 1) {

                    $(".resultupdatemsg").css("display", "block");

                      $(".resultupdatemsg").removeClass("alert-danger");

                      $(".resultupdatemsg").addClass("alert-success");

                      $(".resultupdatemsg").html(result.msg);

                    setTimeout(function() {
                        $("#content").val('');
                         $('.resultupdatemsg').fadeOut('fast');
                        $("#add_message").modal('hide');
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

                },
                error: function(html)
                {
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
    /*$('.search-table').footable({
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

    $('.filter').on('change', function(){

        $('#btn_search_page').trigger('click');

    });

});

$('#btn_search_page').on('click', function () {

    var keyword = $('#search_box_page').val();

    var filter = '';

    $('.filter').each(function(){

        if($(this).is(':checked')){

            filter += $(this).val()+ '+';

        }

    });

    if (keyword != '') {

        var url = SITE_URL + 'volunteer/search?keyword=' + keyword;

        if(filter != ''){

            url += '&filter='+filter.slice(0,-1);

        }

        window.location.replace(url);

    }

    if (keyword == '' && filter != '') {

        var url = SITE_URL + 'volunteer/search?filter='+filter.slice(0,-1);

        window.location.replace(url);

    }

    if(keyword == '' && filter == ''){

         window.location.replace(SITE_URL + 'volunteer/search');

    }

});



$('#search_box_page').keyup(function (e) {

    var keyword = $('#search_box_page').val();

    if (e.keyCode == 13)

    {

        if (keyword != '') {

            var url = SITE_URL + 'volunteer/search?keyword=' + keyword;

            window.location.replace(url);

        }

    }

});



$('.btn-action-follow').on('click', function () {

    var url = API_URL + 'volunteer/followOrganization';

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

    var url = API_URL + 'volunteer/unfollowOrganization';

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

    var url = API_URL + 'volunteer/connectOrganization';

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

    var url = API_URL + 'volunteer/joinGroup';

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

