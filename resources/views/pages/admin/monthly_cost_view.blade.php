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
        table#table1 td:nth-of-type(4):before { content: "Kiệt:"; font-weight: bold;}
        table#table1 td:nth-of-type(5):before { content: "Huyền:"; font-weight: bold;}
        table#table1 td:nth-of-type(6):before { content: "Hùng:"; font-weight: bold;}
        table#table1 td:nth-of-type(7):before { content: "Long:"; font-weight: bold;}
        
        /*
        Label of child table
        */
        
        #table1 .table-detail td:nth-of-type(1):before { content: "Lý do chi:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(2):before { content: "Đã chi:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(3):before { content: "Người chi:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(4):before { content: "Thực chi (Kiệt):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(5):before { content: "Thực chi (Huyền):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(6):before { content: "Thực chi (Hùng):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(7):before { content: "Thực chi (Long):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(8):before { content: "Thực chi (Khác):"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(9):before { content: "Hóa đơn:"; font-weight: bold;}
        #table1 .table-detail td:nth-of-type(9) { text-align: unset; }
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
                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                <label for="year">Chọn năm: </label>
                                <select id="year" class="form-control" name="year">
                                    @for ($i = 2020; $i <= 2025; $i++)
                                    <option value="{{ $i }}" @if ($i == $year) {{ "selected" }} @endif>Năm {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                <label for="month">Chọn tháng: </label>
                                <select id="month" class="form-control" name="month">
                                    @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" @if ($i == $month) {{ "selected" }} @endif>Tháng {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            
                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                <label for="together">Loại chi tiêu: </label>
                                <select id="together" class="form-control" name="together">
                                    <option value="1" 
                                    @if ($together == config('constants.COST_TYPE.TOGETHER')) {{ "selected" }} @endif>Chi tiêu chung</option>
                                    <option value="0" 
                                    @if ($together == config('constants.COST_TYPE.PERSONAL')) {{ "selected" }} @endif> Chi tiêu cá nhân</option>
                                </select>
                            </div>
                            
                            <div id="category-filter" class="col-lg-3 col-md-3 col-xs-12 form-group">
                                <label for="category">Danh mục: </label>
                                <select id="category" class="form-control" name="category">
                                    <option value="" selected>Tất cả chi tiêu</option>
                                    @foreach ($categories as $ct)
                                    <option value="{{ $ct->id }}" @if ($ct->id == old('category')) {{ "selected" }} @endif>{{ $ct->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-3 col-md-3 col-xs-12 form-group">
                                <label for="keyword">Tìm kiếm chi tiêu: </label>
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Nhập từ khoá" value="{{ old('keyword') }}">
                            </div>
                            <input type="hidden" id="together-value" value="{{ $together }}">
                            
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                        </div>
                        <hr>
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <a class="btn btn-success btn-sm" href="{{ route('get_add_daily_cost_view',['together'=>$together]) }}">
                                    <i class="fas fa-plus"></i> Thêm chi tiêu
                                </a>
                            </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
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
                $totalThree = 0;
                $totalShow = 0;
                $totalFour = 0;

                // Da chi
                $spentOne = 0;
                $spentTwo = 0;
                $spentThree = 0;
                $spentFour = 0;
                
                foreach ($costs as $cost) {
                    // dd($cost[1]->total);
                    // $totalShow += $cost->total;
                    foreach ($cost as $ct) {
                        $totalShow += $ct->total;
                        // Thuc chi
                        switch ($ct->payer) {
                            case 1: // Kiet
                                $spentOne += $ct->total;
                                break;
                            case 3: // Huyen
                                $spentTwo += $ct->total;
                                break;
                            case 4: // Hung
                                $spentThree += $ct->total;
                                break;
                            case 5: // Long
                                $spentFour += $ct->total;
                                break;
                        }

                        foreach ($ct->details as $detail) {
                            switch ($detail->user_id) {
                            case 1: // Kiet
                                $totalOne += $detail->cost;
                                break;
                            case 3: // Huyen
                                $totalTwo += $detail->cost;
                                break;
                            case 4: // Hung
                                $totalThree += $detail->cost;
                                break;
                            case 5: // Long
                                $totalFour += $detail->cost;
                                break;
                        }
                        }
                    }
                }
                @endphp
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
                    <div id="tb-total-mobile" class="row mt-3">
                        <div class="col-12 border text-center" style="font-weight: bold">
                            <h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($totalShow) }} ₫</span>
                        </div>
                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Kiệt</span> ({!! showFinalCost($spentOne - $totalOne) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalOne) }} ₫</span>
                            <br>Đã chi: <span class="text-danger">{{ number_format($spentOne) }} ₫</span>
                        </div>
                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Huyền</span> ({!! showFinalCost($spentTwo - $totalTwo) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span>
                            <br>Đã chi:<span class="text-danger"> {{ number_format($spentTwo) }} ₫</span>
                        </div>
                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Hùng</span> ({!! showFinalCost($spentThree - $totalThree) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalThree) }} ₫</span>
                            <br>Đã chi: <span class="text-danger">{{ number_format($spentThree) }} ₫</span>
                        </div>
                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Long</span> ({!! showFinalCost($spentFour - $totalFour) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalFour) }} ₫</span>
                            <br>Đã chi: <span class="text-danger">{{ number_format($spentFour) }} ₫</span>
                        </div>
                    </div>
                    <table id="table1" class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Chi tiết</th>
                                <th>Ngày chi</th>
                                <th>Số tiền đã chi</th>
                                <th>Kiệt</th>
                                <th>Huyền</th>
                                <th>Hùng</th>
                                <th>Long</th>
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
                                $ttThree = 0;
                                $ttFour = 0;
                                for ($i = 0; $i < count($cost); $i++){
                                    $total += $cost[$i]->total;
                                    for ($j = 0; $j < count($cost[$i]->details); $j++){
                                        $user_id = $cost[$i]->details[$j]->user_id;
                                        switch ($user_id) {
                                            case 1: // Kiet
                                                $ttOne += $cost[$i]->details[$j]->cost;
                                                break;
                                            case 3: // Huyen
                                                $ttTwo += $cost[$i]->details[$j]->cost;
                                                break;
                                            case 4: // Hung
                                                $ttThree += $cost[$i]->details[$j]->cost;
                                                break;
                                            case 5: // Long
                                                $ttFour += $cost[$i]->details[$j]->cost;
                                                break;
                                        }
                                    }
                                    // $percent = explode(",", $cost[$i]->percent);
                                    // $ttOne += $cost[$i]->tt * ($percent[0]/100);
                                    // $ttTwo += $cost[$i]->total * ($percent[1]/100);
                                    // $ttThree += $cost[$i]->total * ($percent[2]/100);
                                    // $ttFour += $cost[$i]->total * ($percent[3]/100);
                                }
                                @endphp
                                <td style="font-weight: bold;" class="text-danger">{{ number_format($total) }} ₫</td>
                                <td>
                                    <span style="font-weight: normal;" class="text-primary">{{number_format($ttOne)}} ₫</span>
                                </td>
                                <td>
                                    <span style="font-weight: normal;" class="text-primary">{{number_format($ttTwo)}} ₫</span>
                                </td>
                                <td>
                                    <span style="font-weight: normal;" class="text-primary">{{number_format($ttThree)}} ₫</span>
                                </td>
                                <td>
                                    <span style="font-weight: normal;" class="text-primary">{{number_format($ttFour)}} ₫</span>
                                </td>
                                <td>                                            
                                    {!! $cost !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <a class="btn btn-success btn-sm" href="{{ route('get_add_daily_cost_view',['together'=>$together]) }}"><i class="fas fa-plus"></i> Thêm chi tiêu</a>
                        </div>
                    </div>
                    <div id="tb-total">
                        <table class="table table-hover tabel-stripped table-bordered mt-3">
                            <tfoot>
                                <tr>
                                    <th class="text-center" rowspan="5" colspan="2"><h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($totalShow) }} ₫</span></th>
                                    <th colspan="8" class="text-center"><h4>Thực chi</h4></th>
                                    <th colspan="8" class="text-center"><h4>Đã chi</h4></th>
                                </tr>
                                <tr>
                                    
                                    <th colspan="8">Kiệt: <span class="text-danger">{{ number_format($totalOne) }} ₫</span></th>
                                    <th colspan="8">Kiệt: <span class="text-danger">{{ number_format($spentOne) }} ₫</span></th>
                                </tr>
                                <tr>
                                    <th colspan="8">Huyền: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span></th>
                                    <th colspan="8">Huyền: <span class="text-danger">{{ number_format($spentTwo) }} ₫</span></th>
                                </tr>
                                <tr>
                                    <th colspan="8">Hùng: <span class="text-danger">{{ number_format($totalThree) }} ₫</span></th>
                                    <th colspan="8">Hùng: <span class="text-danger">{{ number_format($spentThree) }} ₫</span></th>
                                </tr>
                                <tr>
                                    <th colspan="8">Long: <span class="text-danger">{{ number_format($totalFour) }} ₫</span></th>
                                    <th colspan="8">Long: <span class="text-danger">{{ number_format($spentFour) }} ₫</span></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="tb-total-mobile" class="row mt-3">
                        <div class="col-12 border text-center" style="font-weight: bold">
                            <h4>Tổng tiền:</h4> <span class="text-danger">{{ number_format($totalShow) }} ₫</span>
                        </div>
                        @php

                        @endphp

                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Kiệt</span> ({!! showFinalCost($spentOne - $totalOne) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalOne) }} ₫</span>
                            <br>Đã chi: <span class="text-danger">{{ number_format($spentOne) }} ₫</span>
                        </div>
                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Huyền</span> ({!! showFinalCost($spentTwo - $totalTwo) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalTwo) }} ₫</span>
                            <br>Đã chi:<span class="text-danger"> {{ number_format($spentTwo) }} ₫</span>
                        </div>
                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Hùng</span> ({!! showFinalCost($spentThree - $totalThree) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalThree) }} ₫</span>
                            <br>Đã chi: <span class="text-danger">{{ number_format($spentThree) }} ₫</span>
                        </div>
                        <div class="col-12 border" style="font-weight: bold">
                            <span class="text-primary">Long</span> ({!! showFinalCost($spentFour - $totalFour) !!})
                            <br>Thực chi: <span class="text-danger">{{ number_format($totalFour) }} ₫</span>
                            <br>Đã chi: <span class="text-danger">{{ number_format($spentFour) }} ₫</span>
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
    var BASE_EDIT_URL = "{{ asset('admin/editDailyCost/') }}";
    var BASE_DELETE_URL = "{{ asset('admin/deleteDailyCost/') }}";
    
    var table = $('#table1').DataTable({
        "order": [1, 'desc'],
        columnDefs: [ {
            orderable: false,
            className: 'details-control',
            targets:   0,
        },
        {
            "targets": [ 7 ],
            "visible": false,
            "searchable": false
        },
        { "width": "10%", "targets": 0 }]
    });
    
    $('.send-mail').click(function() {
        blockUI(true);
    })
    $(document).ready(function(){
        blockUI(false);
        
        // Block UI when submit form
        $(document).on('submit',"form", function(e){
            blockUI(true);
        });
        
        // Show detail of first row
        // $('tr td:first').click();
        checkCategorySelect($('#together'))
    })
    
    function checkCategorySelect(togertherSelect) {
        var val = togertherSelect.val();
        if(val == "1") {
            $('#category-filter').addClass('d-none');
            $('#category').attr('disabled',true);
            
        } else  {
            $('#category-filter').removeClass('d-none');
            $('#category').attr('disabled',false);
        }
    }
    
    $('#together').on('change',function(){
        checkCategorySelect($(this));
    })
    
    $('#table1 tbody').on('click', 'td.details-control', function () {
        try {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var data = JSON.parse(row.data()[7]);
            
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(format(data)).show();
                // $.fn.dataTable.ext.errMode = 'none';
                $('table.table-detail').DataTable({
                    // columnDefs: [
                    // { "width": "5%", "targets": 3 },
                    // { "width": "5%", "targets": 1 }],
                });
                tr.addClass('shown');
            }
        } catch (error) {
            console.log(error);
        }
        
    } );
    
    function format (data) {
        
        // console.log(data)
        var isTogether = $('#together-value').val();
        var count = 0;
        // `d` is the original data object for the row
        var html = '<table class="table table-hover tabel-stripped table-bordered table-detail">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Lý do chi</th>';
            html += '<th>Số tiền đã chi</th>';
            html += '<th>Người chi</th>';
            if (isTogether == 1) {
                html += '<th>Thực chi (Kiệt)</th>';
                html += '<th>Thực chi (Huyền)</th>';
                html += '<th>Thực chi (Hùng)</th>';
                html += '<th>Thực chi (Long)</th>';
                html += '<th>Thực chi (Khác)</th>';
            }
            html += '<th>Hóa đơn</th>';
            html += '<th></th></tr>';
            html += '</tr>';                                     
            html += '</thead>';
            html += '<tbody>';
            data.forEach(element => {
                console.log(element);
                html += '<tr>';
                html += '<td>'+element.payfor+'</td>';
                html += '<td style="font-weight: bold;" class="text-danger">'+numberFormat(element.total)+'</td>';
                html += '<td>'+element.name+'</td>';
                if (isTogether == 1) {
                    var costKiet = 0, costHuyen = 0, costHung = 0, costLong = 0, costOther = 0;
                    var nameOther = "";
                    for (var i = 0; i < element.details.length; i++) {
                        var user_id = element.details[i].user_id;
                        switch (user_id) {
                            case 1: // Kiet
                                costKiet += element.details[i].cost;
                                break;
                            case 3: // Huyen
                                costHuyen += element.details[i].cost;
                                break;
                            case 4: // Hung
                                costHung += element.details[i].cost;
                                break;
                            case 5: // Long
                                costLong += element.details[i].cost;
                                break;
                            case 0: 
                                costOther += element.details[i].cost;
                                nameOther += element.details[i].name+" ";
                                break;
                        }
                    }
                    html += '<td style="font-weight: bold;"><span class="text-danger">'+numberFormat(costKiet)+'</span></td>';
                    html += '<td style="font-weight: bold;"><span class="text-danger">'+numberFormat(costHuyen)+'</span></td>';
                    html += '<td style="font-weight: bold;"><span class="text-danger">'+numberFormat(costHung)+'</span></td>';
                    html += '<td style="font-weight: bold;"><span class="text-danger">'+numberFormat(costLong)+'</span></td>';
                    html += '<td style="font-weight: bold;"><span class="text-danger">'+numberFormat(costOther)+'<br>'+nameOther+'</span></td>';
                }
                
                if (element.image) {
                    if (element.image == "removed") {
                        html += '<td class="text-center"><span class="badge badge-warning">Hoá đơn đã được xoá</span></td>';
                    } else {
                        html += '<td><a class="btn btn-primary btn-sm" href="../../../img/'+element.image+'" target="_blank">Xem</a></td>';
                    }
                } else {
                    html += '<td></td>';
                }
                html += '<td><a href="'+BASE_EDIT_URL+'/'+element.id+'/'+element.is_together+'" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>';
                html += '&nbsp;&nbsp;'
                html += '<a href="'+BASE_DELETE_URL+'/'+element.id+'" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a></td>';
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