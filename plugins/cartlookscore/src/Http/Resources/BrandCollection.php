<?php

namespace Plugin\CartLooksCore\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Session;

class BrandCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => (int) $data->id,
                    'name' => $data->translation('name', Session::get('api_locale')),
                    'slug' => $data->permalink,
                    'logo' => getFilePath($data->logo, false),
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
