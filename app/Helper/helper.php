<?php
    if (! function_exists('convertEnDayToViDay')) {
        function convertEnDayToViDay($date){
            $enDay = strtolower(date("l", strtotime($date)));
            $viDay = "";
            switch ($enDay) {
                case 'monday':
                    $viDay = 'Thứ hai';
                    break;
                case 'tuesday':
                    $viDay = 'Thứ ba';
                    break;
                case 'wednesday':
                    $viDay = 'Thứ tư';
                    break;
                case 'thursday':
                    $viDay = 'Thứ năm';
                    break;
                case 'friday':
                    $viDay = 'Thứ sáu';
                    break;
                case 'saturday':
                    $viDay = 'Thứ bảy';
                    break;
                default:
                    $viDay = 'Chủ nhật';
                    break;
            }
            return $viDay;
        }
    }

    if (! function_exists('showDateInDMY')) {
        function showDateInDMY($date){
            return date("d/m/Y", strtotime($date));
        }
    }

    if (! function_exists('showInstallmentStatus')) {
        function showInstallmentStatus($detail){
            $result = '<span class="badge badge-danger">Chưa thanh toán</span>';
            if ($detail->status == 1){
                $result = '<span class="badge badge-success">Đã thanh toán</span>';
            } else if ($detail->status == 0 && strtotime($detail->pay_date) > strtotime(date('Y-m-d'))) {
                $result = '<span class="badge badge-warning">Chưa đến hạn thanh toán</span>';
            }
            
            return $result;
        }
    }

    if (! function_exists('showStatusForNotify')) {
        function showStatusForNotify($status){
            $result = '<span class="badge badge-danger">Chưa gửi mail</span>';

            $result = $status == 1 ? '<span class="badge badge-success">Đã gửi mail</span>' : $result;
            
            return $result;
        }
    }

    if (! function_exists('showStatusForStorage')) {
        function showStatusForStorage($status){
            $result = '<span class="badge badge-danger">Chưa dọn dẹp hoá đơn</span>';

            $result = $status == 1 ? '<span class="badge badge-success">Đã dọn dẹp hoá đơn</span>' : $result;
            
            return $result;
        }
    }
?>