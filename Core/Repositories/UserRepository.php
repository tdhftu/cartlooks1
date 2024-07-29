<?php

namespace Core\Repositories;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UserRepository
{

    public function getUserProfileInfo($data, $match_case = [])
    {
        $data = DB::table('tl_users')
            ->leftJoin('tl_uploaded_files', 'tl_uploaded_files.id', '=', 'tl_users.image')
            ->where($match_case)
            ->select($data);
        return $data;
    }

    /**
     * get all roles
     *
     * @return mixed
     */
    public function getAllRoleForAssign()
    {
        return DB::table('roles')
            ->where('id', '!=', 1)
            ->select(['*'])->get();
    }

    /**
     * Will return  all permissions
     *
     * @return mixed
     */
    public function getAllPermissions()
    {
        return Permission::all();
    }

    /**
     * get last permission id
     *
     * @return int
     */
    public function getLastPermissionId()
    {
        return Permission::latest()->first()->id;
    }
    /**
     * get all permission module
     *
     * @return mixed
     */
    public function getPermissionsModules()
    {
        $active_theme = getActiveTheme();
        $modules = DB::table('permission_module')
            ->orderBy('permission_module.order')
            ->select([
                'id', 'module_name', 'parent_module', 'module_type', 'location'
            ])->get();

        $modules =  array_filter($modules->toArray(), function ($item) use ($active_theme) {
            if ($item->module_type == 'theme') {
                $theme_location =  $item->location;
                $theme = DB::table('tl_themes')->where('location', '=', $theme_location);
                if ($theme->exists()) {
                    return $theme->first()->id == $active_theme->id ? true : false;
                } else {
                    return false;
                }
            } else if ($item->module_type == 'plugin') {
                return isActivePlugin($item->location);
            } else {
                return true;
            }
        });

        return array_values($modules);
    }
}
