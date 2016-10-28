<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui"/>
    
    <title>@section('title') @show</title>
    @section('meta_keywords')
        <meta name="keywords" content="@section('keywords') @show"/>
    @show @section('meta_author')
        <meta name="author" content="@section('author') @show"/>
    @show @section('meta_description')
        <meta name="description" content="@section('description') @show"/>
    @show
    
    <link href="{!! asset('/assets/css/style.css')  !!} " rel="stylesheet" type="text/css" />
    
    @yield('styles')
    
    <link rel="shortcut icon" href="{!! asset('/assets/img/favicon.ico')  !!} ">
    
    <script type="text/javascript" src="/assets/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.form.js"></script>
        
</head>
@include('partials.header')
@yield('content')
@include('partials.footer')
</body>
</html>