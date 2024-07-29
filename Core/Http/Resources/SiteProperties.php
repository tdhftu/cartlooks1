<?php

namespace Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteProperties extends JsonResource
{
    public function toArray($request)
    {
        return [
            'logo' => getFilePath(getGeneralSetting('white_background_logo'), false),
            'logo_dark' => getFilePath(getGeneralSetting('black_background_logo'), false),
            'mobile_logo' => getFilePath(getGeneralSetting('white_mobile_background_logo'), false),
            'mobile_dark_logo' => getFilePath(getGeneralSetting('black_mobile_background_logo'), false),
            'site_title' => getGeneralSetting('site_title') != null ? getGeneralSetting('site_title') : getGeneralSetting('system_name'),
            'site_name' => getGeneralSetting('system_name'),
            'favicon' => getFilePath(getGeneralSetting('favicon'), false),
            'sticky_black_logo' => getFilePath(getGeneralSetting('sticky_black_background_logo'), false),
            'sticky_logo' => getFilePath(getGeneralSetting('sticky_background_logo'), false),
            'sticky_black_mobile_logo' => getFilePath(getGeneralSetting('sticky_black_mobile_background_logo'), false),
            'sticky_mobile_logo' => getFilePath(getGeneralSetting('sticky_mobile_background_logo'), false),
            'copyright' => getGeneralSetting('copyright_text')
        ];
    }
}
