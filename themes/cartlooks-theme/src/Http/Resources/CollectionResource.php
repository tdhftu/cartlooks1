<?php

namespace Theme\CartLooksTheme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->translation('name', session()->get('api_locale')),
            'permalink' => $this->permalink,
            'image' => getFilePath($this->image, false),
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
