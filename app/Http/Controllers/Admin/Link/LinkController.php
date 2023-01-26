<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;

class LinkController extends AdminController
{
    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $type = Str::title($request->type);

        $message = "data {$type} telah berhasil diperbarui";
        foreach ($ids as $id)
        {
            $link = Link::find($id);
            if ($request->action === 'publication')
            {
                if ($request->val == 'publish') {
                    $published_at = (empty($link->published_at)) ? now() : $link->published_at;
                    $link->update(['published_at' => $published_at]);
                } else if ($request->val == 'unpublish') {
                    $link->update(['published_at' => null]);
                }
            }
            else if ($request->action === 'delete')
            {
                if ($link->image_id) {
                    $this->removeMedia($link->image->path);

                    $link->images()->delete();
                }
                $link->delete();

                $message = "data {$type} telah berhasil dihapus";
            }
        }

        $request->session()->flash('message', '<span class="badge rounded-pill bg-success">' . $count . '</span> ' . $message);
    }

    public function orderUpdate(Request $request)
    {
        $orders = $request->orders;
        foreach ($orders as $q => $value) {
            Link::where('id', $value)->update(['sort' => $q+1]);
        }
    }
}
