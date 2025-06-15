<?php
namespace App\Helpers;

class DateHelper
{
    public static function formatDate($date)
    {
        return date('d.m.Y', strtotime($date));
    }

    public static function now()
    {
        return date('Y-m-d H:i:s');
    }
   
}
