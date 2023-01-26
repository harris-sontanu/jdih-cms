<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

trait HelperTrait
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

    public function userPictureUrl($picture, $name)
    {
        $pictureUrl = "https://ui-avatars.com/api/?name={$name}&size=170&background=random&font-size=0.35";

        if (!empty($picture)) {
            // Get thumbnail image
            $ext            = substr(strrchr($picture, '.'), 1);
            $thumbnail      = str_replace(".{$ext}", "_sq.{$ext}", $picture);
            if (Storage::disk('public')->exists($thumbnail)) $pictureUrl = Storage::url($thumbnail);
        }

        return $pictureUrl;
    }
}
