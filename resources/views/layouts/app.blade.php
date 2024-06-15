<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    @include('layouts.partials.css')
</head>

<body>
    @include('layouts.partials.header')
    <div class="container-fluid page-body-wrapper">

        @include('layouts.partials.sidebar')
        <div class="main-panel">

            @yield('content')
            <!-- content-wrapper ends -->
            @include('layouts.partials.footer')
        </div>
    </div>
</body>

</html>
