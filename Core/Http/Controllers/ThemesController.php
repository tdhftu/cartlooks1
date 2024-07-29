<?php

namespace Core\Http\Controllers;

use Core\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ThemesController extends Controller
{

    /**
     * Get theme list
     * 
     * @return mixed
     */
    public function index()
    {
        $themes = Themes::all();
        return view('core::base.themes.index', compact('themes'));
    }
    /**
     * Active theme
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function activate(Request $request)
    {
        try {
            DB::beginTransaction();
            $theme = Themes::findOrFail($request->id);
            $theme->is_activated = config('settings.general_status.active');
            $theme->update();
            DB::table('tl_themes')
                ->whereNotIn('id', [$request->id])
                ->update([
                    'is_activated' => config('settings.general_status.in_active')
                ]);
            DB::commit();
            $this->resetThemeCache();
            toastNotification('success', translate('Theme activate successfully'), 'Success');
            return redirect()->route('core.themes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Theme activation failed'), 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Will reset theme cache
     * 
     * @return void
     */
    public function resetThemeCache()
    {
        cache()->forget('themes');
        Cache::remember("themes", 100 * 60, function () {
            return Themes::all();
        });
    }
}
