@extends('volunteer.layout.master')

@section('css')
<link href="<?= asset('css/plugins/footable/footable.core.css') ?>" rel="stylesheet">
<style>
    img{width: 70px;}
</style>
@endsection

@section('content')
<div class="content-panel">
    <div class="wrapper wrapper-content">
        <span id="error" style="color:red;"></span>
        <div class="row">
            <div class="col-lg-12 animated fadeInRight impact-panel" style="margin-top: 0">
                <div class="frndsWrapper">
                    <div class="newFrndRequest">
                        @if(count($friend_requests) > 0)
                            @foreach($friend_requests as $request)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="cardBox">
                                            <?php
                                            if($request->user_role == 'organization'){
                                                $name = ucfirst($request->org_name);
                                                if($request->logo_img == null){
                                                    $profile_pics = asset('front-end/img/org/001.png');
                                                }else{
                                                    $profile_pics = asset('uploads').'/'.$request->logo_img;
                                                }
                                            }else{
                                                $name =  ucfirst($request->first_name).' '.ucfirst($request->last_name);
                                                if($request->logo_img == null){
                                                    $profile_pics = asset('img/logo/member-default-logo.png');
                                                }else{
                                                    $profile_pics = asset('uploads').'/'.$request->logo_img;
                                                }
                                            }
                                            ?>
                                            <img src="<?php echo $profile_pics; ?>" alt="{{ $name }}">
                                            <h4>{{ $name }}</h4>
                                            <small>{{ ucfirst($request->city).', '.ucfirst($request->state) }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="actionArea">
                                            <p>Sent You a friendship Request</p>
                                            <a href="javascript:void(0)" class="text-green btn" onclick="request_update({{ $request->id }}, {{ $request->user_id }}, 0, 1)">Dismiss</a>
                                            <a href="javascript:void(0)" class="btn btn-primary" onclick="request_update({{ $request->id }}, {{ $request->user_id }}, 2)">Accept</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="frndList">
                        <h2><i class="fa fa-user"></i> My Friends</h2>
                        <div class="row">
                            @if(count($friends))
                                @foreach($friends as $friend)
                                    <div class="col-md-6">
                                        <div class="cardBox">
                                            <a href="javascript:void(0)" class="unfriend" onclick="request_update({{ $friend->id }}, {{ $friend->friend_id }}, 0, 0)"> <i class="fa fa-user-times"></i> Unfriend</a>
                                            <?php
                                            if($friend->user_role == 'organization'){
                                                $name = ucfirst($friend->org_name);
                                                $profile_link = "<h4><a href='".url('/')."/organization/profile/".$friend->friend_id."'>".$name."</a></h4>";
                                                if($friend->logo_img == null){
                                                    $profile_pics = asset('img/logo/front-end/img/org/001.png');
                                                }else{
                                                    $profile_pics = asset('uploads').'/'.$friend->logo_img;
                                                }
                                            }else{
                                                $name =  ucfirst($friend->first_name).' '.ucfirst($friend->last_name);
                                                $profile_link = "<h4><a href='".url('/')."/volunteer/profile/".$friend->friend_id."'>".$name."</a></h4>";
                                                if($friend->logo_img == null){
                                                    $profile_pics = asset('img/logo/member-default-logo.png');
                                                }else{
                                                    $profile_pics = asset('uploads').'/'.$friend->logo_img;
                                                }
                                            }
                                            ?>
                                            <img src="<?php echo $profile_pics; ?>" alt="{{ $name }}">
                                            <?php echo $profile_link ?>
                                            <small>{{ ucfirst($friend->city).', '.ucfirst($friend->state) }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
        <!--<script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script>-->
            <script src="<?=asset('js/plugins/dataTables/jquery.dataTables.js')?>"></script>
    <script>
        $(document).ready(function () {
            $('.friend-table').dataTable({
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
            /*$('.friend-table').footable({
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
        });

        function request_update(id, friend_id, status, delete_type){
            $('#error').html('');
            $.ajax({
                url: "{{ url('/volunteer/friend_accept_reject') }}",
                data:{'id': id, 'user_id':{{ $user_id }}, 'sender': friend_id, 'status': status, 'type': delete_type},
                type: 'POST',
                success: function(res)
                {
                    if(res.success == 0){
                        $('#error').html(res.error);
                    }else{
                        window.location.reload();
                    }
                }
            });
        }
    </script>
    @endsection
