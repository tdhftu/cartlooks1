<?php

namespace Theme\CartLooksTheme\Http\Resources;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SliderResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'url' => $data->url,
                    'desktop' => Cache::rememberForever('home-page-desktop-slider' . $data->desktop, function () use ($data) {
                        return getFilePath($data->desktop, false);
                    }),
                    'mobile'
                    => Cache::rememberForever('home-page-mobile-slider' . $data->mobile, function () use ($data) {
                        return getFilePath($data->mobile, false);
                    }),
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
