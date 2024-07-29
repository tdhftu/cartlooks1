<?php

use Carbon\CarbonPeriod;
use Core\Models\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

if (!function_exists('saveFileInStorage')) {
    /**
     * save file
     *
     * @param mixed $file
     * @param mixed $file_name
     * @param mixed $location
     * @return mixed
     */
    function saveFileInStorage($file, $static_path = null)
    {

        try {
            $upload_path = "uploaded";
            $disk = 'public';
            if ($static_path != null) {
                $destination_path = $upload_path . '/' . $static_path;
            } else {
                $dynamic_path = date("Y") . "/" . date("M");
                $destination_path = $upload_path . '/' . $dynamic_path;
            }

            if (!File::exists('public/' . $destination_path)) {
                File::makeDirectory('public/' . $destination_path, 0777, true);
            }

            $file_extension = $file->getClientOriginalExtension();
            $file_original_name = $file->getClientOriginalName();
            $file_file_size = $file->getSize();
            $exploded_file_original_name = explode('.', $file_original_name);
            $original_file_name_without_extension = $exploded_file_original_name[0];

            //Store file 
            $file_full_path = $file->store($destination_path, $disk);
            if (File::exists('public/' . $file_full_path)) {
                chmod('public/' . $file_full_path, 0777);
            }
            $file_type = '';

            if ($file_extension == 'pdf') {
                $file_type = 'pdf';
            } elseif ($file_extension == 'zip') {
                $file_type = 'zip';
            } elseif ($file_extension == 'mp4') {
                $file_type = 'video';
            } elseif ($file_extension == 'webp') {
                $file_type = 'webp';
            } else {
                $file_type = 'image';
            }

            //Store file info in database
            $uploaded_file = new UploadedFile();
            $uploaded_file->name = $original_file_name_without_extension;
            $uploaded_file->size = $file_file_size;
            $uploaded_file->path = $file_full_path;
            $uploaded_file->folder_name = $destination_path;
            $uploaded_file->file_type = $file_extension;
            $uploaded_file->uploaded_by = Auth::user() != null ? Auth::user()->name : null;
            $uploaded_file->user_id = Auth::user() != null ? Auth::user()->id : null;
            $uploaded_file->extension = $file_extension;
            $uploaded_file->saveOrFail();

            //customize images with Intervention image 
            if ($file_type == 'image') {
                $resizes_formats = customizeImage($file_full_path, $destination_path);
                $uploaded_file->variant = json_encode($resizes_formats);
                $uploaded_file->update();
            }

            return $uploaded_file->id;
        } catch (\Exception $e) {
            return null;
        }
    }
}


if (!function_exists('customizeImage')) {
    /**
     * Will customize image
     *
     * @return mixed
     */
    function customizeImage($file_full_path, $destination_path)
    {
        try {
            $image_source_path = 'public/' . $file_full_path;
            $full_path_array = explode('/', $file_full_path);
            $file_full_name = $full_path_array[sizeof($full_path_array) - 1];
            $file_full_name_array = explode('.', $file_full_name);
            $file_name = $file_full_name_array[0];
            $extension = $file_full_name_array[1];
            $modified_file_path_prefix = 'public/' . $destination_path . '/' . $file_name;

            //Apply Water mark
            $is_watermark_enable = getGeneralSetting('watermark_status');
            if ($is_watermark_enable == 'on') {
                applyWaterMarkImage($image_source_path);
            }

            //Cropping theme based image
            $active_theme = getActiveTheme();
            if ($active_theme != null) {
                $theme_path = $active_theme->location;
                $cropping_sizes = config($theme_path . '.image_cropping_sizes');
                if ($cropping_sizes != null) {
                    foreach ($cropping_sizes as $size) {
                        $image_dimension = explode('x', $size);
                        $resizing_file_path = $modified_file_path_prefix . $size . '.' . $extension;

                        $cropping_img = Image::make($image_source_path)
                            ->resize($image_dimension[0], $image_dimension[1])
                            ->crop($image_dimension[0], $image_dimension[1]);
                        $cropping_img->save($resizing_file_path);

                        if (File::exists($resizing_file_path)) {
                            chmod($resizing_file_path, 0777);
                        }
                    }
                    return $cropping_sizes;
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('applyWaterMarkImage')) {
    /**
     * Apply Water mark
     *
     * @return mixed
     */
    function applyWaterMarkImage($image_source_path)
    {
        $watermark_image_opacity = getGeneralSetting('water_marking_image_opacity') != null ? getGeneralSetting('water_marking_image_opacity') : 1;
        $watermark_image_position = getGeneralSetting('watermark_image_position') != null ? getGeneralSetting('watermark_image_position') : 'center';
        $watermark_image_id = getGeneralSetting('watermark_image');
        $watermark_image = getGeneralSetting('watermark_image') != null ? getFilePath($watermark_image_id, false) : null;

        if ($watermark_image != null) {
            $water_mark = Image::make(trim($watermark_image, '/'));
            $water_mark->opacity((int)$watermark_image_opacity);

            $modified_image = Image::make($image_source_path);
            $modified_image->insert($water_mark, $watermark_image_position, 10, 10);
            $modified_image->save($image_source_path);
        }
    }
}

if (!function_exists('removeMediaById')) {
    /**
     * Will remove single media by id
     *
     * @param Int $media_id
     * @return bool
     */
    function removeMediaById($media_id)
    {
        try {
            DB::beginTransaction();
            $media = UploadedFile::find($media_id);

            $path = 'public/' . $media->path;

            if ($media != null && $media->variant != null) {
                $all_variants = json_decode($media->variant);
                //Unlink variant images
                foreach ($all_variants as $variant_size) {
                    $variant_size_string = null;
                    if (is_array($variant_size)) {
                        $variant_size_string = implode('x', $variant_size);
                    } else {
                        $variant_size_string = $variant_size;
                    }

                    if ($variant_size_string != null) {
                        $full_path_array = explode('/', $path);
                        $file_full_name = $full_path_array[sizeof($full_path_array) - 1];
                        $file_full_name_array = explode('.', $file_full_name);
                        $file_name = $file_full_name_array[0];
                        $extension = $file_full_name_array[1];

                        $variant_image_name = $file_name . $variant_size_string . '.' . $extension;
                        $variant_image_path = 'public/' . $media->folder_name . '/' . $variant_image_name;
                        if (file_exists($variant_image_path)) {
                            unlink($variant_image_path);
                        }
                    }
                }
            }

            if (file_exists($path)) {
                unlink($path);
            }

            $media->delete();
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        } catch (Error $ex) {
            DB::rollBack();
            return false;
        }
    }
}

if (!function_exists('getMonthsForUploadedFiles')) {
    /**
     * will return year-month list to filter uploaded files
     *
     * @return mixed
     */

    function getMonthsForUploadedFiles()
    {
        $starting_date = DB::table('tl_uploaded_files')
            ->select([
                'created_at as date'
            ])->first();

        $ending_date = DB::table('tl_uploaded_files')
            ->orderBy('id', 'desc')
            ->select([
                'created_at as date'
            ])->first();


        $data = [];

        if ($starting_date != null && $ending_date != null) {
            $result = CarbonPeriod::create($starting_date->date, '1 month', $ending_date->date);
            foreach ($result as $dt) {
                $data[$dt->format("m-Y")] = $dt->format("F-Y");
            }

            $todayDate = Carbon::now();
            $data[$todayDate->format("m-Y")] = $todayDate->format("F-Y");
        }
        return $data;
    }
}

if (!function_exists('getFileDetails')) {
    /**
     * return uploaded file details
     *
     * @param Int $id
     * @return Collection
     */

    function getFileDetails($id)
    {
        return UploadedFile::find($id);
    }
}

if (!function_exists('getFilePath')) {
    /**
     * return uploaded file path
     *
     * @param bool $placeholder
     * @param Int $id
     * @return String
     */

    function getFilePath($id, $placeholder = true, $size = null)
    {

        $file_info = Cache::rememberForever('file-path' . $id, function () use ($id) {
            return UploadedFile::select('path')->find($id);
        });

        if (!$placeholder) {
            $file_path = $file_info != null ? mediaStoragePath() . '/' . $file_info->path : null;
        }

        if ($placeholder) {
            $file_path = $file_info != null ? mediaStoragePath() . '/' . $file_info->path : getPlaceHolderImagePath();
        }

        if ($size != null) {
            $full_path_array = explode('/', $file_path);
            $file_full_name = $full_path_array[sizeof($full_path_array) - 1];
            $file_full_name_array = explode('.', $file_full_name);
            $file_name = $file_full_name_array[0];
            $extension = $file_full_name_array[1];
            $variant_image_name = $file_name . $size . '.' . $extension;
            array_pop($full_path_array);
            $location = implode('/', $full_path_array);
            $variant_image_path = $location . '/' . $variant_image_name;

            if (file_exists(trim($variant_image_path, '/'))) {
                return $variant_image_path;
            }
        }

        return $file_path;
    }
}

if (!function_exists('getPlaceHolderImagePath')) {


    function getPlaceHolderImagePath()
    {
        $placeholder_info = getPlaceHolderImage();
        $placeholder_image = '';
        if ($placeholder_info != null) {
            $placeholder_image = $placeholder_info->placeholder_image;
            return mediaStoragePath() . '/' . $placeholder_image;
        }
        return '/';
    }
}


if (!function_exists('getPlaceHolderImage')) {
    /**
     * will return placeholder image
     *
     * @return mixed
     */

    function getPlaceHolderImage()
    {
        $default = new StdClass;
        $default->placeholder_image = null;
        $default->placeholder_image_alt = null;

        $data = DB::table('tl_general_settings_has_values')
            ->leftJoin('tl_uploaded_files', 'tl_uploaded_files.id', '=', 'tl_general_settings_has_values.value')
            ->where('settings_id', '=', getGeneralSettingId('placeholder_image'))
            ->select(['tl_uploaded_files.path as placeholder_image', 'tl_uploaded_files.alt as placeholder_image_alt'])
            ->first();

        if ($data == null) {
            return $default;
        }

        return $data;
    }
}


if (!function_exists('mediaStoragePath')) {
    /**
     * return file storage base url
     *
     * 
     * @return String
     */

    function mediaStoragePath()
    {
        return '/public';
    }
}


if (!function_exists('getChunkSize')) {
    /**
     * will return chunk size
     *
     * @return mixed
     */

    function getChunkSize()
    {
        $data = DB::table('tl_general_settings_has_values')
            ->where('settings_id', '=', getGeneralSettingId('maximum_chunk_size'))
            ->first('value');

        return $data;
    }
}
