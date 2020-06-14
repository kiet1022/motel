<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
</head>
<body>
    {{-- <table id="table1" class="table table-hover tabel-stripped table-bordered">
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
            @if ($cost->percent_per_one > 0 && $cost->percent_per_two > 0)                                                
            <tr>
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
            </tr>
            @endif
            @endforeach
        </tbody>
    </table> --}}


@component('mail::message')
<p> Hi {{$name}} </p>
<p> Thông báo về chi tiêu tháng {{ date("m") }}</p>
<ul>
    <li>Tiền Phòng: <span class="red">1.300.000 vnđ</span></li>
    <li>Tiền nước: <span class="red">50.000 vnđ</span></li>
    <li>Tiền rác: <span class="red">12.500 vnđ</span> </li>
    <li>Chi tiêu khác: <span class="red">{{ number_format($total - (1300000+12500+50000))}} vnđ</span></li>
</ul>
<h2 class="red">Tổng: {{ number_format($total)}} vnđ</h2>
 @component('mail::panel')
 Phương thức thanh toán: <br>
 <h2>Chuyển Khoản</h2>
 <p>STK: 04401015969818</p>
 <p>CTK: Dương Tuấn Kiệt</p>
 <p>Ngân hàng TMCP Hàng Hải Việt Nam (Maritime Bank)</p>
 <h2>Momo</h2>
 <p>SDT: 0346356275</p>
 <br>
 <img style="width: 5%" src="https://lh3.googleusercontent.com/MBMltTFMkP0uV2dmS2BopLdtokWLI1Qs6lI69wYzixldD4hqr93xTAJFvrw5f_I2mQ" alt="" srcset="">
 <img style="width: 5%" src="https://static.mservice.io/img/logo-momo.png" alt="" srcset="">
@endcomponent
 Trân trọng.
@endcomponent
</body>
</html>
