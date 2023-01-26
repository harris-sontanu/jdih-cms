<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Str;

class MediaController extends AdminController
{
    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $type = Str::title($request->type);

        $message = "data {$type} telah berhasil diperbarui";
        foreach ($ids as $id)
        {
            $media = Media::find($id);
            if ($request->action === 'publication')
            {
                if ($request->val == 'publish') {
                    $published_at = (empty($media->published_at)) ? now() : $media->published_at;
                    $media->update(['published_at' => $published_at]);
                } else if ($request->val == 'unpublish') {
                    $media->update(['published_at' => null]);
                }
            }
            else if ($request->action === 'delete')
            {
                $path = $media->path;
                $this->removeMedia($path);

                $media->delete();

                $message = "data {$type} telah berhasil dihapus";
            }
        }

        $request->session()->flash('message', '<span class="badge rounded-pill bg-success">' . $count . '</span> ' . $message);
    }
}
