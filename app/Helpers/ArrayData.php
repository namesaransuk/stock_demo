<?php
if (! function_exists('monthAll')) {
    function monthAll()
    {
        return  [ "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม", "all"];
    }
}
if (! function_exists('yearFive')) {
    function yearFive()
    {
        return  [date("Y"),date("Y")-1,date("Y")-2,date("Y")-3,date("Y")-4];
    }
}
