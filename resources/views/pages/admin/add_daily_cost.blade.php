@extends('core.admin')
@section('title', 'Chi tiêu hàng ngày')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
    
    <div class="row">
        
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Chi tiêu hằng ngày</h6>
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
                    
                    <form class="row" method="POST" enctype="multipart/form-data" action="{{ route('post_add_daily_cost') }}" >
                        @csrf
                        <div class="col-lg-6 form-group">
                            <label for="date">Ngày chi</label>
                            <input type="date" id="date" class="form-control" name="date" required>
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="payfor">Nội dung</label>
                            <input type="text" id="payfor" class="form-control" name="payfor" placeholder="Nhập nội dung" required>
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="total">Số tiền (vnđ)</label>
                            <input type="text" id="total" class="form-control" placeholder="Nhập số tiền đã chi" required>
                            <input type="hidden" id="total_value" name="total">
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="payer">Người chi</label>
                            <select id="payer" class="form-control" name="payer">
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" 
                                    @auth 
                                        @if (Auth::user()->id == $user->id)
                                            {{ "selected" }}
                                        @endif 
                                    @endauth>{{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12 form-group row">
                            <div class="col-md-3 col-6">
                                <label for="is_together" class="lbl-name">Chi tiêu chung</label><br>
                                <label class="switch">
                                    <input type="radio" class="is_together" name="is_together" value="1" @if ($type == "0") checked @endif>
                                    <span class="form-control slider round"></span>
                                </label>
                            </div>
                            <div class="col-md-9 col-6">
                                <label for="is_together" class="lbl-name">Chi tiêu cá nhân</label><br>
                                <label class="switch">
                                    <input type="radio" class="is_together" name="is_together" value="0" @if ($type == "1") checked @endif>
                                    <span class="form-control slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-6 form-group category @if ($type == "0") d-none @endif">
                            <label for="category">Danh mục</label>
                            <select id="category" class="form-control" name="category">
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 form-group percent @if ($type == "1") d-none @endif">
                            <label for="percent_per_one">Chia (%) Kiệt </label>
                            <input type="text" id="percent_per_one" name="percent_per_one" class="form-control" maxlength="3" placeholder="Nhập nội dung" value="50" required>
                        </div>
                        
                        <div class="col-lg-6 form-group percent @if ($type == "1") d-none @endif">
                            <label for="percent_per_two">Chia (%) Thạch</label>
                            <input type="text" id="percent_per_two" name="percent_per_two" class="form-control" maxlength="3" placeholder="Nhập nội dung" value="50" required>
                        </div>
                        
                        <div class="col-lg-12">
                            <label for="image">Ảnh hóa đơn (nếu có)</label>
                            <input type="file" id="image" class="form-control" name="image">
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
        $('#date').val(now);
        
        // Format currency
        $('#total').number(true);
        $('#total').change(function(){
            $('#total_value').val($('#total').val());
        });

        // Update value of percent_per_two when percent_per_one has changed
        $('#percent_per_one').number(true);
        $('#percent_per_one').change(function(ev){
            $('#percent_per_two').val(100 - ev.target.value);
            
        });

        //Update value of percent_per_two when percent_per_one has changed
        $('#percent_per_two').number(true);
        $('#percent_per_two').change(function(ev){
            $('#percent_per_one').val(100 - ev.target.value);
            
        });

        // Is person handle
        $('.is_together').change(function(ev) {
            console.log();
            
            var isTogether = ev.target.value;
            if (isTogether == 1) {
                $('.percent').removeClass('d-none');
                $('.category').addClass('d-none');
                // $('.lbl-name').html('Chi tiêu chung');
                $('#percent_per_one').prop('disabled', false);
                $('#percent_per_two').prop('disabled', false);
            } else {
                $('.percent').addClass('d-none');
                $('.category').removeClass('d-none');
                // $('.lbl-name').html('Chi tiêu cá nhân');
                $('#percent_per_one').prop('disabled', true);
                $('#percent_per_two').prop('disabled', true);
            }
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