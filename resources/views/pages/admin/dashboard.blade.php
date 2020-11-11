@extends('core.admin')
@section('css')
<style>
    .quote-bg {
        background-image: url("{{ asset('img/control/quote-bg.jpg') }}");
        /* background: #ecbc5c;"
        font-family: Arial, Helvetica, sans-serif;
        height: 200px; */
        display: block;
        overflow: auto;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        /* position: relative;
        color: white;    
        font-family: "Courier New", Courier, monospace; */

    }
    .motivation {
        font-family: "Courier New", Courier, monospace;
        color: #000 !important;
    }

    .hr {
        width: 30%;
        background:white;
    }

</style>
@endsection
@section('content')
    
                <!-- Begin Page Content -->
                <div class="">
                    
                    <!-- Page Heading -->
                    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div> --}}
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>            
                    @endif
                    <!-- Content Row -->

                    <div class="row">
    
                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Body -->
                                <div class="card-body quote-bg">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mb-2 rounded-circle" style="width: 15rem;" src="{{ asset('img/coffee.gif')}}" alt="">
                                        <h4 id="morning-message" class="text-light">
                                            @if ($coffee == 1)
                                                {{"Chúc bạn có một ngày vui vẻ ^^"}}
                                            @else 
                                                {{"Hôm nay bạn có dùng cà phê sáng không?"}}
                                            @endif
                                        </h4>
                                        <form method="post" action="{{ route('save_morning_coffee') }}">
                                            @csrf
                                            <input type="hidden" value="0" name="flg">
                                        </form>
                                        @if ($coffee == 0)
                                            <button id="coffee-yes" class="btn btn-primary">Chắc chắn rồi</button>
                                            <button id="coffee-no" class="btn btn-danger">Ôi không :(</button>
                                        @endif
                                    </div>
                                    <hr class="hr">
                                    <div class="text-center text-light motivation">
                                        <h4 id="text">I am John Doe</h4>
                                        <p id="author">Mr ABC</p>
                                        <a class="btn btn-success btn-sm" href="{{ route('get_add_daily_cost_view',['together'=>0]) }}">Thêm chi tiêu</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Content Row -->
                    {{-- <div class="row">
                        
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    
                    
                    <!-- Content Row -->
                    {{-- <div class="row">
                        
                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">
                            
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Color System -->
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            Primary
                                            <div class="text-white-50 small">#4e73df</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body">
                                            Success
                                            <div class="text-white-50 small">#1cc88a</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            Info
                                            <div class="text-white-50 small">#36b9cc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-warning text-white shadow">
                                        <div class="card-body">
                                            Warning
                                            <div class="text-white-50 small">#f6c23e</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-danger text-white shadow">
                                        <div class="card-body">
                                            Danger
                                            <div class="text-white-50 small">#e74a3b</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-secondary text-white shadow">
                                        <div class="card-body">
                                            Secondary
                                            <div class="text-white-50 small">#858796</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-lg-6 mb-4">
                            
                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw &rarr;</a>
                                </div>
                            </div>
                            
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.</p>
                                    <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.</p>
                                </div>
                            </div>
                            
                        </div>
                    </div> --}}
                    
                </div>
                <!-- /.container-fluid -->
@endsection
@section('js')
<script>
    $(document).ready(function(){
        const settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://type.fit/api/quotes",
        "method": "GET"
        }

        $.ajax(settings).done(function (response) {

        const data = JSON.parse(response);
        var index = getRandomInt(1642);
        $('#text').html(data[index].text);
        var author = '<i>'+data[index].author+'</i>'
        $('#author').html(author);
        });

        function getRandomInt(max) {
            return Math.floor(Math.random() * Math.floor(max));
        }

        blockUI(false);
        $('#coffee-no').click(function(){
            $('input[name=flg]').val('0');
            $('form').submit();
        })

        $('#coffee-yes').click(function(){
            $('input[name=flg]').val('1');
            $('form').submit();
        })

    })
</script>
@endsection