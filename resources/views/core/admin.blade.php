<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/chart-js/dist/Chart.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">

    <meta name="format-detection" content="telephone=no">
    @yield('css')
    <title>@yield('title')</title>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('core.sidebar')
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- End Topbar -->
            @include('core.topbar')
            <!-- End Topbar -->

            <!-- Main Content -->
            <div id="content">
                
                <!-- Begin Page Content -->
                    @yield('content')
                <!-- End Page Content -->
                
            </div>
            <!-- End of Main Content -->
            
            <!-- Footer -->
            @include('core.footer')
            <!-- End of Footer -->
            
        </div>
        <!-- End of Content Wrapper -->
        
    </div>
                <!-- End of Page Wrapper -->
                
                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>
                
                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Đăng xuất?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Bạn có chắc muốn đăng xuất?</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                                <a class="btn btn-primary" href="{{ route('logout') }}">Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bootstrap core JavaScript-->
                <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                
                <!-- Core plugin JavaScript-->
                <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
                <!-- Moment JS-->
                <script src="{{ asset('vendor/moment-js/moment.min.js') }}"></script>
                <!-- JQ Number JS-->
                <script src="{{ asset('vendor/jquery-number-format/jquery.number.min.js') }}"></script>

                <!-- Data Tables -->
                <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>

                <!-- Chart Js -->
                <script src="{{ asset('vendor/chart-js/dist/Chart.min.js') }}"></script>

                <!-- JQ Block UI-->
                <script src="{{ asset('js/jquery.blockUI.js') }}"></script>
                <!-- Custom scripts for all pages-->
                <script src="{{ asset('js/sb-admin-2.js') }}"></script>

                <!-- Custom scripts for all pages-->
                <script src="{{ asset('js/common.js') }}"></script>
                <script>
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                </script>
                @yield('js')
                <!-- Page level plugins -->
                {{-- <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script> --}}
                
                <!-- Page level custom scripts -->
                {{-- <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script> --}}
                {{-- <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script> --}}
            </body>
            </html>