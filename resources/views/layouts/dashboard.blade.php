<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>RSUMM | @yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.5/pdfobject.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/components.css')}}">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
        @include('sweetalert::alert')
        @include('partials.navbar')
        @include('partials.sidebar')
        @php
        $paths = explode('/', Request::path());
        $len = count($paths)-1;
        if (Request::path() != '/') {
        $path = ucfirst($paths[$len]);
        }else {
        $path = 'Dashboard';
        }
        @endphp
        <div class="main-content">
            <section class="section">
            <div class="section-header">
                <h1>@yield('header')</h1>
                <div class="section-header-breadcrumb">
                {{-- @if (url()->full()=='http://127.0.0.1:8000')
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                @else --}}
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                @if (Request::path() != "/")
                @foreach ($paths as $key => $path )
                <div class="breadcrumb-item">{{ucfirst($path)}}</div>
                @endforeach
                @endif
                {{-- @endif --}}
                </div>
            </div>
            @yield('content')
            </section>
        </div>
        @include('partials.footer')
        </div>
    </div>
    @yield('modal')
    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('/assets/js/stisla.js')}}"></script>

    <!-- JS Libraies -->
    <script>
        var url = window.location.pathname;

        $('.sidebar-menu a').each(function() {
            var href = $(this).attr('href');
            if (url.indexOf(href) > -1) {
                $('.sidebar-menu li').removeClass('active');;
                $(this).parent('li').addClass('active');
            }
        });
    </script>
    <!-- Template JS File -->
    <script src="{{asset('/assets/js/scripts.js')}}"></script>
    <script src="{{asset('/assets/js/custom.js')}}"></script>
    @yield('script')

    <!-- Page Specific JS File -->
</body>

</html>
