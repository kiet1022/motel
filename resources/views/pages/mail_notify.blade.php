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
@component('mail::message')
<p> Hi {{$name}} !</p>
<p> Thông báo về chi tiêu tháng {{ date("m") - 1 }}</p>
<ul>
    <li>Tiền phòng: <span class="red">1,300,000 vnđ</span></li>
    <li>Tiền nước: <span class="red">50,000 vnđ</span></li>
    <li>Tiền rác: <span class="red">12,500 vnđ</span> </li>
    <li>{{ $ele_cost_name }}: <span class="red">{{ number_format($ele_cost_value/2) }} vnđ</span> </li>
    <li>Chi tiêu khác: <span class="red">{{ number_format($total - (1300000+12500+50000+($ele_cost_value/2)))}} vnđ</span></li>
</ul>
<h1 class="red">Tổng: {{ number_format($total)}} vnđ</h1>
 @component('mail::panel')
 Phương thức thanh toán: <br>
 <ul>
    <li><h2><u>Chuyển Khoản</u></h2></li>
    <p>Ngân hàng TMCP Hàng Hải Việt Nam (Maritime Bank)</p>
    <p>STK: 04401015969818</p>
    <p>CTK: Dương Tuấn Kiệt</p>
    <li><h2><u>Momo</u></h2></li>
 </ul>
 <img style="width: 100%" src="http://kietkun.xyz/public/img/momo-info.jpg" alt="" srcset="">
 <br>
 <img style="width: 5%" src="http://kietkun.xyz/public/img/msb.png" alt="" srcset="">
 <img style="width: 5%" src="http://kietkun.xyz/public/img/momo.png" alt="" srcset="">
@endcomponent
 Trân trọng.
@endcomponent
</body>
</html>
