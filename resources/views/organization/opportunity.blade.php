@extends('layout.masterForAuthUser')

@section('css')
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <style>
        .main-text a{
            text-decoration: none;
        }
    </style>
@endsection
@section('content')
    <div class="wrapper-opportunities">


        <div class="add-new-box">
            <div class="container">

                <div class="row align-items-center">
                    <div class="col-12 col-md-8 col-lg-9">
                        <p>Opportunities</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="{{route('organization-opportunity-post')}}" class="add-new"><span>add New Opportunity</span></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="wrapper-tablist">
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" href="#active" role="tab" data-toggle="tab"><span>Active</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#expired" role="tab" data-toggle="tab"><span>Expired</span></a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="active">

                        <p class="title">Active Opportunities</p>

                        <ul>

                            @foreach($active_oppors as $op)
                                <li>

                                    <div class="row">
                                        <div class="col-3 col-md-2">
                                            <div class="avatar" style="background-image:url('{{ $op->logo_img === NULL ? asset('front-end/img/org/001.png') : asset('uploads/' . $op->logo_img) }}')"></div>
                                        </div>
                                        <div class="col-9 col-md-10">

                                            <div class="row align-items-end">
                                                <div class="col-12 col-md-9">

                                                    <div class="main-text">
                                                        <a href="{{url('/organization/view_opportunity')}}/{{$op->id}}"> <p class="name"> {{$op->title}}</p></a>
                                                        <p class="light">Opportunity</p>
                                                        <p>{{$op->description}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">

                                                    <div class="buttons">
                                                        <a href="{{url('/organization/edit_opportunity')}}/{{$op->id}}" class="edit"><span>Edit</span></a>
                                                        <a data-opportuniti-id="{{$op->id}}" href="#" class="remove"><span><i class="fa fa-trash"></i></span></a>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </li>
                            @endforeach

                        </ul>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="expired">

                        <p class="title">Expired	 Opportunities</p>

                        <ul>

                            @foreach($expired_oppors as $ex_op)
                                <li>

                                    <div class="row">
                                        <div class="col-3 col-md-2">
                                            <div class="avatar" style="background-image:url('{{ $ex_op->logo_img === NULL ? asset('front-end/img/org/001.png') : asset('uploads/' . $ex_op->logo_img) }}')"></div>
                                        </div>
                                        <div class="col-9 col-md-10">

                                            <div class="row align-items-end">
                                                <div class="col-12 col-md-9">

                                                    <div class="main-text">
                                                        <a href="{{url('/organization/view_opportunity')}}/{{$ex_op->id}}"><p class="name">{{$ex_op->title}}</p></a>
                                                        <p class="light">Opportunity</p>
                                                        <p>{{$ex_op->description}}</p>
                                                    </div>

                                                </div>
                                                <div class="col-12 col-md-3">

                                                    <div class="buttons">
                                                        <a href="{{url('/organization/edit_opportunity')}}/{{$ex_op->id}}" class="edit"><span>Edit</span></a>
                                                        <a data-opportuniti-id="{{$ex_op->id}}" href="#" class="remove"><span><i class="fa fa-trash"></i></span></a>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </li>

                            @endforeach

                        </ul>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('script')

    <script>
        $('.remove').click(function (e) {
            e.preventDefault();
            var $div = $(this);
            var oppr_id = $div.data('opportunitiId');
            var url = '{{route('api-organization-delete_opportunity')}}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            var type = "post";
            var formData = {
                oppr_id: oppr_id,
            }
            $.ajax({
                type: type,
                url: url,
                data: formData,
                success: function (data) {
                    $div.parent().parent().parent().parent().parent().parent().hide()
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        })
    </script>
@endsection
