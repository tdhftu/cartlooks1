<?php

namespace Core\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Core\Models\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Core\Http\Requests\MediaRequest;
use Illuminate\Support\Facades\Auth;
use Core\Repositories\MediaRepository;
use Core\Repositories\SettingsRepository;

class MediaController extends Controller
{

    protected $media_repo;
    protected $settings_repository;

    public function __construct(MediaRepository $media_repo, SettingsRepository $settings_repository)
    {
        $this->media_repo = $media_repo;
        $this->settings_repository = $settings_repository;
    }

    /**
     * will redirect to media settings page
     *
     * @return mixed
     */
    public function mediaSettings()
    {
        $data = [
            'tl_general_settings.name',
            'tl_general_settings.id as settings_id',
            'tl_general_settings_has_values.value',
            'tl_uploaded_files.path',
            'tl_uploaded_files.alt',
            'tl_uploaded_files.id as file_id'
        ];

        $media_settings_value = $this->settings_repository->getSettingsData($data);
        $data = [];

        for ($i = 0; $i < sizeof($media_settings_value); $i++) {
            if ($media_settings_value[$i]->settings_id == getGeneralSettingId('placeholder_image')) {
                $data['placeholder_image'] = $media_settings_value[$i]->path;
                $data['placeholder_image_alt'] = $media_settings_value[$i]->alt;
                $data['placeholder_image_id'] = $media_settings_value[$i]->file_id;
            } elseif ($media_settings_value[$i]->settings_id == getGeneralSettingId('watermark_image')) {
                $data['watermark_image'] = $media_settings_value[$i]->path;
                $data['watermark_image_alt'] = $media_settings_value[$i]->alt;
                $data['watermark_image_id'] = $media_settings_value[$i]->file_id;
            } else {
                $data[$media_settings_value[$i]->name] = $media_settings_value[$i]->value;
            }
        }



        return view('core::base.business.media.media_settings', ['data' => $data]);
    }

    /**
     * store media settings
     *
     * @param  mixed $request
     * @return void
     */
    public function storeMediaSettings(MediaRequest $request)
    {
        try {
            DB::beginTransaction();
            $all_request = $request->all();
            $data = [];
            $settings_id = getGeneralSettingIdAsArray('media_settings_name');
            foreach ($all_request as $key => $value) {
                if ($key != 'image_applicable_folder' && $key != '_token') {
                    array_push($data, [
                        'settings_id' => getGeneralSettingId($key),
                        'value' => xss_clean($value)
                    ]);
                }
            }

            DB::table('tl_general_settings_has_values')->whereIn('settings_id', $settings_id)->delete();
            DB::table('tl_general_settings_has_values')->insert($data);

            DB::commit();
            toastNotification('success', 'Media settings updated successfully');
            return redirect()->route('core.media.settings');
        } catch (Exception $ex) {
            DB::rollBack();
            toastNotification('error', 'Unable to update media settings');
            return redirect()->route('core.media.settings');
        }
    }

    /**
     * Redirect to media page 
     */
    public function mediaPage()
    {
        return view('core::base.media.index');
    }

    /**
     * upload media file
     *
     * @param  mixed $request
     * @return void
     */
    public function uploadMediaFile(Request $request)
    {
        try {
            foreach ($request->file('file') as $file) {

                $file_id = saveFileInStorage($file);
            }

            $total = DB::table('tl_uploaded_files')->count();

            return [
                'success' => true,
                'file_id' => $file_id,
                'is_complete' => true,
                'total' => $total,
                'message' => translate("Media file uploaded successful")
            ];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => translate("Unable to update media file")
            ], 500);
        }
    }
    /**
     * update media file info
     *
     * @param  mixed $request
     * @return void
     */
    public function updateMediaFileInfo(Request $request)
    {
        try {
            $file = UploadedFile::find($request['media_id']);
            $file->title       = xss_clean($request['title']);
            $file->caption     = xss_clean($request['caption']);
            $file->alt         = xss_clean($request['alt']);
            $file->description = xss_clean($request['description']);
            $file->update();

            return response()->json([
                'success' => true,
                'message' => translate("Media information updated successful")
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate("Unable to media information")
            ], 500);
        }
    }

    /**
     * Filter media list
     */
    public function filterMediaList(Request $request)
    {
        try {
            $selected_file_type = $request['file_type'];
            $search_input = $request['search_input'];
            $search_date = $request['search_date'];
            $filter_by_user = $request['filter_by_user'];

            $match_case = [];

            if ($selected_file_type != null && $selected_file_type != '' && $selected_file_type != 'all') {
                array_push($match_case, [
                    'tl_uploaded_files.file_type', '=', $selected_file_type
                ]);
            }

            if ($search_date != null && $search_date != '' && $search_date != 'all') {
                $search_date_splitted = explode('-', $request['search_date']);
                $starting_date = $search_date_splitted[1] . '-' . $search_date_splitted[0] . '-' . '01' . " 00:00:00";
                $ending_date = $search_date_splitted[1] . '-' . $search_date_splitted[0] . '-' . '31' . " 00:00:00";

                array_push($match_case, [
                    'tl_uploaded_files.created_at', '>=', $starting_date
                ]);
                array_push($match_case, [
                    'tl_uploaded_files.created_at', '<=', $ending_date
                ]);
            }

            if ($filter_by_user === 'true') {
                array_push($match_case, [
                    'tl_uploaded_files.user_id', '=', Auth::user()->id
                ]);
            }

            $all_media = $this->media_repo->getMediaList($match_case, $request['selected_media_files'], $search_input, true);

            $media_ids = [];

            foreach ($all_media as $media) {
                array_push($media_ids, $media->id);
            }

            return response()->json([
                'view' => view('core::base.media.partial.media_library', compact('all_media', 'selected_file_type', 'search_input', 'search_date', 'media_ids'))->render(),
                'all_media' => $all_media
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate("Media Loading Failed")
            ], 500);
        }
    }

    /**
     * Delete media file
     */
    public function deleteMediaFile(Request $request)
    {
        try {
            $ids = $request['id'];
            for ($i = 0; $i < sizeof($ids); $i++) {
                removeMediaById((int)$ids[$i]);
            }
            return response()->json([
                'success' => true,
                'message' => translate('File deleted successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => translate("Unable to delete file")
            ], 500);
        }
    }

    /**
     * get media details by file id
     */
    public function getMediaDetailsById(Request $request)
    {
        try {
            $all_media = DB::table('tl_uploaded_files')
                ->whereIn('id', explode(',', $request['media_id']))
                ->select([
                    'tl_uploaded_files.id',
                    'tl_uploaded_files.name',
                    'tl_uploaded_files.title',
                    'tl_uploaded_files.alt',
                    'tl_uploaded_files.caption',
                    'tl_uploaded_files.description',
                    'tl_uploaded_files.path',
                    'tl_uploaded_files.size',
                    'tl_uploaded_files.file_type',
                    'tl_uploaded_files.extension',
                    'tl_uploaded_files.folder_name',
                    'tl_uploaded_files.uploaded_by',
                    'tl_uploaded_files.created_at',
                    'tl_uploaded_files.updated_at'
                ]);

            $all_media =  $all_media
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'all_media' => $all_media
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false
            ], 500);
        }
    }
}
