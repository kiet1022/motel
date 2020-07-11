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
        table#table1 td:nth-of-type(4):before { content: "Chia:"; font-weight: bold;}
        table#table1 td:nth-of-type(5):before { content: ""; font-weight: bold;}

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
                                @php
                                    $totalOne = 0;
                                    $totalTwo = 0;
                                    $totalShow = 0;
                                    foreach ($costs as $cost) {
                                        foreach ($cost as $ct) {
                                            $totalShow += $ct->total;
                                            $totalOne += $ct->total_per_one;
                                            $totalTwo += $ct->total_per_two;
                                        }
                                    }
                                @endphp
                                <!-- Card Body -->
                                <div class="card-body table-responsive">
                                    <div id="tb-total-mobile" class="row mb-3">
                                        <div class="col-12 border text-center" style="font-weight: bold">
                                            <h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($totalShow) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Kiệt: <span class="text-danger">{{ number_format($totalOne) }} ₫</span>
                                        </div>
                                        <div class="col-12 border" style="font-weight: bold">
                                            Thạch: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span>
                                        </div>
                                    </div>
                                    <table id="table1" class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Chi tiết</th>
                                                <th>Ngày chi</th>
                                                <th>Số tiền đã chi</th>
                                                <th>Chia đầu người</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            @foreach ($costs as $cost)
                                            <tr>
                                                <td></td>
                                                <td>{{ showDateInDMY($cost[0]->date) }} <br class="d-mobile"> <span class="d-pc"> - </span> <span style="font-weight: bold;" class="text-danger">{{ convertEnDayToViDay($cost[0]->date) }}</span> </td>
                                                    @php
                                                        $total = 0;
                                                        $ttOne = 0;
                                                        $ttTwo = 0;
                                                        for ($i = 0; $i < count($cost); $i++){
                                                            $total += $cost[$i]->total;
                                                            $ttOne += $cost[$i]->total_per_one;
                                                            $ttTwo += $cost[$i]->total_per_two;
                                                        }
                                                    @endphp
                                                <td style="font-weight: bold;" class="text-danger">{{ number_format($total) }} ₫</td>
                                                <td>
                                                    <span style="font-weight: normal;" class="text-primary">Kiệt: {{number_format($ttOne)}} ₫ - Thạch: {{number_format($ttTwo)}} ₫</span>
                                                </td>
                                                <td>                                            
                                                    {{ $cost }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a href="{{ route('send_mail')}}" class="btn btn-primary"><i class="fas fa-envelope"></i> Gửi Mail</a>
                                    <div id="tb-total">
                                        <table class="table table-hover tabel-stripped table-bordered mt-3">
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center" rowspan="2" colspan="2"><h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($totalShow) }} ₫</span></th>
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
                                            <h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($totalShow) }} ₫</span>
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
            "order": [1, 'desc'],
            columnDefs: [ {
                orderable: false,
                className: 'details-control',
                targets:   0,
            },
            {
                "targets": [ 4 ],
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
            // $('tr td:first').click();
        })
        
        $('#table1 tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var data = JSON.parse(row.data()[4]);
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
                html += '<td><a class="btn btn-primary btn-sm" href="../../../img/'+element.image+'" target="_blank">Xem</a></td>';
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