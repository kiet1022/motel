@extends('core.admin')
@section('title', 'Chi tiêu chung')
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
        td:nth-of-type(1):before { content: "Ngày chi:"; font-weight: bold;}
        td:nth-of-type(2):before { content: "Lý do chi:"; font-weight: bold;}
        td:nth-of-type(3):before { content: "Đã chi:"; font-weight: bold;}
        td:nth-of-type(4):before { content: "Người chi:"; font-weight: bold;}
        td:nth-of-type(5):before { content: "Phần trăm:"; font-weight: bold;}
        td:nth-of-type(6):before { content: "Thực chi:"; font-weight: bold;}
        td:nth-of-type(7):before { content: "Hóa đơn:"; font-weight: bold;}
        td:nth-of-type(7) { text-align: unset; }
        td:nth-of-type(8):before { content: "";}
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
                                    <form action="{{ route('filter_daily_cost') }}" method="POST">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-lg-2 col-md-2 col-xs-0 form-group"></div>
                                            <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                                                <label for="year">Chọn năm: </label>
                                                <select id="my-select" class="form-control" name="year">
                                                    @for ($i = 2020; $i <= 2025; $i++)
                                                        <option value="{{ $i }}" @if ($i == $year) {{ "selected" }} @endif>Năm {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
    
                                            <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                                                <label for="my-select">Chọn tháng: </label>
                                                <select id="my-select" class="form-control" name="month">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" @if ($i == $month) {{ "selected" }} @endif>Tháng {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <input type="hidden" name="together" value="{{$together}}" >
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Lọc</button><br>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Quản lý chi tiêu hàng ngày</h6>
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
                                    <a class="btn btn-success btn-sm" href="{{ route('get_add_daily_cost_view',['together'=>$together]) }}"><i class="fas fa-plus"></i> Thêm chi tiêu</a>
                                    <hr>
                                    <table id="table" class="table table-hover tabel-stripped table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Ngày chi</th>
                                                <th>Lý do chi</th>
                                                <th>Số tiền đã chi</th>
                                                <th>Người chi</th>
                                                <th>Phần trăm</th>
                                                <th>Thực chi</th>
                                                <th>Hóa đơn</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($costs as $cost)
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($cost->date)) }}</td>
                                                <td>{{ $cost->payfor }}</td>
                                                <td>{{ number_format($cost->total) }} ₫</td>
                                                <td>{{ $cost->name }}</td>
                                                <td>
                                                    @if ($cost->payer == 1)
                                                        {{ $cost->percent_per_one }} %
                                                    @elseif ($cost->payer == 2)
                                                        {{ $cost->percent_per_two }} %
                                                    @endif
                                                </td>   
                                                <td>
                                                    @if ($cost->payer == 1)
                                                        {{ number_format($cost->total_per_one) }}
                                                    @elseif ($cost->payer == 2)
                                                        {{ number_format($cost->total_per_two) }}
                                                    @endif ₫
                                                </td>
                                                <td>
                                                    @if (isset($cost->image))
                                                        <a class="btn btn-primary btn-sm" href="{{ asset('img/'.$cost->image) }}" target="_blank">Xem</a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('get_edit_daily_cost_view',['id'=>$cost->id,'together'=>$together]) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('get_delete_daily_cost',['id'=>$cost->id]) }}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
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
                "order": [0, 'desc']
            });

            $('.delete').click(function(){
                blockUI(true);
            })
            $(document).on('submit',"form", function(e){
            blockUI(true);
        });
        })
    </script>
@endsection