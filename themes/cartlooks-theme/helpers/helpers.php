<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Core\Repositories\MenuRepository;
use Theme\CartLooksTheme\Models\TlWidget;
use Illuminate\Support\Facades\Session;
use Theme\CartLooksTheme\Models\TlThemeSidebar;
use Theme\CartLooksTheme\Repositories\BlogRepository;
use Theme\CartLooksTheme\Models\TlSidebarWidgetHasValue;

if (!function_exists('getMenuStructure')) {
    /**
     * get menu structure to show in frontend
     * @return mixed|array
     */
    function getMenuStructure($position_id)
    {
        $menu_repo = new MenuRepository();
        $menu_structure = $menu_repo->getMenuStructureForView($position_id);
        return $menu_structure;
    }
}

if (!function_exists('getMenuStructureByGroupId')) {
    /**
     * get menu structure by group id
     * @return mixed|array
     */
    function getMenuStructureByGroupId($group_id)
    {
        $placeholder_image = getPlaceHolderImage();
        $menu_info = [
            'tl_menus.id',
            'tl_menus.parent_id',
            'tl_menus.level',
            'tl_menus.title',
            'tl_menus.url',
            'tl_menus.url as preview_url',
            'tl_menus.icon',

            'tl_menus.menu_type_id',
            'tl_menus.menu_type',

            'tl_uploaded_files.path as path',
            'tl_uploaded_files.alt as alt',

            'tl_menu_groups.name as group_name'
        ];
        $match_case = [];
        array_push($match_case, [
            'tl_menu_groups.id', '=', $group_id
        ]);

        $data = DB::table('tl_menus')
            ->join('tl_menu_groups', 'tl_menu_groups.id', '=', 'tl_menus.menu_group_id')
            ->leftJoin('tl_uploaded_files', 'tl_uploaded_files.id', '=', 'tl_menus.icon')
            ->orderBy('index')
            ->orderBy('level')
            ->where($match_case)
            ->select($menu_info)->get();

        for ($i = 0; $i < sizeof($data); $i++) {
            $data[$i]->index = $i;
            if ($data[$i]->icon == null || $data[$i]->icon == 'null' || $data[$i]->icon == '' ||  $data[$i]->icon == ' ') {
                $data[$i]->path = $placeholder_image->placeholder_image;
                $data[$i]->alt = $placeholder_image->placeholder_image_alt;
                if (Session::get('api_locale') != null && Session::get('api_locale') != getGeneralSetting('default_language')) {
                    $translated_title = getTranslatedMenuTitle($data[$i]->id, Session::get('api_locale'), $data[$i]->title);
                    $data[$i]->title = $translated_title;
                } else {
                    $translated_title = getTranslatedMenuTitle($data[$i]->id, getGeneralSetting('default_language'), $data[$i]->title);
                    $data[$i]->title = $translated_title;
                }
            } else {
                $data[$i]->alt = $data[$i]->title;
            }
            if ($data[$i]->menu_type_id != null) {
                $data[$i]->preview_url = URL::to($data[$i]->url);
            }
        }

        $final_data = [];
        $pushed_menu_id = [];
        $menu_repo = new MenuRepository();

        for ($i = 0; $i < sizeof($data); $i++) {
            if (!in_array($data[$i]->id, $pushed_menu_id)) {
                array_push($final_data, $data[$i]);
                array_push($pushed_menu_id, $data[$i]->id);
                $final_data = $menu_repo->getChildMenus($data[$i]->id, $data, $final_data);
            }
        }

        return $final_data;
    }
}

if (!function_exists('frontendSidebarFeaturedBlogs')) {

    /**
     *Frontend Blog Categories
     * @return mixed|array
     */
    function frontendSidebarFeaturedBlogs($limit)
    {
        $data = [
            DB::raw('GROUP_CONCAT(distinct tl_blogs.id) as id'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.name) as name'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.permalink) as permalink'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.image) as image'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.publish_at) as publish_at'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.short_description) as short_description')
        ];

        $match_case = [
            ['tl_blogs.publish_at', '<', currentDateTime()],
            ['tl_blogs.is_publish', '=', config('settings.blog_status.publish')],
            ['tl_blogs.is_featured', '=',  1]
        ];

        // initialize Blog Repository
        $blog_repository = new BlogRepository();
        $featured_blogs = $blog_repository->getBlogs($data, $match_case, $limit);

        foreach ($featured_blogs as $blog) {
            $blog->name = $blog->translation('name', Session::get('api_locale'));
        }
        return $featured_blogs;
    }
}

if (!function_exists('frontendSidebarRecentBlogs')) {
    /**
     *Frontend Blog Categories
     * @return mixed|array
     */
    function frontendSidebarRecentBlogs($limit)
    {
        $data = [
            DB::raw('GROUP_CONCAT(distinct tl_blogs.id) as id'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.name) as name'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.permalink) as permalink'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.image) as image'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.publish_at) as publish_at'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.short_description) as short_description')
        ];

        $match_case = [
            ['tl_blogs.publish_at', '<', currentDateTime()],
            ['tl_blogs.is_publish', '=', config('settings.blog_status.publish')],
        ];
        // initialize Blog Repository
        $blog_repository = new BlogRepository();
        $recent_blogs = $blog_repository->getBlogs($data, $match_case, $limit);

        foreach ($recent_blogs as $blog) {
            $blog->name = $blog->translation('name', Session::get('api_locale'));
            $blog->short_description = $blog->translation('short_description', Session::get('api_locale'));
        }

        return $recent_blogs;
    }
}

if (!function_exists('commentClose')) {

    /**
     ** Comment Should be Close or not 
     * @return boolean
     */
    function commentClose($publish_at)
    {
        $commentSettings = commentFormSettings();
        $comment_close_date = date('Y-m-d', strtotime($publish_at . ' + ' . $commentSettings['close_comments_days_old'] . ' days'));
        $comment_close = currentDateTime() > $comment_close_date ? true : false;
        return $comment_close;
    }
}


if (!function_exists('getAllSidebarWidgets')) {
    /**
     * get all the widget of a sidebar
     * @return mixed|array
     */
    function getAllSidebarWidgets($sidebar_id)
    {
        $widgets = DB::table('tl_sidebar_has_widgets')
            ->join('tl_widgets', 'tl_widgets.id', '=', 'tl_sidebar_has_widgets.widget_id')
            ->where('tl_sidebar_has_widgets.sidebar_id', '=', $sidebar_id)
            ->select(
                'tl_sidebar_has_widgets.id as sidebar_has_widget_id',
                'tl_widgets.id as widget_id',
                'tl_widgets.widget_name',
            )
            ->orderBy('tl_sidebar_has_widgets.order', 'asc')
            ->get();

        return $widgets;
    }
}


if (!function_exists('getThemeOption')) {
    /**
     * get theme option of specific field
     * @return mixed|array
     */
    function getThemeOption($option_name, $theme_id)
    {
        $options = DB::table('tl_theme_option_settings')
            ->where('option_name', $option_name)
            ->where('theme_id', $theme_id)
            ->select([
                'tl_theme_option_settings.field_name',
                'tl_theme_option_settings.field_value',
            ])
            ->get();

        $update_options = [];
        foreach ($options as $key => $value) {
            $update_options[$value->field_name] = $value->field_value;
        }
        return $update_options;
    }
}


if (!function_exists('getAllFonts')) {
    /**
     * get all font family,variants and subsets from google api
     * @return mixed|array
     */
    function getAllFonts()
    {
        $url = config('cartlooks-theme.google_font_api_key.url');
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        $data = [];
        for ($i = 0; $i < sizeof($json_data['items']); $i++) {
            $item = $json_data['items'][$i];

            $data[$i]['family'] = $item['family'];
            $data[$i]['variants'] = json_encode($item['variants']);
            $data[$i]['subsets'] = json_encode($item['subsets']);
        }
        return $data;
    }
}

if (!function_exists('themeOptionToCss')) {
    /**
     * get theme options and make css
     * @return mixed|array
     */
    function themeOptionToCss($option_name, $active_theme_id)
    {
        $options = getThemeOption($option_name, $active_theme_id);
        $mainCss = [];

        foreach ($options as $key => $value) {
            $splitted_key = explode('_', $key);
            $property = array_pop($splitted_key);
            $section = join('_', $splitted_key);

            //ignore key
            if ($property === 'i') {
                continue;
            } elseif ($property === 's') {
                $mainCss['static'][$key] = $value;
                continue;
            } elseif ($property === 'c') {
                $mainCss['condition'][$key] = $value;
                continue;
            } else {
                if ($value != '') {
                    if (str_contains($section, '_u')) {
                        $splitted_section_name_array = explode('_', $section);
                        array_pop($splitted_section_name_array);
                        $section = join('_', $splitted_section_name_array);
                        $value = $value . $options[$section . '_unit_i'];
                    } else {
                        if ($property === 'color' || $property === 'background-color') {
                            if (isset($options[$key . "-transparent_i"])  && $options[$key . "-transparent_i"] == 1) {
                                $value = 'transparent';
                            }
                        }
                    }
                } else {
                    continue;
                }
                if ($property == 'font-family' && str_contains($value, 'custom')) {
                    $font_face_value = createFontFace($value);
                    if (!empty($font_face_value)) {
                        $mainCss['css']['@font-face-' . $section] = $font_face_value;
                    }
                }
                $mainCss['css'][$section][$property] = $value;
            }
        }
        return $mainCss;
    }
}

if (!function_exists('createFontFace')) {
    /**
     * creating font face
     * @param $font_family font family
     * @return mixed|string
     */
    function createFontFace($font_family)
    {
        $family_split = explode(',', $font_family);
        $custom_font_number = str_replace('-', '_', $family_split[0]);

        $active_theme = getActiveTheme();
        $custom_options = getThemeOption('custom_fonts', $active_theme->id);

        $customFontFace = [];
        if ($custom_options[$custom_font_number] == '1') {
            $customFontFace['font-family'] = $family_split[0];
            $font_woff_file = $custom_options[$custom_font_number . '_woff'];
            $font_ttf_file = $custom_options[$custom_font_number . '_ttf'];
            $font_eot_file = $custom_options[$custom_font_number . '_eot'];

            if ($font_woff_file != '') {
                if (isset($customFontFace['src']) && $customFontFace['src'] != '') {
                    $customFontFace['src'] = $customFontFace['src'] . ',' . "url('" . asset('themes/cartlooks-theme/public/' . $custom_font_number . '/' . $font_woff_file) . "')";
                } else {
                    $customFontFace['src'] = "url('" . asset('themes/cartlooks-theme/public/' . $custom_font_number . '/' . $font_woff_file) . "')";
                }
            }

            if ($font_ttf_file != '') {
                if (isset($customFontFace['src']) && $customFontFace['src'] != '') {
                    $customFontFace['src'] = $customFontFace['src'] . ',' . "url('" . asset('themes/cartlooks-theme/public/' . $custom_font_number . '/' . $font_ttf_file) . "')";
                } else {
                    $customFontFace['src'] = "url('" . asset('themes/cartlooks-theme/public/' . $custom_font_number . '/' . $font_ttf_file) . "')";
                }
            }

            if ($font_eot_file != '') {
                if (isset($customFontFace['src']) && $customFontFace['src'] != '') {
                    $customFontFace['src'] = $customFontFace['src'] . ',' . "url('" . asset('themes/cartlooks-theme/public/' . $custom_font_number . '/' . $font_eot_file) . "')";
                } else {
                    $customFontFace['src'] = "url('" . asset('themes/cartlooks-theme/public/' . $custom_font_number . '/' . $font_eot_file) . "')";
                }
            }
        }
        return $customFontFace;
    }
}

if (!function_exists('getThemeWidgetId')) {
    /**
     * Get theme widget id
     *
     * @param String $widget_name
     * @return mixed
     */
    function getThemeWidgetId($widget_name)
    {
        $active_theme = getActiveTheme();
        $name = ucwords(str_replace('_', ' ', $widget_name));
        $widget = TlWidget::firstOrCreate(['widget_name' => $name, 'theme_id' => $active_theme->id]);
        if ($widget != null) {
            return $widget->id;
        }
        return null;
    }
}

if (!function_exists('getThemeWidgetName')) {
    /**
     * Get theme widget name
     *
     * @param int $widget_id
     * @return mixed
     */
    function getThemeWidgetName($widget_id)
    {
        $active_theme = getActiveTheme();
        $widget = TlWidget::where(['id' => $widget_id, 'theme_id' => $active_theme->id])->first();
        if ($widget != null) {
            $name = str_replace(' ', '_', strtolower($widget->widget_name));
            return $name;
        }
        return null;
    }
}

if (!function_exists('getThemeWidgetNameAsArray')) {
    /**
     * Get theme widget name as array
     *
     * @param String $theme_widget_names
     * @return mixed
     */
    function getThemeWidgetNameAsArray($theme_widget_names)
    {
        $all_settings_name = config('cartlooks-theme.' . $theme_widget_names);
        $names = [];
        $ids = [];
        for ($i = 0; $i < sizeof($all_settings_name); $i++) {
            $ids[$i] = getThemeWidgetId($all_settings_name[$i]);
            $names[$i] = $all_settings_name[$i];
        }
        return $names;
    }
}

if (!function_exists('getThemeSidebarId')) {
    /**
     * Get theme sidebar id
     *
     * @param String $sidebar_name
     * @return mixed
     */
    function getThemeSidebarId($sidebar_name)
    {
        $active_theme = getActiveTheme();
        $name = ucwords(str_replace('_', ' ', $sidebar_name));
        $sidebar = TlThemeSidebar::firstOrCreate(['sidebar_name' => $name, 'theme_id' => $active_theme->id]);
        if ($sidebar != null) {
            return $sidebar->id;
        }
        return null;
    }
}

if (!function_exists('getThemeSidebarNameAsArray')) {
    /**
     * Get theme widget name as array
     *
     * @param String $theme_widget_names
     * @return mixed
     */
    function getThemeSidebarNameAsArray($theme_sidebar_names)
    {
        $all_settings_name = config('cartlooks-theme.' . $theme_sidebar_names);
        $names = [];
        $ids = [];
        for ($i = 0; $i < sizeof($all_settings_name); $i++) {
            $ids[$i] = getThemeSidebarId($all_settings_name[$i]);
            $names[$i] = $all_settings_name[$i];
        }
        return $names;
    }
}

if (!function_exists('getValuesForWidgetsInSidebar')) {
    /**
     * Will return values for widgets in sidebar
     * @param Int $widget
     * @param Int $sidebar_id
     * @return String
     */
    function getValuesForWidgetsInSidebar($sidebar_id, $widget)
    {
        $properties = DB::table('tl_theme_sidebars')
            ->join('tl_sidebar_has_widgets', 'tl_sidebar_has_widgets.sidebar_id', '=', 'tl_theme_sidebars.id')
            ->join('tl_sidebar_widget_has_values', 'tl_sidebar_widget_has_values.sidebar_has_widget_id', '=', 'tl_sidebar_has_widgets.id')
            ->where('tl_theme_sidebars.id', '=', $sidebar_id)
            ->where('tl_sidebar_has_widgets.widget_id',  '=', $widget)
            ->select('tl_sidebar_widget_has_values.value')
            ->first();

        if ($properties != null) {
            return json_decode($properties->value);
        }

        return null;
    }
}

if (!function_exists('getSidebarWidgetValues')) {
    /**
     * Will return values for widgets in sidebar
     * @param Int $sidebar_has_widget_id
     * @return String
     */
    function getSidebarWidgetValues($sidebar_has_widget_id, $lang)
    {
        $sidebar_widget_value = TlSidebarWidgetHasValue::where('sidebar_has_widget_id', $sidebar_has_widget_id)->first();
        $value = null;
        if ($sidebar_widget_value != null) {
            $translated_value = $sidebar_widget_value->translation('value', $lang);
            if ($sidebar_widget_value->value != null) {
                $real_widget_content = json_decode($sidebar_widget_value->value, true);
                $translated_content = json_decode($translated_value, true);
                if ($real_widget_content != null && $translated_content != null) {
                    $value = array_replace($real_widget_content, $translated_content);
                }
            } else {
                $value = json_decode($translated_value, true);
            }
        }
        return $value;
    }
}

if (!function_exists('makeCssProperties')) {
    /**
     * make array to css
     * @param array $themeOption
     * @return string
     */
    function makeCssProperties($themeOption)
    {
        $pre_style = substr(json_encode($themeOption), 1, -1);
        $after_removing_quote = str_replace('"', '', $pre_style);
        $after_removing_colon = str_replace(':{', '{' . "\n", $after_removing_quote);
        $after_removing_comma = str_replace('},', '}' . "\n", $after_removing_colon);
        $after_removing_comma_inside_css = str_replace(';,', ';' . "\n", $after_removing_comma);
        $after_adding_newline = str_replace(';}', ';' . "\n" . '}', $after_removing_comma_inside_css);
        $all_fontface = [
            '@font-face-body_font',
            '@font-face-paragraph_font',
            '@font-face-all_heading_font',
            '@font-face-h1_heading_font',
            '@font-face-h2_heading_font',
            '@font-face-h3_heading_font',
            '@font-face-h4_heading_font',
            '@font-face-h5_heading_font',
            '@font-face-h6_heading_font',
            '@font-face-menu_font',
            '@font-face-sub_menu_font',
            '@font-face-button_font',
            '@font-face-widget_title_font',
            '@font-face-page_title_font',
        ];
        $after_modify_fontface = str_replace($all_fontface, '@font-face', $after_adding_newline);

        return $after_modify_fontface;
    }
}

if (!function_exists('setFolderPermissions')) {
    /**
     * set folder permissions
     * @return string
     */
    function setFolderPermissions($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
        fopen($path, 'w');
        chmod($path, 0777);
    }
}
