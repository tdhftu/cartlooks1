<?php

namespace Core\Repositories;

use Illuminate\Support\Facades\DB;

class SettingsRepository
{
    /**
     * get settings data
     */
    public function getSettingsData($data, $match_case = [])
    {
        $settings_value = DB::table('tl_general_settings')
            ->leftJoin('tl_general_settings_has_values', 'tl_general_settings.id', '=', 'tl_general_settings_has_values.settings_id')
            ->leftJoin('tl_uploaded_files', 'tl_uploaded_files.id', '=', 'tl_general_settings_has_values.value')
            ->where($match_case)
            ->select($data)->get();
        return $settings_value;
    }
    /**
     * Will return site properties
     */
    public static function SiteProperties()
    {
        try {
            $data = [
                'logo' => getFilePath(getGeneralSetting('white_background_logo'), false),
                'logo_dark' => getFilePath(getGeneralSetting('black_background_logo'), false),
                'mobile_logo' => getFilePath(getGeneralSetting('white_mobile_background_logo'), false),
                'mobile_dark_logo' => getFilePath(getGeneralSetting('black_mobile_background_logo'), false),
                'site_title' => getGeneralSetting('site_title') != null ? getGeneralSetting('site_title') : getGeneralSetting('system_name'),
                'site_name' => getGeneralSetting('system_name'),
                'site_motto' => getGeneralSetting('site_moto'),
                'favicon' => getFilePath(getGeneralSetting('favicon'), false),
                'sticky_black_logo' => getFilePath(getGeneralSetting('sticky_black_background_logo'), false),
                'sticky_logo' => getFilePath(getGeneralSetting('sticky_background_logo'), false),
                'sticky_black_mobile_logo' => getFilePath(getGeneralSetting('sticky_black_mobile_background_logo'), false),
                'sticky_mobile_logo' => getFilePath(getGeneralSetting('sticky_mobile_background_logo'), false),
                'copyright' => getGeneralSetting('copyright_text'),
                'app_demo' => env('APP_DEMO') == true ? 1 : 2,
            ];

            return $data;
        } catch (\Exception $e) {
            return NULL;
        } catch (\Error $e) {
            return NULL;
        }
    }

    /**
     * Will return site seo
     */
    public static function siteSeoProperties()
    {
        try {

            $site_name = getGeneralSetting('system_name') != null ? getGeneralSetting('system_name') : getGeneralSetting('site_title');
            $site_motto = getGeneralSetting('site_moto') != null ? ' | ' . getGeneralSetting('site_moto') : '';
            $site_title = $site_name . '' . $site_motto;
            $meta_title = getGeneralSetting('site_meta_title') != null ? getGeneralSetting('site_meta_title') : getGeneralSetting('system_name');

            $data = [
                'site_title' => $site_title,
                'site_meta_title' => $meta_title,
                'site_meta_description' => getGeneralSetting('site_meta_description'),
                'site_meta_keywords' => getGeneralSetting('site_meta_keywords'),
                'site_meta_image' => getFilePath(getGeneralSetting('site_meta_image'), false),
            ];
            return $data;
        } catch (\Exception $e) {
            return NULL;
        } catch (\Error $e) {
            return NULL;
        }
    }
}
