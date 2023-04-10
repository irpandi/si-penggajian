<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('layouts.home-head')
        <title>HD Collection - {{ $title ?? 'Page' }}</title>
        @yield('css')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        @yield('modal')
        
        <div class="wrapper">
            @include('layouts.home-navbar')

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1>{{ $title ?? 'Page' }}</h1>
                            </div>

                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    {!! $breadcrumbs ?? '<li class="breadcrumb-item active">Page</li>' !!}
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                
                @yield('content')
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2023 <a href="#">HD Collection</a>.</strong> All rights reserved.
        </footer>

        @include('layouts.home-script')
        @yield('script')
    </body>
</html>