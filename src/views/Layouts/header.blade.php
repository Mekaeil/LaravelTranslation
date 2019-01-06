<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="@yield('dir','ltr')">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Meta, title, CSS, favicons, etc. -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/ico"/>
    <title>{{ config('admin.site.title') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('laravel-translation/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('laravel-translation/vendors/bootstrap-rtl/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('laravel-translation/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('laravel-translation/build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('laravel-translation/build/css/additional.css') }}" rel="stylesheet">

    @yield('header')
</head>
<!-- /header content -->
<body class="nav-md">