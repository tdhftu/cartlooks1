<?php

namespace Theme\CartLooksTheme\Http\Controllers\Frontend;

use Core\Models\TlPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Theme\CartLooksTheme\Repositories\PageRepository;

class PagesController extends Controller
{
    protected $page_repository;
    public function __construct(PageRepository $page_repository)
    {
        $this->page_repository = $page_repository;
    }

    /**
     * customer login
     */
    public function customerLogin()
    {
        return view('theme/cartlooks-theme::frontend.pages.customer-login');
    }

    /**
     * Customer registration
     */
    public function customerRegistration()
    {
        return view('theme/cartlooks-theme::frontend.pages.customer-registration');
    }
    /**
     * seller registration
     */
    public function sellerRegistration()
    {
        if (!isActivePlugin('multivendor-cartlooks')) {
            abort(404);
        }
        return view('theme/cartlooks-theme::frontend.pages.seller-registration');
    }

    /**
     * Will return all shop page
     * 
     */
    public function allShop()
    {
        if (!isActivePlugin('multivendor-cartlooks')) {
            abort(404);
        }
        return view('theme/cartlooks-theme::frontend.pages.home');
    }
    /**
     * Will return seller details page
     * 
     * @param String $slug
     * @return  mixed
     */
    public function shopPage($slug)
    {
        if (!isActivePlugin('multivendor-cartlooks')) {
            abort(404);
        }
        $shopDetails = \Plugin\Multivendor\Models\SellerShop::where('shop_slug', $slug)->first();
        return view('theme/cartlooks-theme::frontend.pages.shop', ['shopDetails' => $shopDetails]);
    }
    /**
     * Will redirect to single page details page 
     */
    public function getSinglePageDetails(Request $request)
    {
        try {
            $request_path = $request->path();
            $request_path_array = explode('/', $request_path);
            $permalink = end($request_path_array);

            $data = [
                DB::raw('GROUP_CONCAT(distinct tl_pages.id) as id'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.title) as title'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.permalink) as permalink'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.page_type) as page_type'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.is_home) as is_home'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.meta_title) as meta_title'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.meta_description) as meta_description'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.meta_image) as meta_image'),
            ];
            $match_case = [
                ['tl_pages.permalink', '=', $permalink],
            ];
            $page_details = $this->page_repository->getPages($data, $match_case)->first();

            if ($page_details != null) {
                if ($page_details->meta_image != null) {
                    $page_details->meta_image = getFilePath($page_details->meta_image, true);
                }
            }

            return view('theme/cartlooks-theme::frontend.pages.page-details')->with(
                [
                    'page_details' => $page_details
                ]
            );
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     ** Show the Details page in frontend
     ** click on the permalink and sent to the frontend if published
     * @return View
     */
    public function pageDetails(Request $request)
    {

        try {
            $request_path = $request->path();
            $request_path_array = explode('/', $request_path);
            $permalink = end($request_path_array);

            $data = [
                DB::raw('GROUP_CONCAT(distinct tl_pages.id) as id'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.title) as title'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.permalink) as permalink'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.parent) as parent'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.visibility) as visibility'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.content) as content'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.page_template) as page_template'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.page_image) as page_image'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.page_type) as page_type'),
            ];
            $match_case = [
                ['tl_pages.publish_at', '<', currentDateTime()],
                ['tl_pages.publish_status', '=',  config('settings.page_status.publish')],
                ['tl_pages.permalink', '=', $permalink],
            ];
            $page = $this->page_repository->getPages($data, $match_case)->first();

            $parentUrl = getParentUrl($page);
            $parents = preg_split('#/#', $parentUrl, -1, PREG_SPLIT_NO_EMPTY);

            $breadCrumbs = [
                [
                    'text' => 'Home',
                    'href' => '/'
                ]
            ];

            for ($i = 0; $i < count($parents); $i++) {
                $parent = TlPage::where('permalink', $parents[$i])->first();
                array_push($breadCrumbs, [
                    'text' => $parent->translation('title', getLocale()),
                    'href' => "/page/" . getParentUrl($parent) . $parent->permalink
                ]);
            }

            array_push($breadCrumbs, [
                'text' => $page->title,
                'active' => true
            ]);

            if (isset($page->page_image)) {
                $page->page_image = getFilePath($page->page_image, true);
            }
            $page->title = $page->translation('title', Session::get('api_locale'));

            $page->content = TlPage::where('permalink', $page->permalink)->first()->translation('content', Session::get('api_locale'));

            $page_sections = '';
            $active_pagebuilder = false;
            $page_builder_widgets = '';
            if (isActivePlugin('pagebuilder-cartlooks') &&  $page->page_type == 'builder') {
                $page_sections = \Plugin\TlPageBuilder\Helpers\BuilderHelper::getSectionLayoutWidgets($page->id, Session::get('api_locale'));
                $active_pagebuilder = true;
                $page_builder_widgets = \Plugin\TlPageBuilder\Helpers\BuilderHelper::$widget_list;
            }

            return response()->json(
                [
                    'success' => true,
                    'page' => $page,
                    'breadCrumbs' => $breadCrumbs,
                    'page_sections' => $page_sections,
                    'active_pagebuilder' => $active_pagebuilder,
                    'page_builder_widgets' => $page_builder_widgets
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
     * Preview Page
     */
    public function previewPage($slug)
    {
        try {
            $page = $this->page_repository->findPage($slug);
            if (isset($page->page_image)) {
                $page->page_image = getFilePath($page->page_image, true);
            }
            $page->title = $page->translation('title', Session::get('api_locale'));
            $page->content = $page->translation('content', Session::get('api_locale'));

            $page_sections = '';
            $active_pagebuilder = false;
            $page_builder_widgets = '';
            if (isActivePlugin('pagebuilder-cartlooks') &&  $page->page_type == 'builder') {
                $page_sections = \Plugin\TlPageBuilder\Helpers\BuilderHelper::getSectionLayoutWidgets($page->id, Session::get('api_locale'));
                $active_pagebuilder = true;
                $page_builder_widgets = \Plugin\TlPageBuilder\Helpers\BuilderHelper::$widget_list;
            }

            return response()->json(
                [
                    'success' => true,
                    'page' => $page,
                    'page_sections' => $page_sections,
                    'active_pagebuilder' => $active_pagebuilder,
                    'page_builder_widgets' => $page_builder_widgets
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
