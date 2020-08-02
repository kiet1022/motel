@extends('core.admin')
@section('title', "Thống kê tháng $month_from - $month_to")
@section('css')
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
                                    <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6>
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
                                    <form action="{{ route('filter_statiscal_compare') }}" method="POST">
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
                                                <label for="my-select">Từ tháng: </label>
                                                <select id="my-select" class="form-control" name="month_from">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" @if ($i == $month_from) {{ "selected" }} @endif>Tháng {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-xs-12 form-group">
                                                <label for="my-select">Đến tháng: </label>
                                                <select id="my-select" class="form-control" name="month_to">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" @if ($i == $month_to) {{ "selected" }} @endif>Tháng {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                        </div>

                                        <div class="text-center">
                                            <button id="btn-submit" type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Thống kê tháng {{ $month_from }} - tháng {{ $month_to }}</h6>
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

                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    
                    
                </div>
                <!-- /.container-fluid -->
@endsection
@section('js')
<script>
var statis_compare_data = @json($arr_data, JSON_PRETTY_PRINT);
var month_from = parseInt(@json($month_from, JSON_PRETTY_PRINT));
var month_to = parseInt(@json($month_to, JSON_PRETTY_PRINT));

var arr_ca_phe = [];
var arr_an_uong = [];
var arr_mua_sam = [];
var arr_ca_nhan = [];
var arr_xang_xe = [];
var arr_tra_gop = [];

statis_compare_data.forEach(function (data){
    var ca_phe = 0;
    var an_uong = 0;
    var mua_sam = 0;
    var ca_nhan = 0;
    var xang_xe = 0;
    var tra_gop = 0;

    for(var i = 0; i < data.length; i++){
        if (data[i].name == "Cà phê, nước uống") {
            ca_phe += parseInt(data[i].total);
        } else if (data[i].name == "Ăn uống") {
            an_uong += parseInt(data[i].total);
        } else if (data[i].name == "Mua sắm") {
            mua_sam += parseInt(data[i].total);
        } else if (data[i].name == "Xăng xe") {
            xang_xe += parseInt(data[i].total);
        } else if (data[i].name == "Trả góp") {
            tra_gop += parseInt(data[i].total);
        } else {
            ca_nhan += parseInt(data[i].total);
        }
    }

    arr_ca_phe.push(ca_phe);
    arr_an_uong.push(an_uong);
    arr_mua_sam.push(mua_sam);
    arr_ca_nhan.push(ca_nhan);
    arr_xang_xe.push(xang_xe);
    arr_tra_gop.push(tra_gop);
});

console.log("ca phe: ", arr_ca_phe);
console.log("an_uong: ", arr_an_uong);
console.log("arr_mua_sam: ", arr_mua_sam);
console.log("arr_ca_nhan: ",arr_ca_nhan);
console.log("arr_tra_gop: ", arr_tra_gop);


var ctx = document.getElementById('myChart').getContext('2d');
var arr_labels = [];

for (var i = month_from; i <= month_to; i++) {
    var label = "Tháng "+i
    arr_labels.push(label);
}

var data = {
        labels: arr_labels,
        datasets: [
            {
                label: 'Ăn uống',
                data: arr_an_uong,
                borderWidth: 3,
                backgroundColor: ['#7fdbda'],
                borderColor: ['#7fdbda'],
                pointBorderColor: ['#7fdbda'],
                pointBackgroundColor: ['#7fdbda'],
                pointStyle: 'star',
                fill: false
            },
            {
                label: 'Cà phê, nước uống',
                data: arr_ca_phe,
                borderWidth: 3,
                backgroundColor:['#ade498'],
                borderColor: ['#ade498'],
                pointBorderColor: ['#ade498'],
                pointBackgroundColor: ['#ade498'],
                pointStyle: 'star',
                fill: false
            },
            {
                label: 'Mua sắm',
                data: arr_mua_sam,
                borderWidth: 3,
                backgroundColor: ['#CCE2CB'],
                borderColor: ['#CCE2CB'],
                pointBorderColor: ['#CCE2CB'],
                pointBackgroundColor: ['#CCE2CB'],
                pointStyle: 'star',
                fill: false
            },
            {
                label: 'Xăng xe',
                data: arr_xang_xe,
                borderWidth: 3,
                backgroundColor: ['#ede682'],
                borderColor: ['#ede682'],
                pointBorderColor: ['#ede682'],
                pointBackgroundColor: ['#ede682'],
                pointStyle: 'star',
                fill: false
            },
            {
                label: 'Nhu cầu cá nhân',
                data: arr_ca_nhan,
                borderWidth: 3,
                backgroundColor: ['#97C1A9'],
                borderColor: ['#97C1A9'],
                pointBorderColor: ['#97C1A9'],
                pointBackgroundColor: ['#97C1A9'],
                pointStyle: 'star',
                fill: false
            },
            {
                label: 'Trả góp',
                data: arr_tra_gop,
                borderWidth: 3,
                backgroundColor: [ '#febf63'],
                borderColor: ['#febf63'],
                pointBorderColor: ['#febf63'],
                pointBackgroundColor: ['#febf63'],
                pointStyle: 'star',
                fill: false
            }
    ]
    };

var myChart = new Chart(ctx, {
    type: 'line',
    data: data,
    options: {
        // title: {
		// 			display: true,
		// 			text: 'Chart.js Line Chart'
        //         },
        // hover: {
        //     mode: 'nearest',
        //     intersect: true
        // },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                    console.log(value);
                    value = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value)
                    return label += (': ' + value);
                }
            }
        },
        scales: {
                xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Tháng'
						}
					}],
                yAxes: [{
                    ticks: {
                        callback: function (value) {
                            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                        }
                    },
                    scaleLabel: {
							display: true,
							labelString: 'Mức chi'
						}
                }]
            }
    }
});
// Block UI when submit form
$('#btn-submit').on('click', function(e){
    blockUI(true);
    $("form").submit();
});
</script>
@endsection