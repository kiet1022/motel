@extends('core.admin')
@section('title', 'Chi tiêu tháng'." $month/$year")
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
                                                <select id="my-select" class="form-control" name="together">
                                                    <option value="1" 
                                                    @if ($together == config('constants.COST_TYPE.TOGETHER')) {{ "selected" }} @endif>Chi tiêu chung</option>
                                                    <option value="0" 
                                                    @if ($together == config('constants.COST_TYPE.PERSONAL')) {{ "selected" }} @endif> Chi tiêu cá nhân</option>
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
                                {{-- @php
                                                $totalOne = 0;
                                                $totalTwo = 0;
                                                $total = 0;
                                                foreach ($costs as $cost) {
                                                    $total += $cost->total;
                                                    if ($together == config('constants.COST_TYPE.TOGETHER')) {
                                                        $totalOne += $cost->total_per_one;
                                                        $totalTwo += $cost->total_per_two;
                                                    }
                                                }
                                            @endphp --}}
                                <!-- Card Body -->
                                <div class="card-body table-responsive">
                                    {{-- <div id="tb-total-mobile" class="row mb-3">
                                        <div class="col-12 border text-center" style="font-weight: bold">
                                            <h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($total) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Kiệt: <span class="text-danger">{{ number_format($totalOne) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Thạch: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span>
                                        </div>
                                    </div> --}}
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
                                            {{$cost[0]->date}}
                                            @for ($i=0; $i < count($cost); $i++)
                                            {{$cost[$i]->payfor}}
                                            @endfor
                                            {{-- @php for ($i=0; $i < count($cost); $i++) { 
                                                echo $cost[$i]->payfor;
                                            }
                                            @endphp --}}
                                            {{-- {{count($cost)}} --}}
                                            {{-- @foreach ($cost as $ct)
                                            {{$ct}}
                                            @endforeach --}}
                                                
                                            {{-- <tr>
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
                                            </tr> --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a href="{{ route('send_mail')}}" class="btn btn-primary"><i class="fas fa-envelope"></i> Gửi Mail</a>

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