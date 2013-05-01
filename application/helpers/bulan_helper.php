<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('bulan')) {

    function bulan($bln) {
        $x= explode("-", $bln); 
        $thn = $x[0];
        $bln = $x[1];
        switch ($bln) {
            case "01":
                return "Jan";
                break;
            case "02":
                return "Feb";
                break;
            case "03":
                return "Mar";
                break;
            case "04":
                return "Apr";
                break;
            case "05":
                return "Mei";
                break;
            case "06":
                return "Jun";
                break;
            case "07":
                return "Jul";
                break;
            case "08":
                return "Ags";
                break;
            case "09":
                return "Sep";
                break;
            case "10":
                return "Okt";
                break;
            case "11":
                return "Nov";
                break;
            case "12":
                return "Des";
                break;
        }
    }
}

if (!function_exists('bulan_full')) {

    function bulan_full($bln) {
        switch ($bln) {
            case "01":
                return "Januari";
                break;
            case "02":
                return "Februari";
                break;
            case "03":
                return "Maret";
                break;
            case "04":
                return "April";
                break;
            case "05":
                return "Mei";
                break;
            case "06":
                return "Juni";
                break;
            case "07":
                return "Juli";
                break;
            case "08":
                return "Agustus";
                break;
            case "09":
                return "September";
                break;
            case "10":
                return "Oktober";
                break;
            case "11":
                return "November";
                break;
            case "12":
                return "Desember";
                break;
        }
    }
}