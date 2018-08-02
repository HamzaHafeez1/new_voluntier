<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Voluntier</title>
    <meta http-quiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="<?=asset('front-end/css/bootstrap.css')?>" rel="stylesheet">



    <link href="{{asset('front-end/css/jquery.bxslider.css')}}" rel="stylesheet">
    <link href="{{asset('front-end/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('front-end/css/select2-bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('front-end/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('front-end/css/jquery.bxslider.css') }}" rel="stylesheet">
    <link href="{{asset('front-end/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('front-end/css/bootstrap-datepicker.css')}}" rel="stylesheet">
    <link href="{{asset('front-end/css/bootstrap-sortable.css')}}" rel="stylesheet" >
    <link href="<?=asset('front-end/css/main.css')?>" rel="stylesheet">

    @yield('css')
</head>
    @yield('body')

</html>
