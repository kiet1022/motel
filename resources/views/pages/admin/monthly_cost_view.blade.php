@extends('core.admin')
@section('title', 'Chi tiêu tháng'." $month/$year")
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
            background: #eee; 
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
        /* 
            Max width before this PARTICULAR table gets nasty
            This query will take effect for any screen smaller than 760px
            and also iPads specifically.
        */
    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {
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
        Label the data
        */
        td:nth-of-type(1):before { content: "Ngày chi:"; font-weight: bold;}
        td:nth-of-type(2):before { content: "Lý do chi:"; font-weight: bold;}
        td:nth-of-type(3):before { content: "Đã chi:"; font-weight: bold;}
        td:nth-of-type(4):before { content: "Người chi:"; font-weight: bold;}
        td:nth-of-type(5):before { content: "Phần trăm (Kiệt):"; font-weight: bold;}
        td:nth-of-type(6):before { content: "Thực chi (Kiệt):"; font-weight: bold;}
        td:nth-of-type(7):before { content: "Phần trăm (Thạch):"; font-weight: bold;}
        td:nth-of-type(8):before { content: "Thực chi (Thạch):"; font-weight: bold;}
        td:nth-of-type(9):before { content: "Hóa đơn:"; font-weight: bold;}
        td:nth-of-type(9) { text-align: unset; }
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
                                    <form action="{{ route('filter_monthly_cost') }}" method="POST">
                                        @csrf
                                        <div class="form-row">
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

                                            <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                                                <label for="my-select">Loại chi tiêu: </label>
                                                <select id="my-select" class="form-control" name="type">
                                                    <option value="0" @if ($type == 0) {{ "selected" }} @endif>Chi tiêu chung</option>
                                                    <option value="1" @if ($type == 1) {{ "selected" }} @endif> Chi tiêu cá nhân</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
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
                                @php
                                                $totalOne = 0;
                                                $totalTwo = 0;
                                                $total = 0;
                                                foreach ($costs as $cost) {
                                                    $total += $cost->total;
                                                    if ($type == 0) {
                                                        $totalOne += $cost->total_per_one;
                                                        $totalTwo += $cost->total_per_two;
                                                    }
                                                }
                                            @endphp
                                <!-- Card Body -->
                                <div class="card-body table-responsive">
                                    <div id="tb-total-mobile" class="row mb-3">
                                        <div class="col-12 border text-center" style="font-weight: bold">
                                            <h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($total) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Kiệt: <span class="text-danger">{{ number_format($totalOne) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Thạch: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span>
                                        </div>
                                    </div>
                                    <table id="table1" class="table table-hover tabel-stripped table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Ngày chi</th>
                                                <th>Lý do chi</th>
                                                <th>Số tiền đã chi</th>
                                                <th>Người chi</th>
                                                <th>Phần trăm (Kiệt)</th>
                                                <th>Thực chi (Kiệt)</th>
                                                <th>Phần trăm (Thạch)</th>
                                                <th>Thực chi (Thạch)</th>
                                                <th>Hóa đơn</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($costs as $cost)
                                            @if ($cost->percent_per_one > 0 && $cost->percent_per_two > 0)                                                
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($cost->date)) }}</td>
                                                <td>{{ $cost->payfor }}</td>
                                                <td>{{ number_format($cost->total) }} ₫</td>
                                                <td>{{ $cost->name }}</td>
                                                <td>{{ $cost->percent_per_one }} %</td>
                                                <td style="font-weight: bold;" class="text-danger"> {{ number_format($cost->total_per_one) }} ₫</td>
                                                <td>{{ $cost->percent_per_two }} %</td>
                                                <td style="font-weight: bold;" class="text-danger"> {{ number_format($cost->total_per_two) }} ₫</td>
                                                <td>
                                                    @if (isset($cost->image))
                                                        <a class="btn btn-primary btn-sm" href="{{ asset('img/'.$cost->image) }}" target="_blank">Xem</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a href="{{ route('send_mail')}}" class="btn btn-primary"><i class="fas fa-check"></i> Chốt và Gửi Mail Thông báo</a>
                                    <div id="tb-total">
                                        <table class="table table-hover tabel-stripped table-bordered mt-3">
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center" rowspan="2" colspan="2"><h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($total) }} ₫</span></th>
                                                    <th colspan="8">Kiệt: <span class="text-danger">{{ number_format($totalOne) }} ₫</span></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8">Thạch: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div id="tb-total-mobile" class="row mt-3">
                                        <div class="col-12 border text-center" style="font-weight: bold">
                                            <h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($total) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Kiệt: <span class="text-danger">{{ number_format($totalOne) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Thạch: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    
                    
                </div>
                <!-- /.container-fluid -->
@endsection
@section('js')
    <script>
        var table = $('#table1').DataTable({
            "order": [0, 'desc']
        });
        $(document).ready(function(){
            blockUI(false);
            
            // Block UI when submit form
            $(document).on('submit',"form", function(e){
                blockUI(true);
            });
        })
        
        $('#tb-total').html(
            
        )
    </script>
@endsection