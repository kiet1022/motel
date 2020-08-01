@extends('core.admin')
@section('title', 'Chi phí cố định')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    
    <div class="row">
        
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Chi phí cố định</h6>
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
                    
                    <form class="row" method="POST" enctype="multipart/form-data" action="{{ route('add_fixed_cost') }}" >
                        @csrf
                        <div class="col-lg-6 form-group">
                            <label for="date">Ngày chi</label>
                            <input type="date" id="date" class="form-control" name="date" required>
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="room_fee_value">Tiền phòng</label>
                            <input type="text" id="room_fee_value" class="form-control currency" placeholder="Nhập nội dung" value="2600000" disabled>
                            <input type="hidden" id="room_fee" name="room_fee">
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="water_fee_value">Tiền nước</label>
                            <input type="text" id="water_fee_value" class="form-control currency" placeholder="Nhập nội dung" value="100000" disabled>
                            <input type="hidden" id="water_fee" name="water_fee">
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="trash_fee_value">Tiền rác</label>
                            <input type="text" id="trash_fee_value" class="form-control currency" placeholder="Nhập nội dung" value="25000" disabled>
                            <input type="hidden" id="trash_fee" name="trash_fee">
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="ele_num">Số điện</label>
                            <input type="text" id="ele_num" class="form-control" name="ele_num"  placeholder="Nhập số điện" required>
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="ele_fee_value">Tiền điện (3.5K/Ký)</label>
                            <input type="text" id="ele_fee_value" class="form-control currency" placeholder="Nhập nội dung" value="0" disabled>
                            <input type="hidden" id="ele_fee" name="ele_fee">
                        </div>

                        <div class="col-lg-12">
                            <label for="image">Ảnh hóa đơn (nếu có)</label>
                            <input type="file" id="image" class="form-control" name="image">
                        </div>
                        
                        <div class="col-lg-12 text-center mt-3">
                            <button type="button" class="btn btn-primary cm-btn" id="btn-submit">Lưu</button>
                        </div>
                    </form>
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
        // Get current day
        var now = moment().format('YYYY-MM-DD');
        $('#date').val(now);
        
         // Format currency
        $('.currency').number(true);

        //
        $('#room_fee').val($('#room_fee_value').val());
        $('#water_fee').val($('#water_fee_value').val());
        $('#trash_fee').val($('#trash_fee_value').val());
        $('#ele_fee').val($('#ele_fee_value').val());



        $('#ele_num').change(function(ev){
            $('#ele_fee_value').val(ev.target.value * 3500);
        });

        // Block UI when submit form
        $('#btn-submit').on('click', function(e){
            blockUI(true);
            $('#ele_fee').val($('#ele_fee_value').val());
            $("form").submit();
        });
    });
</script>
@endsection