<?php

namespace Theme\CartLooksTheme\Http\Resources;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogsResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => $data->id,
                    'title' => $data->translation('name', Session::get('api_locale')),
                    'permalink' => $data->permalink,
                    'image' => getFilePath($data->image, true),
                    'date' => $data->created_at->format('d M Y')
                ];
            })
        ];
    }
    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
