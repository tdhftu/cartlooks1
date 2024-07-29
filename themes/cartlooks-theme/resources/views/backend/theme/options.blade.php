@php
    $theme = getActiveTheme();
@endphp
@extends('core::base.layouts.master')

@section('title')
    {{ translate('Theme Options') }}
@endsection

@section('custom_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.css') }}">
    <!--  End select2  -->
    <!--==== Font-Awesome css file ====-->
    <link rel="stylesheet" href="{{ asset('/themes/cartlooks-theme/public/blog/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/themes/cartlooks-theme/public/blog/dist/css/fontawesome-iconpicker.min.css') }}">
    {{-- Jqueey UI CSS --}}
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <!--Editor-->
    <link href="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.css') }}" rel="stylesheet" />
    <!--End editor-->
    <style>
        .active {
            color: #F53B22 !important;
        }

        .iconpicker-container .fade.in {
            opacity: 1;
        }

        .code-editor {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 95%;
            height: 200px;
        }

        .box_shadow_demo {
            display: block;
            width: 100%;
            border: 1px dotted lightgray;
            max-width: 850px;
            padding: 25px;
            font-size: 10pt;
            height: auto;
            margin: 50px 0px 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            overflow: hidden;
            background-color: #fff;
        }

        .box_shadow_inner {
            width: 100%;
            height: 200px;
            background-color: #fff;
        }

        .img-layout {
            min-width: 130px;
            border-width: 4px;
            border-style: solid;
            border-color: #d9d9d9;
            cursor: pointer;
        }

        .input-group-prepend {
            height: 40px;
        }

        .input-group-append {
            height: 40px;
        }

        .social-slide-placeholder {
            height: 40px;
            background: #fad390;
        }

        .ui-accordion .ui-accordion-content {
            overflow: visible;
        }

        .ui-widget-content {
            background: #FFFFFF;
        }

        .ui-state-default {
            background: #FFFFFF;
        }

        /* color input group styles */
        .color {
            width: 250px;
            display: flex;
            align-items: center;
        }

        .color input[type=text] {
            width: 50% !important;
        }

        .color input[type=color] {
            padding: 0;
            border: 0 !important;
            width: 30px !important;
        }

        /* Switch styles change and over wrrite for text inside */
        .switch {
            width: 100px !important;
        }

        .switch .control {
            height: 35px !important;
            width: 100px !important;
            padding-top: 6px !important;
        }

        .switch .control .switch-on {
            display: none !important;
        }

        .switch .control .switch-off {
            margin-left: 40px !important;
            font-weight: 800 !important;
            color: #FFFFFF !important;
        }

        .switch .control:after {
            width: 35px !important;
            height: 35px !important;
        }

        .switch input:checked~.control:after {
            width: 35px !important;
            height: 35px !important;
        }

        .switch input:checked~.control .switch-off {
            display: none !important;
        }

        .switch input:checked~.control .switch-on {
            display: block !important;
            margin-left: 20px !important;
            font-weight: 800 !important;
            color: #1d1c1c !important;
        }

        .switch input:checked~.control:after {
            left: 75px !important;
        }

        /* title position switch change for this specific */
        #blog_post_title_position_switch {
            width: 170px !important;
        }

        .switch input:checked~#blog_post_title_position_switch:after {
            left: 135px !important;
        }

        .theme-option-action_bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .theme-option-sidebar {
            min-width: 260px !important;
        }

        #themeOptionForm {
            min-width: 738px !important;
        }

        .theme-option-container {
            overflow-x: auto;
        }
    </style>
@endsection

@section('main_content')
    <!-- Main Content -->

    <div class="border-bottom2 pb-3 mb-4">
        <h4><i class="icofont-options"></i>{{ translate('Theme Options') }}</h4>
    </div>
    <div class="theme-option-container">
        <form action="{{ route('theme.cartlooks-theme.save.option.form') }}" method="post" enctype="multipart/form-data"
            id="themeOptionForm">
            @csrf
            <input type="hidden" id="formType" name="submitType" value="">
            <div class="theme-option-sticky d-flex align-items-center justify-content-between bg-white border-bottom2 p-3">
                <div class="theme-option-logo d-none d-sm-block">
                    <h3>{{ $theme->name }}</h3>
                </div>
                <div class="theme-option-action_bar">
                    <input type="submit" class="btn btn-primary sm tn btn-primary sm button-save-theme-options"
                        name="save_changes" value="{{ translate('Save Changes') }}">
                    <input type="submit" class="btn btn-info sm" name="reset_section"
                        value="{{ translate('Reset Section') }}">
                    <input type="submit" class="btn btn-info sm" name="reset_all" value="{{ translate('Reset All') }}">
                </div>
            </div>

            <div class="theme-option-tab-wrap">
                <div class="nav flex-column py-3 px-2 theme-option-sidebar" aria-orientation="vertical">
                    @includeIf('theme/cartlooks-theme::backend.theme.option_sidebar')
                </div>

                <div class="form border-left2">
                    <div id="loader" class="d-none">
                        <img src="{{ asset('/public/loader.svg') }}" alt="" width="80px" height="auto">
                    </div>
                    <div class="card">
                        <div class="card-body" id="option-form">
                        </div>
                    </div>
                </div>
            </div>

            <div class="theme-option-sticky d-flex justify-content-end bg-white border-top2 p-3">
                <div class="theme-option-action_bar">
                    <input type="submit" class="btn btn-primary sm tn btn-primary sm button-save-theme-options"
                        name="save_changes" value="{{ translate('Save Changes') }}">
                    <input type="submit" class="btn btn-info sm" name="reset_section"
                        value="{{ translate('Reset Section') }}">
                    <input type="submit" class="btn btn-info sm" name="reset_all" value="{{ translate('Reset All') }}">
                </div>
            </div>
        </form>
    </div>
    @include('core::base.media.partial.media_modal')
    {{-- Reset Section And Reset All Confirmation Model --}}
    <div id="reset-confirmation" class="reset-confirmation modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Reset Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to want to reset') }}?</p>
                    <button class="btn long mt-2 btn-danger" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <button class="btn long mt-2 confirm-btn"></button>
                </div>
            </div>
        </div>
    </div>
    {{-- Reset Section And Reset All Confirmation Model --}}
    <!-- End Main Content -->
@endsection

@section('custom_scripts')
    <!--Select2-->
    <script src="{{ asset('/public/web-assets/backend/plugins/select2/select2.min.js') }}"></script>
    <!--End Select2-->
    {{-- Jqueey UI Js --}}
    <script src="{{ asset('/public/web-assets/backend/plugins/jquery-ui/jquery-ui.js') }}"></script>

    {{-- Fontawesome iconpicker js --}}
    <script src="{{ asset('/themes/cartlooks-theme/public/blog/dist/js/fontawesome-iconpicker.min.js') }}"></script>

    {{-- Code editor --}}
    <script src="https://unpkg.com/ace-builds@1.6.0/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8">
    </script>
    <!--summernote Editor-->
    <script src="{{ asset('/public/web-assets/backend/plugins/summernote/summernote-lite.js') }}"></script>
    <!--End summernote Editor-->

    {{-- Cookies Js --}}
    <script src="{{ asset('/public/web-assets/backend/plugins/js-cookie/js.cookie.min.js') }}"></script>


    <script  type="application/javascript">
        initDropzone()
        // typography variables
        let font_style;
        let weight;
        let default_font_weight_style_list;
        let default_font_subset_list;

        $(document).ready(function() {
            is_for_browse_file = true
            filtermedia();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            //check if theme-option cookies is available or not
            if(Cookies.get('theme-option')){
                let cookies = JSON.parse(Cookies.get('theme-option'));
                $('#'+cookies.option).addClass('active');
                if(cookies.parent !== null){
                    $('#'+cookies.parent).click();
                }
                getOptionForm(cookies.option);
            } else{
                $('#back_to_top').addClass('active');
                let menu = $('#back_to_top').attr('data-menu');
                $('#'+menu).click();
                getOptionForm('back_to_top');
            }

            $('.theme_option_link').click(function(e){
                e.preventDefault();

                $('.theme_option_link').each(function (index, element) {
                    $(this).removeClass('active');
                });
                $(this).addClass('active');

                let id = $(this).attr('id');
                getOptionForm(id);
            });

            // Add click event listener to all submit buttons
            $("input[type='submit']").click(function(event) {
                event.preventDefault();
                let submit = $(this).attr('name');
                let text = $(this).val();
                $('#formType').val(submit);//hidden filed value
                if(submit == 'save_changes'){
                    $('#themeOptionForm').submit();
                } else {
                    showConfirmationModal(text);
                }
            });

            // Show confirmation modal
            function showConfirmationModal(text) {
                $('#reset-confirmation').find(".confirm-btn").text(text);
                $('#reset-confirmation').modal('show');
            }

              // Add click event listener to confirm button
            $(".confirm-btn").click(function() {
                $('#themeOptionForm').submit();
            });
        });

        //get Option Form
        function getOptionForm(id){
            $('#option-form').html('');
            $('.form').addClass('d-flex align-item-center justify-content-center');
            $('#loader').removeClass('d-none').addClass('d-block');
            $.ajax({
                type: "post",
                url: '{{ route('theme.cartlooks-theme.get.option.form') }}',
                data: {
                    id: id
                },
                success: function(res) {
                    if(res.error){
                        toastr.error(res.error, "Error!");
                    } else {
                        $('#option-form').append(res.form);

                        // check if option has parent or not and take the id or add null
                        let parent = null;
                        let menu = $('#'+id).attr('data-menu');
                        if($('#'+menu).length > 0){
                            parent = $('#'+menu).attr('id');
                        }
                        // set cookies for a option
                        Cookies.set('theme-option', JSON.stringify({option : id,parent: parent}), {
                            expires: 1,
                            path: '{{ env("APP_URL") }}'
                        });

                        //color value added to text
                        colorValue();

                        switch (id) {
                            //general
                            case 'back_to_top':
                                back_to_top();
                                break;
                            //typography
                            case 'body_typography':
                                typography();
                                break;
                            case 'paragraph_typography':
                                typography();
                                break;
                            case 'heading_typography':
                                typography();
                                break;
                            case 'menu_typography':
                                typography();
                                break;
                            case 'button_typography':
                                typography();
                                break;
                            case 'custom_fonts':
                                custom_fonts();
                                break;
                            //header menu
                            case 'header':
                                header();
                                break;
                            case 'header_logo':
                                header_logo();
                                break;
                            case 'menu':
                                menuOption();
                                break;
                            //blog
                            case 'blog':
                                blog();
                                break;
                            case 'single_blog_page':
                                single_blog_page();
                                break;
                            case 'sidebar_options':
                                typography();
                                sidebar_options();
                                break;
                            // other
                            case 'page_404':
                                page_404();
                                break;
                            case 'subscribe':
                                subscribe();
                            case 'footer':
                                footer();
                                break;
                            case 'custom_css':
                                custom_css();
                                break;
                            case 'social':
                                social();
                                break;
                            case 'gdpr':
                                setSummerNote();
                                break;
                            case 'website_popup':
                                setSummerNote();
                                break;
                            default:
                                break;
                        }
                    }
                },
                complete: function(){
                    $('#loader').removeClass('d-block').addClass('d-none');
                    $('.form').removeClass('d-flex align-items-center justify-content-center');
                },
                error: function(data, textStatus, jqXHR) {
                    toastr.error('{{ translate('Action Failed') }}', 'ERROR!!');
                }
            });
        }
        //Init summernote
        function setSummerNote()
        {
            $('.text-editor').addClass('summernote_editor');
             $(".summernote_editor").summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ["style", ["style"]],
                ['fontsize', ['fontsize']],
                ["font", ["bold", "underline", "clear"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["insert", ["link", "picture"]],
                ["view", ["fullscreen","codeview", "help"]],
            ],
            callbacks: {
                onImageUpload: function (images, editor, welEditable,) {
                    sendFile(images[0], editor, welEditable, 'summernote_editor');
                }
             }
            });
        }

        // send file function summernote
        function sendFile(image, editor, welEditable, section_id) {
            let imageUploadUrl = '{{ route('core.blog.content.image') }}';
            let data = new FormData();
            data.append("image", image);
            data.append("_token", '{{ csrf_token() }}');

            $.ajax({
                data: data,
                type: "POST",
                url: imageUploadUrl,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    if (data.url) {
                        var image = $('<img>').attr('src', data.url);
                        $('.' + section_id).summernote("insertNode", image[0]);
                    } else {
                        toastr.error(data.error, "Error!");
                    }

                },
                error: function(data) {
                    toastr.error('Image Upload Failed', "Error!");
                }
            });
        }
        //back to top option
        function back_to_top()
        {
            // icon picker init
            $('.icon-picker').iconpicker();
            $('.iconpicker-item').click(function(e){
                e.preventDefault();
            })

            // custom icon field  show/hide
            switchOnShowHideField('#custom_back_to_top_button');

            // back to top button show/hide
            switchOnShowHideField('#back_to_top_button');
        }

        // all the typography
        function typography()
        {
            // select
            select('.select');
            $('.typography_preview').hide();
            
            let data_section;
            let subsetId;
            let fontWeigthId;
            let variations;
            let subsets;
            let val;

            // page onload show selected option
            $('.font_family').each(function (index, element) {
                val = $(this).val();

                if(val.length > 0){
                    data_section = $(this).data('section');
                    subsetId = "#"+data_section+"_font_subsets";
                    fontWeigthId = "#"+data_section+"_font_weight_style_i" ;

                    if(val.includes('custom') === false){
                        variations =  $("option:selected", this).data('variations')
                        subsets =  $("option:selected", this).data('subsets')
                        addedToSubsets(subsetId ,subsets);
                        addedToFontWeight(fontWeigthId ,variations);
                    }

                    $(subsetId+" option").each(function (index, element) {
                        if($(this).val() == $(subsetId).data('value')){
                            $(this).prop('selected',true);
                        }
                    });

                    $(fontWeigthId+" option").each(function (index, element) {
                        if($(this).val() == $(fontWeigthId).data('value')){
                            $(this).prop('selected',true);
                        }
                    });

                    createUrl(data_section);
                }
            });

            // font family change and dynamically add wweight and subsets
            $('.font_family').on('change', function() {
                val = $("option:selected", this).val();
                data_section = $(this).data('section');
                subsetId = "#"+data_section+"_font_subsets";
                fontWeigthId = "#"+data_section+"_font_weight_style_i" ;

                if(val.includes('custom') === false){
                    variations =  $("option:selected", this).data('variations');
                    subsets =  $("option:selected", this).data('subsets');
                    addedToSubsets(subsetId ,subsets);
                    addedToFontWeight(fontWeigthId ,variations);
                } else{
                    $(subsetId).html(default_font_subset_list);
                    $(fontWeigthId).html(default_font_weight_style_list);
                }
                createUrl(data_section);
            })
        }

        // added to subsets (typography)
        function addedToSubsets(subsetId ,subsets)
        {
            default_font_subset_list = $(subsetId).html();
            $(subsetId).html('');
            $(subsetId).append(`<option value="" selected>{{ translate('Select Font Subsets') }}</option>`);
            $(subsets).each(function (index, element) {
                $(subsetId).append(`<option value="${element}">${element}</option>`);
            });
        }

        // added to subsets (typography)
        function addedToFontWeight(fontWeigthId ,variations)
        {
            default_font_weight_style_list = $(fontWeigthId).html();
            $(fontWeigthId).html('');
            $(fontWeigthId).append(`<option value="" selected>{{ translate('Select Weight & Style') }}</option>`);
            $(variations).each(function (index, element) {
                $(fontWeigthId).append(`<option value="${element}">${element}</option>`);
            });
        }

        // create google font url (typography)
        function createUrl(section)
        {
            let font_family = $('#' + section + '_font_family').val();
            let subset = $('#' + section + '_font_subsets').val();
            let variation = $('#' + section + '_font_weight_style_i').val();

            // check if family is selected
            if(font_family.length == 0){
                if (variation.includes('italic')) {
                    weight = variation.replace('italic', '');
                    font_style = 'italic';
                } else {
                    weight = variation
                    font_style = 'normal';
                }
            } else {
                var apiUrl = [];
                apiUrl.push('https://fonts.googleapis.com/css?family=');
                var modified_fontFamily = font_family.replace(',sans-serif', '');
                apiUrl.push(modified_fontFamily.replace(/ /g, '+'));

                if(variation != null)
                {
                    if (variation.includes('italic')) {
                        apiUrl.push(':ital');
                        weight = variation.replace('italic', '');
                        if (weight.length > 0) {
                            apiUrl.push(',wght@1,' + weight);
                        } else {
                            weight = '400';
                            apiUrl.push('@1');
                        }
                        font_style = 'italic';
                    } else {
                        apiUrl.push(':');
                        if (variation == 'regular') {
                            weight = '400';
                        } else {
                            weight = variation;
                        }
                        apiUrl.push('wght@1,' + weight);
                        font_style = 'normal';
                    }
                }

                if (subset) {
                    apiUrl.push('&subset=');
                    apiUrl.push(subset);
                }
                apiUrl.push("&display=swap");
                var url = apiUrl.join('');
                $('link:last').after('<link href="' + url + '" rel="stylesheet" type="text/css">');
                $('#'+section+'_typography_google_link_s').val(url);
            }
            $('#'+section+'_font_style').val(font_style);
            $('#'+section+'_font_weight').val(weight);
            createFontCss(section);
        }

        // create font css (typography)
        function createFontCss(section)
        {
            let font_family = $('#' + section + '_font_family').val();
            let text_align = $('#' + section + '_text_align').val();
            let text_transform = $('#' + section + '_text_transform').val();
            let font_size = $('#' + section + '_font_size').val();
            let line_height = $('#' + section + '_line_height').val();
            let word_spacing = $('#' + section + '_word_spacing').val();
            let letter_spacing = $('#' + section + '_letter_spacing').val();
            let font_color = $('input[name="' + section + '_font_color"]').val();

            let css = {};
            if(font_family && font_family.length > 0){
                css['font-family'] = font_family;
            }
            if(font_style && font_style.length > 0){
                css['font-style'] = font_style;
            }
            if(weight && weight.length > 0){
                css['font-weight'] = weight;
            }
            if(text_align){
                css['text-align'] = text_align;
            }
            if(text_transform){
                css['text-transform'] = text_transform;
            }
            if(font_size){
                css['font-size'] = font_size+'px';
            }
            if(line_height){
                css['line-height'] = line_height+'px';
            }
            if(word_spacing){
                css['word-spacing'] = word_spacing+'px';
            }
            if(letter_spacing){
                css['letter-spacing'] = letter_spacing+'px';
            }
            if(font_color){
                css['color'] = font_color;
            }

            $('#'+section+'_typography_css').val(JSON.stringify(css));
            $('#'+section+'_typography_preview').show();
            $('#'+section+'_typography_preview').removeAttr("style");
            $('#'+section+'_typography_preview').css(css);
        }

        //custom fonts function
        function custom_fonts()
        {
            // check if any input file has value then show the name and remove option
            $('.custom_font_files').each(function (index, element) {
                if($(this).val() !== ''){
                    $(this).next().prop('readonly',true);
                    $(this).next().val($(this).val());
                    $(this).siblings(":last").removeClass('d-none');
                }
            });

            // file on uploade add name to box and show remove option
            $('.font_file_upload').on('change', function(){
                let file_path = $(this).val().replace('C:\\fakepath\\', '');
                $(this).prev().prop('readonly',true);
                $(this).prev().val(file_path);
                $(this).siblings(":first").val(file_path);
                $(this).siblings(":last").removeClass('d-none');
            });

            // click remove option and clear box and value
            $('.remove_file_name').on('click', function(){
                $(this).siblings(":first").val('');
                $(this).siblings('.file_name').val('');
                $(this).addClass('d-none');
            })

            // custom font 1 switch enable field show/hide
            switchOnShowHideField('#custom_font_1');

            // custom font 2 switch enable field show/hide
            switchOnShowHideField('#custom_font_2');
        }

        // header option
        function header()
        {
             $('.icon-picker').iconpicker();
            $('.iconpicker-item').click(function(e){
                e.preventDefault();
            });
            // custom header field
            switchOnShowHideField('#custom_header');
           
        }
        

        //header_logo option
        function header_logo()
        {
            // select add
            select('.select');
            // custom logo field
            switchOnShowHideField('#custom_header_logo');
        }

        //menu option
        function menuOption()
        {
            // custom menu field
            switchOnShowHideField('#custom_menu');
        }

        // blog option
        function blog()
        {
            $('.layout_img').addClass('img-layout');
            // blog layout image radio group
            imageRadioGroup('blog_layout');

            // blog colum image radio group
            imageRadioGroup('blog_colum');

            // blog title character range picker and perpage blog
            rangeSelector('#blog_posts_excerpt',100);
            rangeSelector('#blog_perpage',100);

            // read more text setting field show/hide
            switchOnShowHideField('#read_more_text_setting');

            // border color for the checked pagination position
            let check_position = $('input[name="blog_pagination_position"]:checked');
            check_position.parent().addClass('active');

            // custom box show hide
            switchOnShowHideField('#custom_blog');
        }

        // single_blog_page
        function single_blog_page()
        {
            $('.layout_img').addClass('img-layout');
            // single blog page layout radio group
            imageRadioGroup('single_blog_page_layout');
            //blog post title position field show/hide
            switchOnShowHideField('#custom_blog_page');
        }

        // sidebar_options
        function sidebar_options()
        {
            // select add
            select('.select');
            //set class to shadow peviewer
            $('#shadow_previewer').addClass('box_shadow_demo');
            $('.shadow-previewer-inner').addClass('box_shadow_inner');
            //widget custom box field show/hide
            switchOnShowHideField('#custom_sidebar');
        }

        // box shadow style (sidebar options)
        function boxShadowStyle ()
        {
            let color        = hexToRgb($('#box_shadow_color').val());
            let offset_x     = $('#box_shadow_offset_x').val();
            let offset_y     = $('#box_shadow_offset_y').val();

            let blur_radius  = $('#box_shadow_blur_radius').val();
            let spread_radius = $('#box_shadow_spread_radius').val();

            let unit          = $('#box_shadow_unit').val();
            let opacity       = $('#box_shadow_opacity').val();

            let type         = $('#box_shadow_type').val();
            if(type == 'outside'){
                type = '';
            }

            let box_color;
            if(opacity < 0 && opacity > 1){
              box_color = 'rgb('+color.r+','+color.g+','+color.b+')';
            } else {
              box_color = 'rgba('+color.r+','+color.g+','+color.b+','+opacity+')';
            }

            let box_shadow =box_color +offset_x+unit+' '+offset_y+unit+' '+blur_radius+unit+' '+spread_radius+unit+' '+type;
            $('#widget_custom_box-shadow').val(box_shadow);
            $('.shadow-previewer-inner').css({
                'box-shadow': box_shadow
            });
        }

        // hex value to rgb (sidebar options)
        function hexToRgb(hex)
        {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        // page 404 options 
        function page_404 ()
        {
            // 404 custom show hide
            switchOnShowHideField('#custom_404');
        }

        //subscribe option
        function subscribe()
        {
            // select add
            select('.select');
            //page title field show/hide
            switchOnShowHideField('#custom_subscription');
            //page title field show/hide
            switchOnShowHideField('#footer_subscribe_form');
        }

        //footer option
        function footer()
        {
            // select add
            select('.select');
            //footer text on field show/hide
            switchOnShowHideField('#custom_footer');
        }

        //custom_css option
        function custom_css()
        {
            // code editor css
            $('#custom_css_code_editor').addClass('code-editor');
            // instance of code editor
            let editor = ace.edit("custom_css_code_editor");
            editor.setTheme("ace/theme/terminal");
            editor.getSession().setMode("ace/mode/css");
            editor.resize();

            //setting code editor value in a textarea field
            let code = editor.getValue();
            $("#custom_css_code").text(code);

            $(".ace_text-input").keyup(function (e) { 
                code = editor.getValue();
                $("#custom_css_code").text(code);
            });
        }

        //social option
        function social()
        {
            $("#socialAccordion")
            .accordion({
                collapsible: true,
                header: "> div > h2",
                dropOnEmpty: true,
                autoHeight: true,
                active: false
            })
            .sortable({
                axis: "y",
                placeholder: 'social-slide-placeholder',
                revert: "invalid",
                update: function(event, ui) {
                    let selectedSidebar = $(this).attr('id');
                }
            });

            socialSlideEvent();

            $('#addSlide').click(function () { 
               let newSlide = newSocialSlide();
               $('#socialAccordion').append(newSlide);
               $('#socialAccordion').accordion("refresh");
               $('#socialAccordion').sortable("refresh");
               socialSlideEvent();
             });
            // social custom field show/hide
            switchOnShowHideField('#custom_social');
        }

        // social slide append (social)
        function newSocialSlide()
        {
            let html = `
            <div class="accordion-item my-2">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button bg-transparent">
                        {{ translate('New Social Link') }}
                    </button>
                </h2>
                <div class="accordion-body row">
                    <div class="col-xl-12">
                        <input type="text" name="social_icon_title[]" class="form-control icon_title my-3"
                            placeholder="{{ translate('Title') }}">

                        <input type="text" name="social_icon[]" class="form-control icon-picker my-3"
                            placeholder="{{ translate('Icon(example: fa fa-facebook)') }}">

                        <input type="text" name="social_icon_url[]" class="form-control my-3"
                            placeholder="{{ translate('Url') }}">
                    </div>
                    <div class="col-xl-12 offset-xl-10">
                        <button type="button"
                            class="btn btn-danger accordion-delete sm">{{ translate('Delete') }}</button>
                    </div>
                </div>
            </div>
            `;
            return html;
        }

        //initialize social slide events (social)
        function socialSlideEvent()
        {
            // icon picker init
            $('.icon-picker').iconpicker();
            $('.iconpicker-item').click(function(e){
                e.preventDefault();
            });

            $('.icon_title').on('input',function(){
                let title = $(this).val();
                $(this).parents(':eq(2)').find('.accordion-button').text(title);
            });

            $('.accordion-delete').click(function(){
                if($('.accordion-item').length == 1){
                } else {
                    $(this).parents(':eq(2)').remove();
                }
            });

            $('#socialAccordion').on('accordionactivate', function (event, ui) {
                if (ui.newPanel.length) {
                    $('#socialAccordion').sortable('disable');
                } else {
                    $('#socialAccordion').sortable('enable');
                }
            });
        }

        // theme options switch on field show and hide
        function switchOnShowHideField(checkbox_input_id)
        {
            let field;
            if(!$(checkbox_input_id).is(":checked")){
                field = $(checkbox_input_id+'_switch_on_field').detach();
            }
            $(checkbox_input_id+'_switch').click(function(){
                if($(checkbox_input_id+'_switch_on_field').length == 1){
                    field = $(checkbox_input_id+'_switch_on_field').detach();
                } else {
                    $(checkbox_input_id+'_switch').parents(':eq(2)').after(field);
                }
            });
        }

        //theme options image radio checked
        function imageRadioGroup(image_field)
        {
            // on load checked image border color
            let checked_image = $('input[name="'+image_field+'"]:checked').val();
            if(checked_image && image_field == "blog_colum"){
                checked_image = checked_image.split(' ').join('-')
            }
            $('label[for="'+checked_image +'"]').find('img').css({
                    "border-color": "#0073aa"
            });
            
            // image click and set border color
            $('#'+image_field+'_image_field .layout_img').click(function () { 
                $('#'+image_field+'_image_field .layout_img').each(function (index, element) {
                    $(this).css({
                        "border-color": "#d9d9d9",
                    })
                });
                $(this).css({
                    "border-color": "#0073aa"
                });
            });
        }

        // opacity range
        function rangeSelector(opacity_input , count)
        {
            $(opacity_input).val($(opacity_input+'_range').val());
            $(opacity_input+'_range').on('input', function() {
                $(opacity_input).val($(this).val());
            });
            
            $(opacity_input).on('input', function(){
                let val = $(this).val()
                if(val > count){
                    $(opacity_input).val(count);
                    $(opacity_input+'_range').val(count);
                } else{
                    $(opacity_input+'_range').val(val);
                }
            })
        }

        // select plugin function
        function select(element)
        {
            $(element).select2({
                theme: "classic",
            });
        }

        // color value get
        function colorValue(){
            $('input[type=color]').on('input', function(){
                let value = $(this).val();
                $(this).prev().val(value);
            });

            $('.color input[type=text]').each(function (index, element) {
                $(this).prop('readonly', true);  
            });
        }
    </script>
@endsection
