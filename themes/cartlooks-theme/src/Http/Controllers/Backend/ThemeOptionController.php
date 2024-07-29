<?php

namespace Theme\CartLooksTheme\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Expr\Cast\Object_;
use Theme\CartLooksTheme\Repositories\ThemeOptionRepository;

class ThemeOptionController extends Controller
{

    protected $themeOption_repository;

    public function __construct(ThemeOptionRepository $themeOption_repository)
    {
        $this->themeOption_repository = $themeOption_repository;
    }

    /**
     ** Theme Options Page
     * @return View
     */
    public function themeOptions()
    {
        try {
            return view('theme/cartlooks-theme::backend.theme.options');
        } catch (\Exception $e) {
            toastNotification('error', translate('Theme Option Page Failed'));
            return redirect()->back();
        }
    }

    /**
     ** Get Theme Option Form
     * @param object $request
     * @return Response
     */
    public function getOptionForm(Request $request)
    {
        try {
            $active_theme = getActiveTheme();
            $option_name = $request->id;
            $option_settings = getThemeOption($option_name, $active_theme->id);
            $form = view('theme/cartlooks-theme::backend.theme.option-form.' . $option_name, compact('option_settings'))->render();
            return response()->json(['form' => $form]);
        } catch (\Exception $e) {
            return response()->json(['error' => translate('Theme Option Getting Failed')]);
        }
    }

    /**
     ** Save Theme Option Form
     * @param object $request
     * @return Response
     */
    public function saveOptionForm(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->submitType == 'reset_all' || $request->submitType == 'reset_section') {
                $this->themeOption_repository->resetThemeOption($request);
            } else {
                if ($request->option_name == 'social') {
                    $this->themeOption_repository->saveSocialLink($request);
                    $this->themeOption_repository->saveThemeOption($request);
                } elseif ($request->option_name == 'custom_fonts') {
                    $this->themeOption_repository->saveCustomFont($request);
                } else {
                    $this->themeOption_repository->saveThemeOption($request);
                }
            }

            DB::commit();
            toastNotification('success', translate('Theme Option Saved'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Theme Option Saving Failed'));
            return redirect()->back();
        }
    }
}
