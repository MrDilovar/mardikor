<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>mdk.loc</title>
    
    <!-- Favicons -->
{{--    <link rel="shortcut icon" href="img/favicon.ico">--}}

    <!-- Styles and Scripts -->
    <link rel="stylesheet" href="/css/app.css">
    <script type="text/javascript" src="/js/app.js"></script>
</head>
<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    @guest
        @include('guest.header')
    @endguest

    @can('is_applicant')
        @include('applicant.header')
    @endcan

    @can('is_employer')
        @include('employer.header')
    @endcan

    @yield('content')

    @guest
        @include('guest.footer')
    @endguest

    @can('is_applicant')
        @include('applicant.footer')
    @endcan

    @can('is_employer')
        @include('employer.footer')
    @endcan

    <!-- Scripts -->
</body>
</html>