@extends('core.admin')
@section('title', 'Số dư đầu kỳ - cuối kỳ')
@section('css')
    <style>
         /* 
        Generic Styling, for Desktops/Laptops 
        */
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        /* Zebra striping */
        tr:nth-of-type(odd) { 
            background: #f5f8ff; 
        }

        th { 
            background: #fff;
            color: #94879f;
            font-weight: bold; 
        }
        td, th { 
            padding: 6px; 
            border: 1px solid #ccc; 
            text-align: left; 
        }
        td:nth-of-type(9) {
            text-align: center;
        }

        #tb-total-mobile {
            display: none;
        }

        #tb-total {
            display: block;
        }
        td.details-control {
            background: url("{{ asset('img/control/details_open.png') }}") no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url("{{ asset('img/control/details_close.png') }}") no-repeat center center;
        }
        tr.shown>tr {
            background: #fff !important;
        }

        .d-mobile {
            display: block;
        }

        .d-pc {
            display: none;
        }
                /* 
            Max width before this PARTICULAR table gets nasty
            This query will take effect for any screen smaller than 760px
            and also iPads specifically.
        */
    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

        .d-mobile {
            display: none;
        }

        .d-pc {
            display: inline;
        }

        table#table1 {
            width: auto !important;
        }

        table.table-detail {
            width: auto !important;
        }
        #tb-total-mobile {
            display: block;
        }

        #tb-total {
            display: none;
        }
        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr { 
            display: block; 
        }
        
        /* Hide headers (but not display: none;, for accessibility) */
        thead tr { 
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        
        tr { border: 1px solid #ccc; margin-bottom: 5px}
        
        td.details-control {
            background: url("{{ asset('img/control/details_open.png') }}") no-repeat right;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url("{{ asset('img/control/details_close.png') }}") no-repeat right;
        }

        #table1 .table-detail tr:nth-of-type(even) { 
            background: #fff; 
        }

        td { 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            padding-left: 50%;
        }
        
        td:before { 
            /* Now like a header */
            /* position: absolute; */
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
        }
        
        /*
        Label of parent table
        */
        table#table1 td:nth-of-type(1):before { content: "Chi tiết:"; font-weight: bold;}
        table#table1 td:nth-of-type(2):before { content: "Ngày chi:"; font-weight: bold;}
        table#table1 td:nth-of-type(3):before { content: "Đã chi:"; font-weight: bold;}
        table#table1 td:nth-of-type(4):before { content: "Kiệt:"; font-weight: bold;}
        table#table1 td:nth-of-type(5):before { content: "Thạch:"; font-weight: bold;}

        /*
        Label of child table
        */

        #table1 .table-detail td:nth-of-type(1):before { content: "Lý do chi:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(2):before { content: "Đã chi:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(3):before { content: "Người chi:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(4):before { content: "Phần trăm (Kiệt):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(5):before { content: "Thực chi (Kiệt):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(6):before { content: "Phần trăm (Thạch):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(7):before { content: "Thực chi (Thạch):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(8):before { content: "Hóa đơn:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(8) { text-align: unset; }
    }

    .cm-error{
        margin-top:10px !important;
    }

    .cm-ul-error {
        list-style-position: inside;
        color: #e74a3b;
        border: 1px solid #e74a3b;
        border-radius: 7px;
        margin-bottom: 0;
    }

    .cm-ul-error li {
        margin: 5px;
    }
    </style>
@endsection
@section('content')
    
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    
                    <div class="row">
                        
                        <!-- Area Chart -->
                        {{-- <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Chi tiêu tháng {{ $month }}/{{ $year }}</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body table-responsive">
                                    <form action="{{ route('filter_monthly_cost') }}" method="POST">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                                <label for="year">Chọn năm: </label>
                                                <select id="my-select" class="form-control" name="year">
                                                    @for ($i = 2020; $i <= 2025; $i++)
                                                        <option value="{{ $i }}" @if ($i == $year) {{ "selected" }} @endif>Năm {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
    
                                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                                <label for="my-select">Chọn tháng: </label>
                                                <select id="my-select" class="form-control" name="month">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" @if ($i == $month) {{ "selected" }} @endif>Tháng {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                                <label for="my-select">Loại chi tiêu: </label>
                                                <select id="my-select" class="form-control" name="together">
                                                    <option value="1" 
                                                    @if ($together == config('constants.COST_TYPE.TOGETHER')) {{ "selected" }} @endif>Chi tiêu chung</option>
                                                    <option value="0" 
                                                    @if ($together == config('constants.COST_TYPE.PERSONAL')) {{ "selected" }} @endif> Chi tiêu cá nhân</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                                <label for="category">Danh mục: </label>
                                                <select id="category" class="form-control" name="category">
                                                    <option selected disabled>Tất cả chi tiêu</option>
                                                    @foreach ($categories as $ct)
                                                        <option value="{{ $ct->id }}" @if ($ct->id == old('category')) {{ "selected" }} @endif>{{ $ct->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                                <label for="keyword">Tìm kiếm chi tiêu: </label>
                                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Nhập từ khoá" value="{{ old('keyword') }}">
                                            </div>


                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                                        </div>
                                        <hr>
                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <a class="btn btn-success btn-sm" href="{{ route('get_add_daily_cost_view',['together'=>$together]) }}"><i class="fas fa-plus"></i> Thêm chi tiêu</a>
                                            </div>
                                        </div>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Số dư tháng</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <h4>Thêm số dư</h4>
                                        <form id="form1" method="POST" enctype="multipart/form-data" action="{{ route('add_balance') }}" >
                                            @csrf
                                            <div class="form-row">
                                                    
                                                <div class="col-lg-6 col-md-6 col-xs-12 form-group mb-0">
                                                    <label for="my-select">Chọn tháng: </label>
                                                    <select id="my-select" class="form-control" name="month">
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}" @if ($i == 1) {{ "selected" }} @endif>Tháng {{ $i }}</option>
                                                        @endfor
                                                    </select>

                                                    {{-- error --}}
                                                    @if ($errors->get('month'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('month') as $month)
                                                                <li>{{$month}}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-xs-12 form-group mb-0">
                                                    <label for="opening_balance">Số dư đầu kì</label>
                                                    <input type="text" id="opening_balance" class="form-control" placeholder="Nhập số dư đầu kỳ" required>
                                                    <input type="hidden" id="opening_balance_value" name="opening_balance"/>

                                                    {{-- error --}}
                                                    @if ($errors->get('opening_balance'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('opening_balance') as $opening_balance)
                                                                <li>{{$opening_balance}}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-lg-12 text-center mt-3">
                                                    <button type="reset" class="btn btn-primary cm-btn btn-sm">Nhập lại</button>
                                                    <button type="button" class="btn btn-primary cm-btn btn-sm" id="btn-submit">Lưu</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body table-responsive">
                                    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button id="btn-show-modal" type="button" class="btn btn-success btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-plus"></i> Thêm số dư
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Button trigger modal -->
                                    
                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>            
                                    @endif
                                    
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>            
                                    @endif

                                    <table id="table1" class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Tháng</th>
                                                <th>Số dư đầu kì</th>
                                                <th>Số dư cuối kì</th>
                                                <th>Tổng tiền đã sử dụng</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($balances as $bl)
                                            <tr>
                                                <td>{{ $bl->month }}</td>
                                                <td>{{ number_format($bl->opening_balance) }} ₫</td>
                                                <td>{{ number_format($bl->ending_balance) }} ₫</td>
                                                <td>{{ number_format($bl->total_used) }} ₫</td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    
                    </div>
                    
                    
                </div>
                <!-- /.container-fluid -->
@endsection
@section('js')
    <script>
        // var err = "{{$errors->any()}}";
        // if (err) {
        //     $('#btn-show-modal').click();
        // }
        var table = $('#table1').DataTable({});
        
        $(document).ready(function(){
            blockUI(false);
            
            // Block UI when submit form
            $(document).on('submit',"#form1", function(e){
                blockUI(true);
            });
        });
        
        // Format currency
        $('#opening_balance').number(true);
        $('#opening_balance').change(function(){
            $('#opening_balance_value').val($('#opening_balance').val());
        });

        $('#balance_modal').on('hidden.bs.modal', function(e) {
            $(this).find('#form1')[0].reset();
            $('.cm-ul-error').html("");
        });
        
        // Block UI when submit form
        $('#btn-submit').on('click', function(e){
            blockUI(true);
            $("#form1").submit();
        });
    </script>
@endsection