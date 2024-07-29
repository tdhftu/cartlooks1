<?php

namespace Core\Http\Controllers;

use ZipArchive;
use Core\Models\Plugin;
use Core\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
    /**
     * Will extract update.zip file and update system
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function extractUpdateFile(Request $request)
    {
        $request->validate(
            [
                'update_file' => 'required|mimes:zip',
            ]
        );
        try {

            $temp_storage_path = storage_path('app/tempUpdate');
            if ($request->hasFile('update_file')) {
                $zip = new ZipArchive;
                $res = $zip->open($request->file("update_file")->getRealPath());
                if ($res === true) {
                    $zip->extractTo($temp_storage_path);
                    $zip->close();
                } else {
                    abort(500, 'Error! Could not open File');
                }

                return $this->processUpdate($temp_storage_path, $temp_storage_path);
            } else {
                toastNotification('error', 'Update zip file missing', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            cache_clear();
            $this->delete_directory($temp_storage_path);
            toastNotification('error', 'Something went wrong', 'Error');
            return redirect()->back();
        } catch (\Error $e) {
            cache_clear();
            $this->delete_directory($temp_storage_path);
            toastNotification('error', 'Something went wrong', 'Error');
            return redirect()->back();
        }
    }
    /**
     * Will update system
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function updateSystem(Request $request)
    {
        $root_path = base_path();
        $rm_dir = base_path('updates');
        $redirect_route = "admin.dashboard";
        return $this->processUpdate($root_path, $rm_dir, $redirect_route);
    }

    /**
     * Will completed updated process
     * 
     */
    public function processUpdate($root_path, $rm_dir, $redirect_route = null)
    {
        try {
            cache_clear();
            $config_file = @file_get_contents($root_path . '/updates/config.json', true);
            if ($config_file === false) {
                abort(500, 'The update file is corrupt.');
            }
            $json = json_decode($config_file, true);

            if (!empty($json)) {

                //check item type
                if (empty($json['type'])) {
                    toastNotification('error', 'Mission config file', 'Error');
                    return redirect()->back();
                }

                //check item
                if (empty($json['item'])) {
                    toastNotification('error', 'Mission config file', 'Error');
                    return redirect()->back();
                }

                if (!empty($json['item']) && !$this->checkItem($json['type'], $json['item'])) {
                    toastNotification('error', 'Invalid update file', 'Error');
                    return redirect()->back();
                }

                //check version
                if (empty($json['version'])) {
                    toastNotification('error', 'Mission config file', 'Error');
                    return redirect()->back();
                }
                //compare version compatibility
                if (!empty($json['version']) && $this->getCurrentVersion($json['type'], $json['item']) == $json['version']) {
                    toastNotification('error', 'Already install this version');
                    return redirect()->back();
                }

                //check min version
                if (empty($json['min'])) {
                    toastNotification('error', 'Mission config file', 'Error');
                    return redirect()->back();
                }
                //compare min version compatibility
                if (!empty($json['min']) && $this->getCurrentVersion($json['type'], $json['item']) != $json['min']) {
                    toastNotification('error', 'Minimum required version ' . $json['min'], 'Error');
                    return redirect()->back();
                }
            } else {
                toastNotification('error', 'Mission config file', 'Error');
                return redirect()->back();
            }
            //Apply changes files and folder
            if (isset($json['changes']) && !empty($json['changes'])) {
                $change_files = $json['changes'];
                foreach ($change_files as $file) {
                    //Src path
                    $src_path = $root_path . '/' . $file['src'];
                    //Destination path
                    $destination_path = base_path($file['des']);

                    if (File::isDirectory($src_path)) {
                        File::moveDirectory($src_path, $destination_path);
                    } else {
                        File::copy($src_path, $destination_path);
                    }
                }
            }

            //Run sql
            if (isset($json['sql']) && !empty($json['sql'])) {
                $sql_files = $json['sql'];
                foreach ($sql_files as $sql) {
                    $sql_path = $root_path . '/' . $sql['path'];;
                    if (file_exists($sql_path)) {
                        DB::unprepared(file_get_contents($sql_path));
                    }
                }
            }

            //Update core system version
            if ($json['type'] == 'core') {
                $this->updateCoreSystemVersion($json['version']);

                if (isset($json['includes']) && !empty($json['includes'])) {
                    $include_items = $json['includes'];
                    foreach ($include_items as $item) {
                        if ($item['type'] == 'theme') {
                            $this->updateThemeVersion($item['slug'], $item['version']);
                        }
                        //Update plugin version
                        if ($item['type'] == 'plugin') {
                            $this->updatePluginVersion($item['slug'], $item['version']);
                        }
                    }
                }
            }
            //Update theme version
            if ($json['type'] == 'theme') {
                $this->updateThemeVersion($json['item'], $json['version']);
            }
            //Update plugin version
            if ($json['type'] == 'plugin') {
                $this->updatePluginVersion($json['item'], $json['version']);
            }

            //Remove removable
            if (isset($json['removable']) && !empty($json['removable'])) {
                $removable_files = $json['removable'];
                foreach ($removable_files as $file) {
                    $path = base_path($file['real_path']);
                    if (File::isDirectory($path)) {
                        File::deleteDirectory($path);
                    } else {
                        if (file_exists($path)) {
                            File::delete($path);
                        }
                    }
                }
            }

            $this->delete_directory($rm_dir);
            cache_clear();
            toastNotification('success', 'Successfully updated', 'Success');
            if ($redirect_route != null) {
                return to_route($redirect_route);
            }
            return to_route('core.system.update.page');
        } catch (\Exception $e) {
            cache_clear();
            toastNotification('error', 'Something went wrong', 'Error');
            return redirect()->back();
        } catch (\Error $e) {
            cache_clear();
            toastNotification('error', 'Something went wrong', 'Error');
            return redirect()->back();
        }
    }

    /**
     * Will cancel update
     */
    public function cancelUpdate()
    {
        $dir = base_path('updates');
        $res = $this->delete_directory($dir);
        if ($res) {
            toastNotification('success', 'Update cancel successfully');
            return to_route('admin.dashboard');
        } else {
            toastNotification('success', 'Update cancel failed');
            return redirect()->back();
        }
    }
    /**
     * Delete a folder
     */
    public function delete_directory($dirname)
    {
        try {
            if (File::deleteDirectory($dirname)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        } catch (Error $e) {
            return false;
        }
    }

    /**
     * Delete a file
     */
    public function delete_file($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
            return true;
        }
        return false;
    }
    /**
     * Will return system, theme  and plugin version
     */
    public function getCurrentVersion($type, $name = null)
    {
        if ($type == 'core') {
            return getGeneralSetting('system_version');
        }

        if ($type == 'theme') {
            $theme = Themes::where('location', $name)->first();
            if ($theme != null) {
                return $theme->version;
            }
            return null;
        }

        if ($type == 'plugin') {
            $plugin = Plugin::where('location', $name)->first();
            if ($plugin != null) {
                return $plugin->version;
            }
            return null;
        }
    }

    /**
     * Will check item
     */
    public function checkItem($type, $item = null)
    {
        if ($type == 'core') {
            if ($item != config('themelooks.item')) {
                return false;
            }
            return true;
        }

        if ($type == 'theme') {
            $theme = Themes::where('location', $item)->first();
            if ($theme != null) {
                return true;
            }
            return false;
        }

        if ($type == 'plugin') {
            $plugin = Plugin::where('location', $item)->first();
            if ($plugin != null) {
                return true;
            }
            return false;
        }
    }
    /**
     * Will update core system version
     * 
     * @param Mixed $updated_version
     * @return bool
     */
    public function updateCoreSystemVersion($updated_version)
    {
        try {
            DB::beginTransaction();
            $version_setting_id = getGeneralSettingId('system_version');
            $version_data = [
                'settings_id' => $version_setting_id,
                'value' => $updated_version
            ];
            //Delete Exiting Version
            DB::table('tl_general_settings_has_values')
                ->where('settings_id', $version_setting_id)
                ->delete();

            //Store new Version
            DB::table('tl_general_settings_has_values')
                ->where('settings_id', $version_setting_id)
                ->insert($version_data);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }
    /**
     * Will updated plugin version
     * 
     * @param String $plugin_name
     * @param mixed $updated_version
     * @return bool
     */
    public function updatePluginVersion($plugin_name, $updated_version)
    {
        try {
            DB::beginTransaction();
            Plugin::where('location', $plugin_name)->update(
                [
                    'version' => $updated_version,
                ]
            );
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Will updated theme versions
     * 
     * @param String $theme_name
     * @param mixed $updated_version
     * @return bool
     */
    public function updateThemeVersion($theme_name, $updated_version)
    {
        try {
            DB::beginTransaction();
            Themes::where('location', $theme_name)->update(
                [
                    'version' => $updated_version,
                ]
            );

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }
}
