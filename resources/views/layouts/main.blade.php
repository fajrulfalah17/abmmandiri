<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>K3MTs | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    @stack('prepend-style')
    @include('component.style')
    @stack('addon-style')

</head>


<body>

    <!-- <body data-layout="horizontal"> -->
    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('component.navbar')

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu" @include('component.sidebar') </div>
            <!-- Left Sidebar End -->
            @include('component.horizontal')
            @include('sweetalert::alert')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        @yield('content')
                        <!-- end row -->
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                @include('component.footer')
            </div>
            <!-- end main content-->

        </div>

        <!-- JAVASCRIPT -->

        @stack('prepend-script')
        @include('component.script')
        @stack('addon-script')

</body>

</html>
