@extends('core.admin')
@section('title', 'Thêm khoản trả góp')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm khoản trả góp</h1>
    </div>
    
    <div class="row">
        
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm khoản trả góp</h6>
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
                    
                    <form class="row" method="POST" enctype="multipart/form-data" action="{{ route('add_installment') }}" >
                        @csrf
                        
                        <div class="col-lg-6 form-group">
                            <label for="details">Nội dung</label>
                            <input type="text" id="details" class="form-control" name="details" placeholder="Nhập nội dung" required>
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="trans_date">Ngày giao dịch</label>
                            <input type="date" id="trans_date" class="form-control" name="trans_date" required>
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="trans_amount">Số tiền (vnđ)</label>
                            <input type="text" id="trans_amount" class="form-control" placeholder="Nhập số tiền đã chi" required>
                            <input type="hidden" name="trans_amount" id="trans_amount_value">
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="cycle">Số tháng góp</label>
                            <select id="cycle" class="form-control" name="cycle">
                                <option value="3" selected>3 Tháng</option>
                                <option value="6">6 Tháng</option>
                                <option value="9">9 Tháng</option>
                                <option value="12">12 Tháng</option>
                            </select>
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="start_date">Ngày bắt đầu góp</label>
                            <input type="date" id="start_date" class="form-control" name="start_date" required>
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="due_date">Ngày kết thúc góp</label>
                            <input type="date" id="due_date" class="form-control" name="due_date" required>
                        </div>

                        <div class="col-lg-12 text-center mt-3">
                            <button type="reset" class="btn btn-primary cm-btn">Nhập lại</button>
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
        $('#start_date').val(now);
        $('#due_date').val(now);
        $('#trans_date').val(now);
        
        // Format currency
        $('#trans_amount').number(true);
        $('#trans_amount').change(function(){
            $('#trans_amount_value').val($('#trans_amount').val());
        });

        // Block UI when submit form
        $('#btn-submit').on('click', function(e){
            blockUI(true);
            $('#total_value').val($('#total').val());
            $("form").submit();
        });
    });
</script>
@endsection