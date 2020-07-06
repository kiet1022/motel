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
?>