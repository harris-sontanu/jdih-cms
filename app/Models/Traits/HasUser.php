<?php
namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userPictureUrl($picture, $name)
    {
        $pictureUrl = "https://ui-avatars.com/api/?name={$name}&size=170&background=random&font-size=0.35";

        if (isset($picture)) {
            // Get thumbnail image
            $ext            = substr(strrchr($picture, '.'), 1);
            $thumbnail      = str_replace(".{$ext}", "_sq.{$ext}", $picture);
            if (Storage::disk('public')->exists($thumbnail)) $pictureUrl = Storage::url($thumbnail);
        }

        return $pictureUrl;
    }
}
