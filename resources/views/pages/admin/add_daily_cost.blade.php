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
                            {{-- error --}}
                            @if ($errors->get('date'))
                                <div class="cm-inline-form cm-error">
                                    <ul class="cm-ul-error" style="padding-left: 0px;">
                                    @foreach ($errors->get('date') as $date)
                                        <li>{{$date}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-lg-6 form-group">
                            <label for="payfor">Nội dung</label>
                            <input type="text" id="payfor" class="form-control" name="payfor" placeholder="Nhập nội dung" required>
                            {{-- error --}}
                            @if ($errors->get('payfor'))
                                <div class="cm-inline-form cm-error">
                                    <ul class="cm-ul-error" style="padding-left: 0px;">
                                    @foreach ($errors->get('payfor') as $payfor)
                                        <li>{{$payfor}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        
                        
                        <div class="col-lg-6 form-group">
                            <label for="total">Số tiền (vnđ)</label>
                            <input type="text" id="total" class="form-control" placeholder="Nhập số tiền đã chi" required>
                            <input type="hidden" id="total_value" name="total">
                            {{-- error --}}
                            @if ($errors->get('total'))
                                <div class="cm-inline-form cm-error">
                                    <ul class="cm-ul-error" style="padding-left: 0px;">
                                    @foreach ($errors->get('total') as $total)
                                        <li>{{$total}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
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
                                    <input type="radio" class="is_together" name="is_together" value="1" @if ($together == config('constants.COST_TYPE.TOGETHER')) checked @endif>
                                    <span class="form-control slider round"></span>
                                </label>
                            </div>
                            <div class="col-md-9 col-6">
                                <label for="is_together" class="lbl-name">Chi tiêu cá nhân</label><br>
                                <label class="switch">
                                    <input type="radio" class="is_together" name="is_together" value="0" @if ($together == config('constants.COST_TYPE.PERSONAL')) checked @endif>
                                    <span class="form-control slider round"></span>
                                </label>
                            </div>
                        </div>
                        {{-- error --}}
                        @if ($errors->get('is_together'))
                            <div class="cm-inline-form cm-error">
                                <ul class="cm-ul-error" style="padding-left: 0px;">
                                @foreach ($errors->get('is_together') as $is_together)
                                    <li>{{$is_together}}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-lg-6 form-group category @if ($together == config('constants.COST_TYPE.TOGETHER')) d-none @endif">
                            <label for="category">Danh mục</label>
                            <select id="category" class="form-control" name="category" @if ($together == config('constants.COST_TYPE.TOGETHER')) {{ "disabled" }} @endif>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 form-group installment d-none">
                            <label for="installment">Danh mục trả góp</label>
                            <select id="installment" class="form-control">
                                <option disabled selected>Chọn danh mục</option>
                                @foreach ($installments as $ins)
                                <option value="{{ $ins->id }}">
                                    {{ $ins->details }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 form-group installment-detail d-none">
                            <label for="installment-detail">Chọn kỳ thanh toán</label>
                            <select id="installment-detail" class="form-control" name="ins_detail_id"></select>
                        </div>

                        @foreach ($users as $key => $user)
                            <div class="col-lg-6 form-group percent @if ($together == config('constants.COST_TYPE.PERSONAL')) d-none @endif">
                                <label for="percent">Chia (%) {{explode(' ', $user->name)[2]}} </label>
                                <input type="text" name="percent[]" class="percent-per-person form-control" maxlength="3" placeholder="Nhập nội dung" value="{{ old('percent') ? old('percent')[$key] : '50' }}" required>
                            {{-- error --}}
                                @if ($errors->get('percent'))
                                    <div class="cm-inline-form cm-error">
                                        <ul class="cm-ul-error" style="padding-left: 0px;">
                                        @foreach ($errors->get('percent') as $percent)
                                            <li>{{$percent}}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
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
        
        $('#total').change(function(){
            
            if ($(this).val().includes('k')) {
                var value = $(this).val().replace('k','').concat('000');
                $('#total').number(true);
                $(this).val(value)
            }
            $('#total_value').val($('#total').val());
        });

        $('#total').focus(function(){
            console.log($(this).val());
            $('#total').number(false);
        });

        // Is person handle
        $('.is_together').change(function(ev) {
            console.log();
            
            var isTogether = ev.target.value;
            if (isTogether == 1) {
                $('.percent').removeClass('d-none');
                $('.category').addClass('d-none');
                $('#category').attr('disabled',true);
                $('.installment-detail').addClass('d-none');
                $('.installment').addClass('d-none');
            } else {
                $('.percent').addClass('d-none');
                $('.category').removeClass('d-none');
                $('#category').attr('disabled',false);

                if ($('#category').val() == "6") {
                    if($('#installment').val() != "") {
                        $('.installment-detail').removeClass('d-none');
                        $('.installment').removeClass('d-none');
                    } else {
                        $('.installment').removeClass('d-none');
                    }
                }
            }
        });

        $('#category').change(function() {
            if($(this).val() == "6") {
                $('.installment').removeClass('d-none')
            } else {
                $('.installment').addClass('d-none');
                $('.installment-detail').addClass('d-none');
            }
        })
        $('#installment').change(function() {
            var id = $(this).val();
            var url_detail = "{{ route('ajax-installment_details')}}";
            $.ajax({
                url: url_detail,
                method: 'post',
                data: {
                    id: id
                }
            }).done(function(data) {
                genInsDetailBlock(data.detail);
            }).fail(function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            })
            
        })

        function genInsDetailBlock(detail) {
            html = '';
            for (var i = 0; i < detail.length; i++) {
                if (detail[i].status != 1) {
                    var thisMonthSystem = moment(now).get('month');
                    var thisMonth = moment(detail[i].pay_date).get('month');
                    if(thisMonth > thisMonthSystem) {
                        html += '<option value="' + detail[i].id + '" disabled>'+ moment(detail[i].pay_date).format('DD/MM/YYYY')+' - '+ numberFormat(detail[i].trans_amout)+' - '+'<span class="text-danger">Chưa đến hạn</span></option>'
                    } else {
                        html += '<option value="' + detail[i].id + '">'+ moment(detail[i].pay_date).format('DD/MM/YYYY')+' - '+ numberFormat(detail[i].trans_amout)+'</option>'
                    }
                }
            }

            $('#installment-detail').html(html);
            $('.installment-detail').removeClass('d-none');
        }

        function numberFormat(number){
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        }
        // Block UI when submit form
        $('#btn-submit').on('click', function(e){
            blockUI(true);
            $('#total_value').val($('#total').val());
            $("form").submit();
        });
    });
</script>
@endsection