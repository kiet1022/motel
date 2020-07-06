@extends('core.admin')
@section('title', 'Chi tiêu tháng'." $month/$year")
@section('css')
<style>
    td.details-control {
    background: url('../img/control/details_open.png') no-repeat center center;
    cursor: pointer;
  }
  tr.shown td.details-control {
    background: url('../img/control/details_close.png') no-repeat center center;
  }
  tr.shown>tr {
    background: #fff;
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
                                    <table id="table1" class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Chi tiết</th>
                                                <th>Ngày chi</th>
                                                <th>Số tiền đã chi</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($costs as $cost)
                                            <tr>
                                                <td></td>
                                                <td>{{ date("d/m/Y", strtotime($cost[0]->date)) }} </td>
                                                    @php
                                                        $total = 0;
                                                        for ($i = 0; $i < count($cost); $i++){
                                                            $total += $cost[$i]->total;
                                                        }
                                                    @endphp
                                                <td>{{ number_format($total) }} ₫</td>
                                                <td>                                            
                                                    {{ $cost }}
                                                </td>
                                            </tr>
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
            "order": [1, 'desc'],
            columnDefs: [ {
                orderable: false,
                className: 'details-control',
                targets:   0,
            },
            {
                "targets": [ 3 ],
                "visible": false,
                "searchable": false
            },
            { "width": "10%", "targets": 0 }]
        });
        
        $(document).ready(function(){
            blockUI(false);
            
            // Block UI when submit form
            $(document).on('submit',"form", function(e){
                blockUI(true);
            });

            // Show detail of first row
            $('tr td:first').click();
        })
        
        $('#table1 tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var data = JSON.parse(row.data()[3]);
            console.log(data);

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(format(data)).show();
                $.fn.dataTable.ext.errMode = 'none';
                $('table.table-detail').DataTable({
                    columnDefs: [
                    { "width": "5%", "targets": 3 },
                    { "width": "5%", "targets": 5 }],
                });
                tr.addClass('shown');
            }
            } );

    function format (data) {

        console.log(data)
        var count = 0;
        // `d` is the original data object for the row
        var html = '<table class="table table-hover tabel-stripped table-bordered table-detail">';
        html += '<thead>';
        html += '<tr>';
            html += '<th>Lý do chi</th>';
            html += '<th>Số tiền đã chi</th>';
            html += '<th>Người chi</th>';
            html += '<th>Phần trăm (Kiệt)</th>';
            html += '<th>Thực chi (Kiệt)</th>';
            html += '<th>Phần trăm (Thạch)</th>';
            html += '<th>Thực chi (Thạch)</th>';
            html += '<th>Hóa đơn</th></tr>';
        html += '</tr>';                                     
        html += '</thead>';
        html += '<tbody>';

        data.forEach(element => {
        html += '<tr>';
            html += '<td>'+element.payfor+'</td>';
            html += '<td>'+numberFormat(element.total)+'</td>';
            html += '<td>'+element.name+'</td>';
            html += '<td>'+element.percent_per_one+'%</td>';
            html += '<td style="font-weight: bold;" class="text-danger">'+numberFormat(element.total_per_one)+'</td>';
            html += '<td>'+element.percent_per_two+'%</td>';
            html += '<td style="font-weight: bold;" class="text-danger">'+numberFormat(element.total_per_two)+'</td>';
            if (element.image != null) {
                html += '<td><a class="btn btn-primary btn-sm" href="../img/'+element.image+'" target="_blank">Xem</a></td>';
            } else {
                html += '<td></td>';
            }
        html += '</tr>';
        });
        html += '</tbody>';
        html += '</table>';
        return html;
    }
    /**
 * Format number to currency
 * 
 * @param {Integer} number the number that will be formated
 */
function numberFormat(number){
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}
    </script>
@endsection