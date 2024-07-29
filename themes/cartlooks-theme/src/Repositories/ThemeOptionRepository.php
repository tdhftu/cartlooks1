<?php

namespace Theme\CartLooksTheme\Repositories;

use Illuminate\Support\Facades\DB;

use Theme\CartLooksTheme\Models\TlThemeOptionSettings;

class ThemeOptionRepository
{

    /**
     ** Saving Theme Option
     * @param object $request
     * @return void
     */
    public function saveThemeOption($request)
    {
        $active_theme = getActiveTheme();
        $data = [];
        $option_name = $request->option_name;
        foreach ($request->all() as $key => $value) {
            if (!($key == '_token' || $key == 'submitType' || $key == 'option_name'
                || $key == 'social_icon_title' || $key == 'social_icon' || $key == 'social_icon_url')) {
                $theme_options = TlThemeOptionSettings::where('option_name', $option_name)
                    ->where('theme_id', $active_theme->id)
                    ->where('field_name', $key);
                if ($theme_options->exists()) {
                    $theme_options->update([
                        'field_value' => $key == 'header_custom_js_code' || $key == 'footer_custom_js_code' ? $value : xss_clean($value)
                    ]);
                } else {
                    $option_value = [
                        'option_name' => $option_name,
                        'theme_id' => $active_theme->id,
                        'field_name' => $key,
                        'field_value' => $key == 'header_custom_js_code' || $key == 'footer_custom_js_code' ? $value : xss_clean($value),
                    ];
                    array_push($data, $option_value);
                }
            }
        };
        if (count($data) > 0) {
            TlThemeOptionSettings::insert($data);
        }

        // if theme option is subscribe then updating the Mailchimp env
        if ($option_name == 'subscribe') {
            setEnv('MAILCHIMP_APIKEY', str_replace(' ', '', $request->mailchimp_api_key));
            setEnv('MAILCHIMP_LIST_ID', str_replace(' ', '', $request->mailchimp_list_id));
        }

        // saving css file
        switch ($option_name) {
            case 'back_to_top':
                $this->setBackToTopStyle();
                break;
            case 'header':
                $this->setHeaderOptionsStyle();
                break;
            case 'header_logo':
                $this->setHeaderLogosStyle();
                break;
            case 'menu':
                $this->setHeaderMenuStyle();
                break;
            case 'blog':
                $this->setBlogStyle();
                break;
            case 'sidebar_options':
                $this->setSidebarOptionStyle();
                break;
            case 'page_404':
                $this->set404PageStyle();
                break;
            case 'subscribe':
                $this->setNewsletterStyle();
                break;
            case 'footer':
                $this->setFooterStyle();
                break;
            case 'social':
                $this->setSocialIconStyle();
                break;
            case 'custom_css':
                $custom_css = $request->custom_css_code;
                $path = base_path('/themes/cartlooks-theme/public/css/custom_css.css');
                if (file_exists($path)) {
                    unlink($path);
                }
                setFolderPermissions($path);
                file_put_contents($path, $custom_css);
                break;
            default:
                break;
        }
    }

    /**
     * set blog style
     */
    public function setBlogStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('blog', $theme->id);
        $updatedStyle = [];
        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);

            if ($last_identifier == 'color') {
                if (isset($style[$key . "_transparent"]) &&  $style[$key . "_transparent"] == 1) {
                    $value = 'transparent';
                } elseif ($value == null || $value == '') {
                    continue;
                }
                $updatedStyle[$key] = $value;
            }
            $updatedStyle[$key] = $value;
        }

        $themeOption = [];
        $styleProperties = '';

        if (isset($style['custom_blog']) && $style['custom_blog'] == 1) {
            foreach ($updatedStyle as $key => $value) {
                if ($key == 'blog_pagination_color' && $value != "") {
                    $themeOption['.custom-pagination li a']['color'] = $value . "!important;";
                }
                if ($key == 'blog_pagination_bg_color' && $value != "") {
                    $themeOption['.custom-pagination li a']['background-color'] = $value . "!important;";
                }
                if ($key == 'blog_pagination_border_color' && $value != "") {
                    $themeOption['.custom-pagination li a']['border'] = "1px solid " . $value . "!important;";
                }

                if ($key == 'blog_pagination_active_color' && $value != "") {
                    $themeOption['.custom-pagination li a.active']['color'] = $value . "!important;";
                }
                if ($key == 'blog_pagination_active_bg_color' && $value != "") {
                    $themeOption['.custom-pagination li a.active']['background-color'] = $value . "!important;";
                }
                if ($key == 'blog_pagination_active_border_color' && $value != "") {
                    $themeOption['.custom-pagination li a.active']['border'] = "1px solid " . $value . "!important;";
                }


                if ($key == 'blog_pagination_hover_color' && $value != "") {
                    $themeOption['.custom-pagination li a:hover:not(.active)']['color'] = $value . "!important;";
                }
                if ($key == 'blog_pagination_hover_bg_color' && $value != "") {
                    $themeOption['.custom-pagination li a:hover:not(.active)']['background-color'] = $value . "!important;";
                }
                if ($key == 'blog_pagination_hover_border_color' && $value != "") {
                    $themeOption['.custom-pagination li a:hover:not(.active)']['border'] = "1px solid " . $value . "!important;";
                }

                if ($key == 'blog_pagination_position' && $value != "") {
                    $themeOption['.custom-pagination']['justify-content'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/blog.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set sidebar option style
     */
    public function setSidebarOptionStyle()
    {
        $theme = getActiveTheme();
        $style = themeOptionToCss('sidebar_options', $theme->id);

        $widget = ['widget'];
        $widget_custom = ['widget_custom', 'widget_margin', 'widget_padding', 'widget_border'];
        $widget_title = ['widget_title', 'widget_title_font', 'widget_title_margin', 'widget_title_padding'];
        $widget_text = ['widget_text'];
        $widget_anchor = ['widget_anchor'];
        $widget_anchor_hover = ['widget_anchor_hover'];
        $themeOption = [];
        $styleProperties = '';

        if (isset($style['css']) && count($style['css']) > 0 && $style['condition']['custom_sidebar_c'] == 1) {
            foreach ($style['css'] as $key => $values) {
                foreach ($values as $property => $value) {
                    if (in_array($key, $widget)) {
                        $themeOption['.blog-sidebar .widget'][$property] = $value . ';';
                    } elseif (in_array($key, $widget_custom)) {
                        $themeOption['.blog-sidebar .widget'][$property] = $value . ';';
                    } elseif (in_array($key, $widget_title)) {
                        $themeOption['.blog-sidebar .widget .widget-title'][$property] = $value . ';';
                    } elseif (in_array($key, $widget_text)) {
                        $themeOption['.blog-sidebar .widget'][$property] = $value . ';';
                    } elseif (in_array($key, $widget_anchor)) {
                        $themeOption['.blog-sidebar .widget a'][$property] = $value . ';';
                    } elseif (in_array($key, $widget_anchor_hover)) {
                        $themeOption['.blog-sidebar .widget a:hover'][$property] = $value . ';';
                    } else {
                        $themeOption[$key][$property] = $value . ';';
                    }
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }

        $path = base_path('themes/cartlooks-theme/public/css/sidebar_options.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set 404 page style
     */
    public function set404PageStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('page_404', $theme->id);
        $updatedStyle = [];

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);

            if ($last_identifier == 'color') {
                if (isset($style[$key . "_transparent"]) &&  $style[$key . "_transparent"] == 1) {
                    $value = 'transparent';
                } elseif ($value == null || $value == '') {
                    continue;
                }
                $updatedStyle[$key] = $value;
            }
        }

        $themeOption = [];
        $styleProperties = '';

        if (isset($style['custom_404']) && $style['custom_404'] == 1) {
            foreach ($updatedStyle as $key => $value) {
                if ($key == 'button_bg_color' && $value != "") {
                    $themeOption['.custom-button-style']['background-color'] = $value . "!important;";
                }
                if ($key == 'button_text_color' && $value != "") {
                    $themeOption['.custom-button-style']['color'] = $value . "!important;";
                }
                if ($key == 'button_hover_bg_color' && $value != "") {
                    $themeOption['.custom-button-style:hover']['background-color'] = $value . "!important;";
                }
                if ($key == 'button_hover_text_color' && $value != "") {
                    $themeOption['.custom-button-style:hover']['color'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/page_404.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set footer style
     */
    public function setFooterStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('footer', $theme->id);
        $updatedStyle = [];

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);
            $first_identifier = implode('_', $splitted_key);

            if ($last_identifier == 'top' || $last_identifier == 'bottom') {
                if (isset($value) || $value != '') {
                    $value = $value . $style[$first_identifier . "_unit"];
                } else {
                    continue;
                }
            }

            if ($last_identifier == 'color') {
                if (isset($style[$key . "_transparent"]) &&  $style[$key . "_transparent"] == 1) {
                    $value = 'transparent';
                } elseif ($value == null || $value == '') {
                    continue;
                }
            }
            $updatedStyle[$key] = $value;
        }

        $themeOption = [];
        $styleProperties = '';

        if (isset($style['custom_footer']) && $style['custom_footer'] == 1) {
            foreach ($updatedStyle as $key => $value) {
                if ($key == 'custom_footer_padding_top' && $value != "") {
                    $themeOption['.custom-footer.c1-bg']['padding-top'] = $value . "!important;";
                }
                if ($key == 'custom_footer_padding_bottom' && $value != "") {
                    $themeOption['.custom-footer.c1-bg']['padding-bottom'] = $value . "!important;";
                }
                if ($key == 'footer_background_color' && $value != "") {
                    $themeOption['.custom-footer.c1-bg']['background-color'] = $value . "!important;";
                }
                if ($key == 'footer_text_color' && $value != "") {
                    $themeOption['.custom-footer.c1-bg']['color'] = $value . "!important;";
                    $themeOption['.custom-title-style']['color'] = $value . "!important;";
                    $themeOption['.custom-anchor-style']['color'] = $value . "!important;";
                }
                if ($key == 'footer_anchor_color' && $value != "") {
                    $themeOption['.custom-footer.c1-bg a']['color'] = $value . "!important;";
                }
                if ($key == 'footer_anchor_hover_color' && $value != "") {
                    $themeOption['.custom-footer.c1-bg a:hover']['color'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/footer.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set back to top style
     */
    public function setBackToTopStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('back_to_top', $theme->id);

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);
            $first_identifier = implode('_', $splitted_key);

            if ($last_identifier == 'top' || $last_identifier == 'bottom') {
                if ($value = "") {
                    $style[$key] = $value . $style[$first_identifier . "_unit"];
                }
            }

            if ($last_identifier == 'transparent') {
                if ($style[$first_identifier . "_transparent"] == 1) {
                    $style[$first_identifier] = 'transparent';
                }
            }
        }

        $themeOption = [];
        $styleProperties = "";
        if (isset($style['custom_back_to_top_button']) && $style['custom_back_to_top_button'] == 1) {
            foreach ($style as $key => $value) {
                if ($key == 'back_to_top_button_bgcolor' && $value != "") {
                    $themeOption['.custom-back-to-top']['background-color'] = $value . "!important;";
                }
                if ($key == 'back_to_top_button_color' && $value != "") {
                    $themeOption['.custom-back-to-top']['color'] = $value . "!important;";
                }
                if ($key == 'back_to_top_button_hover_bgcolor' && $value != "") {
                    $themeOption['.custom-back-to-top:hover']['background-color'] = $value . "!important;";
                }
                if ($key == 'back_to_top_button_hover_color' && $value != "") {
                    $themeOption['.custom-back-to-top:hover']['color'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/back_to_top.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }
    /**
     * set social icon style
     */
    public function setSocialIconStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('social', $theme->id);

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);
            $first_identifier = implode('_', $splitted_key);

            if ($last_identifier == 'transparent') {
                if ($style[$first_identifier . "_transparent"] == 1) {
                    $style[$first_identifier] = 'transparent';
                }
            }
        }

        $themeOption = [];
        $styleProperties = "";
        if (isset($style['custom_social']) && $style['custom_social'] == 1) {
            foreach ($style as $key => $value) {
                if ($key == 'social_background_color' && $value != "") {
                    $themeOption['.custom-icon-style']['background-color'] = $value . "!important;";
                }
                if ($key == 'social_border_color' && $value != "") {
                    $themeOption['.custom-icon-style']['border-color'] = $value . "!important;";
                }
                if ($key == 'social_color' && $value != "") {
                    $themeOption['.custom-icon-style i']['color'] = $value . "!important;";
                }
                if ($key == 'social_hover_color' && $value != "") {
                    $themeOption['.custom-icon-style i:hover']['color'] = $value . "!important;";
                }
                if ($key == 'social_hover_border_color' && $value != "") {
                    $themeOption['.custom-icon-style:hover']['border-color'] = $value . "!important;";
                }
                if ($key == 'social_hover_background_color' && $value != "") {
                    $themeOption['.custom-icon-style:hover']['background-color'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/social_icon.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set header option style
     */
    public function setHeaderOptionsStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('header', $theme->id);

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);
            $first_identifier = implode('_', $splitted_key);

            if ($last_identifier == 'top' || $last_identifier == 'bottom') {
                if ($value != "") {
                    $style[$key] = $value . $style[$first_identifier . "_unit"];
                }
            }

            if ($last_identifier == 'transparent') {
                if ($style[$first_identifier . "_transparent"] == 1) {
                    $style[$first_identifier] = 'transparent';
                }
            }
        }

        $themeOption = [];
        $styleProperties = "";

        if (isset($style['custom_header']) && $style['custom_header'] == 1) {
            foreach ($style as $key => $value) {
                if ($key == 'header_mid_bg_color' && $value != "") {
                    $themeOption['.offcanvas-wrapper .custom-offcanvas-header']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_mid_text_color' && $value != "") {
                    $themeOption['.offcanvas-wrapper .custom-offcanvas-header']['color'] = $value . "!important;";
                    $themeOption['.offcanvas-wrapper .custom-offcanvas-header a,h4']['color'] = $value . "!important;";
                }
                if ($key == 'header_bot_bg_color' && $value != "") {
                    $themeOption['.custom-header-bottom']['background-color'] = $value . "! important;";
                }
                if ($key == 'header_bot_text_color' && $value != "") {
                    $themeOption['.custom-header-bottom']['color'] = $value . " !important;";
                    $themeOption['.custom-header-bottom .email-text']['color'] = $value . " !important;";
                    $themeOption['.header__two .nav-horizontal > li > a']['color'] = $value . " !important;";
                    $themeOption['.text-color-white']['color'] = $value . " !important;";
                }
                if ($key == 'header_mid_bg_color' && $value != "") {
                    $themeOption['.custom-header-mid.c1-bg']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_mid_text_color' && $value != "") {
                    $themeOption['.custom-header-mid.c1-bg']['color'] = $value . "!important;";
                    $themeOption['.custom-header-mid.c1-bg .site-title']['color'] = $value . "!important;";
                }
                if ($key == 'sticky_header_bg_color' && $value != "") {
                    $themeOption['.custom-header-mid.sticky']['background-color'] = $value . "!important;";
                }
                if ($key == 'sticky_header_text_color' && $value != "") {
                    $themeOption['.custom-header-mid.sticky']['color'] = $value . "!important;";
                    $themeOption['.custom-header-mid.sticky .site-title']['color'] = $value . "!important;";
                }

                if ($key == 'header_top_bg_color' && $value != "") {
                    $themeOption['.custom-header-top-bar']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_top_text_color' && $value != "") {
                    $themeOption['.custom-header-top-bar']['color'] = $value . "!important;";
                }

                if ($key == 'header_mid_bg_color' && $value != "") {
                    $themeOption['.custom-mobile-header.c1-bg']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_mid_text_color' && $value != "") {
                    $themeOption['.custom-mobile-header.c1-bg']['color'] = $value . "!important;";
                }

                if ($key == 'header_search_form_btn_color' && $value != "") {
                    $themeOption['.custom-search-btn']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_search_form_btn_hover_color' && $value != "") {
                    $themeOption['.custom-search-btn:hover']['background-color'] = $value . "!important;";
                }

                if ($key == 'header_search_form_btn_text_color' && $value != "") {
                    $themeOption['.custom-search-btn']['color'] = $value . "!important;";
                }
                if ($key == 'header_search_form_btn_hover_text_color' && $value != "") {
                    $themeOption['.custom-search-btn:hover']['color'] = $value . "!important;";
                }

                if ($key == 'header_icon_btn_bg_color' && $value != "") {
                    $themeOption['.custom-icon-btn']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_icon_btn_text_color' && $value != "") {
                    $themeOption['.custom-icon-btn .material-icons']['color'] = $value . "!important;";
                    $themeOption['.custom-search-btn-mobile svg']['color'] = $value . "!important;";
                }

                if ($key == 'header_icon_btn_hover_bg_color' && $value != "") {
                    $themeOption['.custom-icon-btn:hover']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_icon_btn_hover_text_color' && $value != "") {
                    $themeOption['.custom-icon-btn .material-icons:hover']['color'] = $value . "!important;";
                    $themeOption['.custom-search-btn-mobile svg:hover']['color'] = $value . "!important;";
                }

                if ($key == 'header_top_lang_btn_bg_color' && $value != "") {
                    $themeOption['.custom-lang-switch-btn']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_top_lang_btn_text_color' && $value != "") {
                    $themeOption['.custom-lang-switch-btn']['color'] = $value . "!important;";
                }

                if ($key == 'header_top_lang_btn_hover_bg_color' && $value != "") {
                    $themeOption['.custom-lang-switch-btn:hover']['background-color'] = $value . "!important;";
                }
                if ($key == 'header_top_lang_btn_hover_text_color' && $value != "") {
                    $themeOption['.custom-lang-switch-btn:hover']['color'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/header.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set header logo style
     */
    public function setHeaderLogosStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('header_logo', $theme->id);

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);
            $first_identifier = implode('_', $splitted_key);

            if ($last_identifier == 'top' || $last_identifier == 'bottom' || $last_identifier == 'height' || $last_identifier == 'width') {
                if ($value != "") {
                    $style[$key] = $value . $style[$first_identifier . "_unit"];
                }
            }

            if ($last_identifier == 'transparent') {
                if ($style[$first_identifier . "_transparent"] == 1) {
                    $style[$first_identifier] = 'transparent';
                }
            }
        }

        $themeOption = [];
        $styleProperties = "";

        if (isset($style['custom_header_logo']) && $style['custom_header_logo'] == 1) {
            foreach ($style as $key => $value) {
                if ($key == 'logo_dimension_height' && $value != "") {
                    $themeOption['.custom-logo']['height'] = $value . "!important;";
                }
                if ($key == 'logo_dimension_width' && $value != "") {
                    $themeOption['.custom-logo']['width'] = $value . "!important;";
                }
                if ($key == 'logo_margin_top' && $value != "") {
                    $themeOption['.custom-logo']['margin-top'] = $value . "!important;";
                }
                if ($key == 'logo_margin_bottom' && $value != "") {
                    $themeOption['.custom-logo']['margin-bottom'] = $value . "!important;";
                }

                if ($key == 'sticky_logo_dimension_height' && $value != "") {
                    $themeOption['.sticky .custom-logo']['height'] = $value . "!important;";
                }
                if ($key == 'sticky_logo_dimension_width' && $value != "") {
                    $themeOption['.sticky .custom-logo']['width'] = $value . "!important;";
                }
                if ($key == 'sticky_logo_margin_top' && $value != "") {
                    $themeOption['.sticky .custom-logo']['margin-top'] = $value . "!important;";
                }
                if ($key == 'sticky_logo_margin_bottom' && $value != "") {
                    $themeOption['.sticky .custom-logo']['margin-bottom'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/header_logo.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set header menu style
     */
    public function setHeaderMenuStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('menu', $theme->id);

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);
            $first_identifier = implode('_', $splitted_key);

            if ($last_identifier == 'top' || $last_identifier == 'bottom') {
                if ($value = "") {
                    $style[$key] = $value . $style[$first_identifier . "_unit"];
                }
            }

            if ($last_identifier == 'transparent') {
                if ($style[$first_identifier . "_transparent"] == 1) {
                    $style[$first_identifier] = 'transparent';
                }
            }
        }

        $themeOption = [];
        $styleProperties = "";

        if (isset($style['custom_menu']) && $style['custom_menu'] == 1) {
            foreach ($style as $key => $value) {
                if ($key == 'menu_color' && $value != "") {
                    $themeOption['.custom-menu']['color'] = $value . "!important;";
                }
                if ($key == 'menu_hover_color' && $value != "") {
                    $themeOption['.custom-menu:hover']['color'] = $value . "!important;";
                }
                if ($key == 'sub_menu_color' && $value != "") {
                    $themeOption['.submenu .custom-menu']['color'] = $value . "!important;";
                    $themeOption['.megamenu .custom-menu']['color'] = $value . "!important;";
                    $themeOption['.my-account-dropdown .custom-menu']['color'] = $value . "!important;";
                }
                if ($key == 'sub_menu_hover_color' && $value != "") {
                    $themeOption['.submenu .custom-menu:hover']['color'] = $value . "!important;";
                    $themeOption['.megamenu .custom-menu:hover']['color'] = $value . "!important;";
                    $themeOption['.my-account-dropdown .custom-menu:hover']['color'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/menu.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }

    /**
     * set footer style
     */
    public function setNewsletterStyle()
    {
        $theme = getActiveTheme();
        $style = getThemeOption('subscribe', $theme->id);
        $updatedStyle = [];

        foreach ($style as $key => $value) {
            $splitted_key =  explode('_', $key);
            $last_identifier = array_pop($splitted_key);

            if ($last_identifier == 'color') {
                if (isset($style[$key . "_transparent"]) &&  $style[$key . "_transparent"] == 1) {
                    $value = 'transparent';
                } elseif ($value == null || $value == '') {
                    continue;
                }
            }
            $updatedStyle[$key] = $value;
        }

        $themeOption = [];
        $styleProperties = '';

        if (isset($style['custom_subscription']) && $style['custom_subscription'] == 1) {
            foreach ($updatedStyle as $key => $value) {
                if ($key == 'form_input_color' && $value != "") {
                    $themeOption['.custom-input-style']['background-color'] = $value . "!important;";
                }
                if ($key == 'form_input_text_color' && $value != "") {
                    $themeOption['.custom-input-style']['color'] = $value . "!important;";
                }
                if ($key == 'form_submit_button_color' && $value != "") {
                    $themeOption['.custom-subs-btn']['color'] = $value . "!important;";
                }
                if ($key == 'form_submit_button_bg_color' && $value != "") {
                    $themeOption['.custom-subs-btn']['background-color'] = $value . "!important;";
                }
                if ($key == 'form_submit_button_hover_color' && $value != "") {
                    $themeOption['.custom-subs-btn:hover']['color'] = $value . "!important;";
                }
                if ($key == 'form_submit_button_bg_hover_color' && $value != "") {
                    $themeOption['.custom-subs-btn:hover']['background-color'] = $value . "!important;";
                }
            }
            $styleProperties = makeCssProperties($themeOption);
        }
        $path = base_path('themes/cartlooks-theme/public/css/subscribe.css');
        setFolderPermissions($path);
        file_put_contents($path, $styleProperties);
    }


    /**
     ** reset Theme Option
     * @param object $request
     * @return void
     */
    public function resetThemeOption($request)
    {
        // all css file name
        $themeOptionCssFile = [
            'back_to_top',
            'header',
            'header_logo',
            'menu',
            'blog',
            'sidebar_options',
            'page_404',
            'subscribe',
            'footer',
            'custom_css'
        ];

        $active_theme = getActiveTheme();
        $options =  TlThemeOptionSettings::where('theme_id', $active_theme->id);

        // reset section
        if ($request->submitType == 'reset_section') {
            $path = base_path('themes/cartlooks-theme/public/css/' . $request->option_name . '.css');
            if (file_exists($path)) {
                unlink($path);
            }
            fopen($path, 'w');
            chmod($path, 0777);
            file_put_contents($path, '');
            $options = $options->where('option_name', $request->option_name);
        }

        //  reset all file
        if ($request->submitType == 'reset_all') {
            for ($i = 0; $i < sizeof($themeOptionCssFile); $i++) {
                $path = base_path('themes/cartlooks-theme/public/css/' . $themeOptionCssFile[$i] . '.css');
                if (file_exists($path)) {
                    unlink($path);
                }
                fopen($path, 'w');
                chmod($path, 0777);
                file_put_contents($path, '');
            }
        }

        // update database
        $options = $options->update([
            'field_value' =>  DB::raw('field_reset_value')
        ]);
    }


    /**
     **  save social link
     * @param object $request
     * @return void
     */
    public function saveSocialLink($request)
    {
        $active_theme = getActiveTheme();
        $data = [];

        // icon title
        for ($i = 0; $i < sizeof($request->social_icon_title); $i++) {
            $data[$i]['social_icon_title'] = $request->social_icon_title[$i];
        }

        // icon
        for ($i = 0; $i < sizeof($request->social_icon); $i++) {
            $data[$i]['social_icon'] = $request->social_icon[$i];
        }

        // icon url
        for ($i = 0; $i < sizeof($request->social_icon_url); $i++) {
            $data[$i]['social_icon_url'] = $request->social_icon_url[$i];
        }

        //order
        foreach ($data as $key => $value) {
            $data[$key]['order'] = $key + 1;
        }

        $encoded_data = json_encode($data);

        $option = TlThemeOptionSettings::firstOrNew([
            'option_name' => 'social',
            'theme_id' => $active_theme->id,
            'field_name' => 'social_field'
        ]);

        $option->option_name = 'social';
        $option->theme_id = $active_theme->id;
        $option->field_name = 'social_field';
        $option->field_value = xss_clean($encoded_data);

        $option->exists ? $option->update() : $option->save();
    }

    /**
     ** Save Custom Fonts
     * @param object $request
     * @return void
     */
    public function saveCustomFont($request)
    {
        $active_theme = getActiveTheme();
        $location = 'themes/cartlooks-theme/public/';
        $font_file = ['woff', 'ttf', 'eot'];

        foreach ($request->all() as $key => $value) {
            if (str_contains($key, 'custom_font_1')) {
                $folder = 'custom_font_1';
            } elseif (str_contains($key, 'custom_font_2')) {
                $folder = 'custom_font_2';
            }

            if (str_contains($key, 'file')) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    $name = $file->getClientOriginalName();
                    $path = asset($location . $folder . '/' . $name);
                    if (!file_exists($path)) {
                        $file->move($location . $folder . '/', $name);
                    }
                }
            }

            $key_array = explode('_', $key);
            $file_type = array_pop($key_array);

            if (in_array($file_type, $font_file)) {
                if ($value == '') {
                    $active_theme = getActiveTheme();
                    $name = TlThemeOptionSettings::where([
                        ['theme_id', $active_theme->id],
                        ['option_name', 'custom_fonts'],
                        ['field_name', $key]
                    ])->first();
                    if ($name && $name->field_value != null) {
                        unlink($location . $folder . '/' . $name->field_value);
                    }
                }
            }
        }
        $this->saveThemeOption($request);
    }
}
