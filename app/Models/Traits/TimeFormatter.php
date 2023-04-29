<?php
namespace App\Models\Traits;

use Illuminate\Support\Carbon;

trait TimeFormatter
{
    public function dateFormatted($time, $showTimes = false)
    {
        if (!is_null($time))
        {
            $format = 'j M Y';
            if ($showTimes) $format = 'l, ' . $format . ', H:i';
            return Carbon::parse($time)->translatedFormat($format);
        } else {
            return '';
        }
    }

    public function timeFormatted($time, $format = 'd-m-Y')
    {
        return Carbon::parse($time)->translatedFormat($format);
    }

    public function timeDifference($time)
    {
        return Carbon::parse($time)->diffForHumans();
    }

}
