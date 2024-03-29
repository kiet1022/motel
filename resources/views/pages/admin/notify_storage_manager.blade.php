@extends('core.admin')
@section('title', 'Quản lý thông báo và bộ nhớ')
@section('css')
<style>
        .btn-danger {
            color: #fff;
        }
        .btn {
            margin: 5px;
        }
        /* 
        Generic Styling, for Desktops/Laptops 
        */
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        /* Zebra striping */
        tr:nth-of-type(odd) { 
            background: #eee; 
        }
        th { 
            background: #333; 
            color: white; 
            font-weight: bold; 
        }
        td, th { 
            padding: 6px; 
            border: 1px solid #ccc; 
            text-align: left; 
        }
        td:nth-of-type(7) {
            text-align: center;
        }
        /* 
            Max width before this PARTICULAR table gets nasty
            This query will take effect for any screen smaller than 760px
            and also iPads specifically.
        */
    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {
        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr { 
            display: block; 
        }
        
        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr { 
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        
        tr { border: 1px solid #ccc; margin-bottom: 5px}
        
        td { 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            padding-left: 50%; 
        }
        
        td:before { 
            /* Now like a table header */
            /* position: absolute; */
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
        }
        
        /*
        Label the data
        */
        td:nth-of-type(1):before { content: "Nội dung:"; font-weight: bold;}
        td:nth-of-type(2):before { content: "Ngày giao dịch:"; font-weight: bold;}
        td:nth-of-type(3):before { content: "Số tiền:"; font-weight: bold;}
        td:nth-of-type(4):before { content: "Kỳ trả góp:"; font-weight: bold;}
        td:nth-of-type(5):before { content: "Bắt đầu - kết thúc:"; font-weight: bold;}
        td:nth-of-type(6):before { content: "Đã trả:"; font-weight: bold;}
        td:nth-of-type(7):before { content: "Còn lại:"; font-weight: bold;}
        td:nth-of-type(7) { text-align: unset; }
        td:nth-of-type(8):before { content: "Chi tiết:"; font-weight: bold;}
    }
</style>
@endsection
@section('content')
    
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Quản lý các khoản trả góp</h6>
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
                                    {{-- <a class="btn btn-success btn-sm" href="{{ route('get_add_daily_cost_view',['together'=>$together]) }}"><i class="fas fa-plus"></i> Thêm chi tiêu</a> --}}
                                    <hr>
                                    <table id="table" class="table table-hover tabel-stripped table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Tháng</th>
                                                <th>Năm</th>
                                                <th>Trạng thái thông báo</th>
                                                <th>Trạng thái dọn dẹp</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($managers as $mng)
                                            <tr>
                                                <td>{{ $mng->month}}</td>
                                                <td>{{ $mng->year}}</td>
                                                <td class="text-center">{!! showStatusForNotify($mng->notify_status) !!}</td>
                                                <td class="text-center">{!! showStatusForStorage($mng->storage_status) !!}</td>
                                                <td class="text-center">
                                                    @if ($mng->notify_status == 0)
                                                        <a href="{{ route('send_mail',['month' => $mng->month, 'id' => $mng->id])}}" class="btn btn-primary btn-sm btn-action"><i class="fas fa-envelope"></i> Gửi mail</a>
                                                    @endif
                                                    @if ($mng->storage_status == 0)
                                                        <a href="{{ route('clean_storage',['id' => $mng->id])}}" class="btn btn-primary btn-sm btn-action"><i class="fas fa-trash"></i> Dọn dẹp hoá đơn</a>
                                                    @endif
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
        $(document).ready(function(){
            blockUI(false);
            $('#table').DataTable({
                orderable: false
            });

            $('.btn-action').click(function(){
                blockUI(true);
            })
        })
    </script>
@endsection