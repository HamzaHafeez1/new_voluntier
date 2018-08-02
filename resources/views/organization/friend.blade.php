@extends('layout.masterForAuthUser')

@section('css')
    <link href="<?= asset('css/plugins/footable/footable.core.css') ?>" rel="stylesheet">

@endsection

@section('content')
    <div class="wrapper-friends">


        <div class="search-friends">
            <div class="container">

                <div class="search">
                    <label><span class="gl-icon-search"></span></label>
                    <input id="search-friens-input" type="text" placeholder="Search Friends">
                </div>

            </div>
        </div>

        <div class="wrapper-friends-list">
            <div class="container">

                <div class="main-text"><h2 class="h2">Friends</h2></div>

                @if(count($friend_requests) > 0)
                        @include('organization.friendsUserList', ['nameClassUl' => 'friend_requests', 'friends' => $friend_requests])
                @endif

                    @include('organization.friendsUserList', ['nameClassUl' => $nameClassUl, 'friends' => $friends])


                <div class="wrapper-pagination">
                    <div class="wrapper-pagination">
                        {{ $friends->links('components.pagination') }}
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection

@section('script')
    <!--<script src="<?= asset('js/plugins/footable/footable.all.min.js') ?>"></script>-->
    <script src="<?= asset('js/plugins/dataTables/jquery.dataTables.js') ?>"></script>
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('#search-friens-input').keyup(function () {

                if ($(this).val().length > 2) {//alert($(this).val().length);
                    console.log(1)
                    var this1 = $(this);
                    $.ajax({
                        url: "{{ Auth::user()->user_role === 'organization' ? route('organization-get-friend') : route('volunteer-get-friend')}}",
                        data: 'keyword=' + $(this).val(),
                        type: 'POST',
                        success: function (res) {
                            $('.friends-list-search').remove();
                            $('.friends-list-main').hide();

                            $('.main-text').after(res)
                        }
                    })
                }
                else {
                    console.log(2)
                    $('.friends-list-search').remove();
                    $('.friends-list-main').show();
                }
            })



        });

        function request_update(id, friend_id, status, delete_type) {
            $('#error').html('');
            $.ajax({
                url: "{{Auth::user()->user_role === 'organization' ? route('organization-friend-accept-reject') : route('volunteer-friend-accept-reject') }}",
                data: {
                    'id': id,
                    'user_id':{{ $user_id }},
                    'sender': friend_id,
                    'status': status,
                    'type': delete_type
                },
                type: 'POST',
                success: function (res) {
                    if (res.success == 0) {
                        $('#error').html(res.error);
                    } else {
                        window.location.reload();
                    }
                }
            });
        }
    </script>
@endsection
