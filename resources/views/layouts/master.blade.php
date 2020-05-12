<!DOCTYPE html>
<html lang="en">

<head>
    @php  $Title = app()->view->getSections()['title']; @endphp
    @include('layouts.head',['Title'=>$Title])
    @yield('head')
</head>

<body id="timerlink"  style="background-color: #666666;">
    @yield('content')
    @include('layouts.footer')
    @include('layouts.script')
    @yield('footer')
</body>
</html>

