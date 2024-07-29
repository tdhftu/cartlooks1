<?php

namespace Theme\CartLooksTheme\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Theme\CartLooksTheme\Http\Resources\TopBarBannerResource;

class ThemeOptionController extends Controller
{
    /**
     * will return back top style
     */
    public function getBackToTopStyle()
    {
        try {
            $theme = getActiveTheme();
            $style = getThemeOption('back_to_top', $theme->id);

            return response()->json(
                [
                    'success' => true,
                    'style' => $style
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /**
     * Will return 404 style
     */
    public function get404PageStyle()
    {
        try {
            $theme = getActiveTheme();
            $style = getThemeOption('page_404', $theme->id);
            for ($i = 0; $i < sizeof($style); $i++) {
                if ($style['button_hover_text_color_transparent'] == 1) {
                    $style['button_hover_text_color'] = 'transparent';
                }
                if ($style['button_hover_bg_color_transparent'] == 1) {
                    $style['button_hover_bg_color'] = 'transparent';
                }
                if ($style['button_text_color_transparent'] == 1) {
                    $style['button_text_color'] = 'transparent';
                }
                if ($style['button_bg_color_transparent'] == 1) {
                    $style['button_bg_color'] = 'transparent';
                }
                $image = getFilePath($style['404_image'], true);
                if ($image != null) {
                    $style['image'] = asset($image);
                } else {
                    $style['image'] = null;
                }
            }

            return response()->json(
                [
                    'success' => true,
                    'style' => $style
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /**
     * Will return preloader style
     */
    public function getPreloaderStyle()
    {
        try {
            $theme = getActiveTheme();
            $style = getThemeOption('preloader', $theme->id);
            if ($style['preloader_item_color_transparent'] == 1) {
                $style['preloader_item_color'] = 'transparent';
            }
            if ($style['preloader_bgcolor_transparent'] == 1) {
                $style['preloader_bgcolor'] = 'transparent';
            }
            if ($style['custom_preloader_type'] == 'image') {
                $image = getFilePath($style['preloader_image'], true);
                if ($image != null) {
                    $style['image'] = asset($image);
                } else {
                    $style['image'] = null;
                }
            }

            return response()->json(
                [
                    'success' => true,
                    'style' => $style
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /**
     * Will return theme color
     */
    public function getThemeColor()
    {
        $theme = getActiveTheme();
        $theme = getThemeOption('theme_color', $theme->id);
    }

    /**
     * Will return header style
     */
    public function getThemeStyle()
    {
        try {
            $theme = getActiveTheme();
            $headerOptions = getThemeOption('header', $theme->id);
            $headerLogoStyles = getThemeOption('header_logo', $theme->id);
            $headerMenuStyle = getThemeOption('menu', $theme->id);
            $footerStyle = getThemeOption('footer', $theme->id);
            $socialStyle = getThemeOption('social', $theme->id);
            $subscriptionFormStyle = getThemeOption('subscribe', $theme->id);
            $themeColor = getThemeOption('theme_color', $theme->id);

            $top_bar_banner_properties = getThemeOption('topbar_banner', $theme->id);
            $gdpr_properties = getThemeOption('gdpr', $theme->id);
            $website_popup_properties = getThemeOption('website_popup', $theme->id);

            return response()->json(
                [
                    'success' => true,
                    'headerOptions' => $headerOptions,
                    'headerLogoStyles' => $headerLogoStyles,
                    'headerMenuStyle' => $headerMenuStyle,
                    'footerStyle' => $footerStyle,
                    'subscriptionFormStyle' => $subscriptionFormStyle,
                    'socialStyle' => $socialStyle,
                    'themeColor' => $themeColor,
                    'top_bar_banner_properties' => $top_bar_banner_properties != null ? new TopBarBannerResource($top_bar_banner_properties) : null,
                    'gdpr_properties' => $gdpr_properties != null ? $gdpr_properties : null,
                    'website_popup_properties' => $website_popup_properties ? $website_popup_properties : null
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /**
     * will return theme color
     */
    public function getPresentColor()
    {

        try {
            $theme = getActiveTheme();
            $themeColor = getThemeOption('theme_color', $theme->id);

            return response()->json(
                [
                    'success' => true,
                    'themeColor' => $themeColor
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /**
     * Get blog theme style
     */
    public function getBlogThemeStyle()
    {
        try {
            $theme = getActiveTheme();
            $blogOptions = getThemeOption('blog', $theme->id);
            $singleBlogPageStyle = getThemeOption('single_blog_page', $theme->id);
            $sidebarOptionStyle = getThemeOption('sidebar_options', $theme->id);
            return response()->json(
                [
                    'success' => true,
                    'blogOptions' => $blogOptions,
                    'singleBlogPageStyle' => $singleBlogPageStyle,
                    'sidebarOptionStyle' => $sidebarOptionStyle,
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
}
