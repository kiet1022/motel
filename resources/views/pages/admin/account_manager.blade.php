@extends('core.admin')
@section('title', 'Quản lý tài khoản')
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
        table#table1 td:nth-of-type(1):before { content: "Tên tài khoản:"; font-weight: bold;}
        table#table1 td:nth-of-type(2):before { content: "Username:"; font-weight: bold;}
        table#table1 td:nth-of-type(3):before { content: "Password:"; font-weight: bold;}

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
                                    <h6 class="m-0 font-weight-bold text-primary">Quản lý tài khoản</h6>
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
                                <!-- Add account -->
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <h4>Thêm Tài Khoản</h4>
                                        <form id="form1" method="POST" action="{{ route('add_account') }}" >
                                            @csrf
                                            <div class="form-row">
                                                    
                                                <div class="col-lg-4 col-md-4 col-xs-12 form-group mb-0">
                                                    <label for="account_name">Tên</label>
                                                    <input type="text" id="account_name" class="form-control" name="name" placeholder="Nhập tên" required>
                                                    {{-- error --}}
                                                    @if ($errors->get('account_name'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('account_name') as $account_name)
                                                                <li>{{$account_name}}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-xs-12 form-group mb-0">
                                                    <label for="account_id">Username</label>
                                                    <input type="text" id="account_id" class="form-control" name="username" placeholder="Nhập username" required>
                                                    {{-- error --}}
                                                    @if ($errors->get('account_id'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('account_id') as $account_id)
                                                                <li>{{$account_id}}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-xs-12 form-group mb-0">
                                                    <label for="account_pass">Pass</label>
                                                    <input type="text" id="account_pass" class="form-control" name="pass" placeholder="Nhập pass" required>
                                                    {{-- error --}}
                                                    @if ($errors->get('account_pass'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('account_pass') as $account_pass)
                                                                <li>{{$account_pass}}</li>
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
                                <!-- Add account -->

                                <!-- Edit account -->
                                <div class="collapse" id="editAccountCollapse">
                                    <div class="card card-body">
                                        <h4>Sửa Tài Khoản</h4>
                                        <form id="form-edit-account" method="POST" action="{{ route('edit_account') }}" >
                                            @csrf
                                            <div class="form-row">
                                                    
                                                <div class="col-lg-4 col-md-4 col-xs-12 form-group mb-0">
                                                    <label for="account_name_edit">Tên</label>
                                                    <input type="hidden" id="account_id_edit" name="id">
                                                    <input type="text" id="account_name_edit" class="form-control" name="name" placeholder="Nhập tên" required>
                                                    {{-- error --}}
                                                    @if ($errors->get('name'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('name') as $name)
                                                                <li>{{$name}}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-xs-12 form-group mb-0">
                                                    <label for="account_username_edit">Username</label>
                                                    <input type="text" id="account_username_edit" class="form-control" name="username" placeholder="Nhập username" required>
                                                    {{-- error --}}
                                                    @if ($errors->get('username'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('username') as $username)
                                                                <li>{{$username}}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-lg-4 col-md-4 col-xs-12 form-group mb-0">
                                                    <label for="account_pass_edit">Pass</label>
                                                    <input type="text" id="account_pass_edit" class="form-control" name="pass" placeholder="Nhập pass" required>
                                                    {{-- error --}}
                                                    @if ($errors->get('pass'))
                                                        <div class="cm-inline-form cm-error">
                                                            <ul class="cm-ul-error" style="padding-left: 0px;">
                                                            @foreach ($errors->get('pass') as $pass)
                                                                <li>{{$pass}}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-lg-12 text-center mt-3">
                                                    <button type="reset" class="btn btn-primary cm-btn btn-sm">Nhập lại</button>
                                                    <button type="button" class="btn btn-primary cm-btn btn-sm" id="btn-edit-submit">Lưu</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Add account -->

                                <!-- Card Body -->
                                <div class="card-body table-responsive">
                                    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button id="btn-show-modal" type="button" class="btn btn-success btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-plus"></i> Thêm account
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
                                                <th>Tên tài khoản</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($accounts as $account)
                                            <tr>
                                                <td>{{ $account->name }}</td>
                                                <td>{{ $account->username }}</td>
                                                <td>{{ $account->pass }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-info account-edit-btn" data-value="{{ $account }}"><i class="fas fa-edit"></i></button>
                                                    <a href="{{ route('delete_account',['id'=>$account->id]) }}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                                                </td>
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
        var err = "{{$errors->any()}}";
        if (err) {
            $('#btn-show-modal').click();
        }
        var table = $('#table1').DataTable({});
        
        $(document).ready(function(){
            blockUI(false);
            
            // Block UI when submit form
            $(document).on('submit',"form", function(e){
                blockUI(true);
            });
        });
        

        
        // Block UI when submit form
        $('#btn-submit').on('click', function(e){
            $("#form1").submit();
        });
        $('#btn-edit-submit').on('click', function(e){
            $("#form-edit-account").submit();
        });

        //
        $('.account-edit-btn').on('click', function(e){
            let account = $(this).data('value');

            $('#account_id_edit').val(account.id);
            $('#account_name_edit').val(account.name);
            $('#account_username_edit').val(account.username);
            $('#account_pass_edit').val(account.pass);
            if (!$('#editAccountCollapse').hasClass('show')){
                $('#editAccountCollapse').collapse('show');
            }
        });
    </script>
@endsection