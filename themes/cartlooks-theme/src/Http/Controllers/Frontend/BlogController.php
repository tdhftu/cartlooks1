<?php

namespace Theme\CartLooksTheme\Http\Controllers\Frontend;

use Exception;
use Core\Models\TlBlog;
use Core\Models\TlBlogTag;
use Illuminate\Http\Request;
use Core\Models\TlBlogCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Theme\CartLooksTheme\Repositories\BlogRepository;

class BlogController extends Controller
{
    protected $blog_repository;
    protected $menus = [];
    /**
     ** Initializing Blog Repository
     */
    public function __construct(BlogRepository $blog_repository)
    {
        $this->blog_repository = $blog_repository;
    }

    /**
     * Will redirect to single blog details page
     */
    public function getSingleBlogDetails($slug)
    {
        $data = [
            DB::raw('GROUP_CONCAT(distinct tl_blogs.id) as id'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.name) as name'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.meta_title) as meta_title'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.meta_description) as meta_description'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.meta_image) as meta_image')
        ];

        try {
            $match_case = [
                ['tl_blogs.permalink', '=', $slug],
            ];
            $blog_details = $this->blog_repository->getBlogs($data, $match_case)->first();

            if ($blog_details != null) {
                if ($blog_details->meta_image != null) {
                    $blog_details->meta_image = getFilePath($blog_details->meta_image, true);
                }
            }


            return view('theme/cartlooks-theme::frontend.pages.blog-details')->with(
                [
                    'blog_details' => $blog_details
                ]
            );
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     ** Show all the blogs
     *
     * @return View
     */
    public function blogs(Request $request)
    {
        try {
            $category = null;
            $tag = null;

            $category_title = null;
            $tag_title = null;

            $condition = [];
            if (isset($request['category']) && $request['category'] != "") {
                $category = $request['category'];
                $category_title = DB::table('tl_blog_categories')
                    ->where('permalink', '=', $request['category'])
                    ->first()->name;

                $condition = array_merge($condition, ['tl_blog_categories.permalink', '=', $request['category']]);
            }
            if (isset($request['tag']) && $request['tag'] != "") {
                $tag = $request['tag'];
                $tag_title = DB::table('tl_blog_tags')
                    ->where('permalink', '=', $request['tag'])
                    ->first()->name;
                $condition = array_merge($condition, ['tl_blog_tags.permalink', '=', $request['tag']]);
            }

            if ($category != null || $tag != null) {
                $blogs = $this->blogFilter($condition);
            } else {
                $blogs = $this->blogFilter(null, '', true);
            }


            foreach ($blogs as $blog) {
                if ($blog->image != null) {
                    $blog->image = getFilePath($blog->image, true);
                }
                $blog->title = $blog->translation('name', Session::get('api_locale'));
            }

            return response()->json(
                [
                    'success' => true,
                    'category_title' => $category_title,
                    'tag_title' => $tag_title,
                    'blogs' => $blogs,
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
     * Will return related blog information
     */
    public function getRelatedBlogs(Request $request)
    {
        try {
            $slug = $request["slug"];
            $blog_categories = DB::table('tl_blogs')
                ->join('tl_blogs_categories', 'tl_blogs_categories.blog_id', '=', 'tl_blogs.id')
                ->where('tl_blogs.permalink', '=', $slug)
                ->pluck('tl_blogs_categories.category_id');

            $blog_tags = DB::table('tl_blogs')
                ->join('tl_blogs_tags', 'tl_blogs_tags.blog_id', '=', 'tl_blogs.id')
                ->where('tl_blogs.permalink', '=', $slug)
                ->pluck('tl_blogs_tags.tag_id');

            $blogs = TlBlog::leftJoin('tl_blogs_tags', 'tl_blogs_tags.blog_id', '=', 'tl_blogs.id')
                ->leftJoin('tl_blogs_categories', 'tl_blogs_categories.blog_id', '=', 'tl_blogs.id')
                ->where('tl_blogs.permalink', '!=', $slug)
                ->where(function ($query) use ($blog_categories, $blog_tags) {
                    $query->whereIn('tl_blogs_categories.category_id', $blog_categories->toArray())
                        ->orWhereIn('tl_blogs_tags.tag_id', $blog_tags->toArray());
                })
                ->select([
                    DB::raw('tl_blogs.id'),
                    DB::raw('tl_blogs.name'),
                    DB::raw('tl_blogs.image as image'),
                    DB::raw('tl_blogs.publish_at as date'),
                    DB::raw('tl_blogs.permalink as permalink'),
                ])->take(3)->get();

            foreach ($blogs as $blog) {
                if ($blog->image != null) {
                    $blog->image = getFilePath($blog->image, true);
                }
                $blog->title = $blog->translation('name', Session::get('api_locale'));
            }

            return response()->json(
                [
                    'success' => true,
                    'blogs' => $blogs,
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
     ** Show all the blog matching text
     * @return View
     */
    public function blogBySearch(Request $request)
    {
        try {
            $category = null;
            $tag = null;
            $text = '';
            $condition = [];
            if (isset($request['category']) && $request['category'] != "") {
                $category = $request['category'];
                $condition = array_merge($condition, ['tl_blog_categories.permalink', '=', $request['category']]);
            }
            if (isset($request['tag']) && $request['tag'] != "") {
                $tag = $request['tag'];
                $condition = array_merge($condition, ['tl_blog_tags.permalink', '=', $request['tag']]);
            }
            if (isset($request['search']) && $request['search'] != "") {
                $text = $request['search'];
            }

            if ($category != null || $tag != null) {
                $blogs = $this->blogFilter($condition, $text);
            } else {
                $blogs = $this->blogFilter(null, $text);
            }

            foreach ($blogs as $blog) {
                if ($blog->image != null) {
                    $blog->image = getFilePath($blog->image, true);
                }
                $blog->title = $blog->translation('name', Session::get('api_locale'));
            }

            return response()->json(
                [
                    'success' => true,
                    'blogs' => $blogs,
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
     ** Blogs Filter By Different Condition
     * @param $condition
     * @return View
     */
    public function blogFilter($condition = null, $search = '', $sticky = false)
    {
        $active_theme = getActiveTheme();
        $blog = getThemeOption('blog', $active_theme->id);
        $paginate = 9;
        if (isset($blog['custom_blog']) && $blog['custom_blog'] == 1 && isset($blog['blog_perpage']) && !empty($blog['blog_perpage']) && $blog['blog_perpage'] != 0) {
            $paginate = $blog['blog_perpage'];
        }
        $data = [
            DB::raw('GROUP_CONCAT(distinct tl_blogs.id) as id'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.name) as title'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.image) as image'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.publish_at) as date'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.name) as name'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.permalink) as permalink'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.visibility) as visibility'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.publish_at) as publish_at'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.short_description) as short_description'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.reading_time) as reading_time'),
            DB::raw('GROUP_CONCAT(distinct tl_users.id) as user_id'),
            DB::raw('GROUP_CONCAT(distinct tl_users.name) as user_name'),
            DB::raw('GROUP_CONCAT(distinct tl_users.image) as user_image'),
            DB::raw('GROUP_CONCAT(distinct tl_blog_categories.id) as category'),
        ];

        $match_case = [
            ['tl_blogs.publish_at', '<', currentDateTime()],
            ['tl_blogs.is_publish', '=', config('settings.blog_status.publish')],
        ];
        if (isset($condition)) {
            array_push($match_case, $condition);
        }
        return $this->blog_repository->getBlogs($data, $match_case, null, $paginate, $search, $sticky);
    }

    /**
     ** Show the Blog Details page
     * @return View
     */
    public function blog_details($slug)
    {
        $data = [
            DB::raw('GROUP_CONCAT(distinct tl_blogs.id) as id'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.name) as name'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.permalink) as permalink'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.publish_at) as publish_at'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.short_description) as short_description'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.reading_time) as reading_time'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.visibility) as visibility'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.content) as content'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.image) as image'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.is_featured) as is_featured'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.is_publish) as is_publish'),
            DB::raw('GROUP_CONCAT(distinct tl_users.id) as user_id'),
            DB::raw('GROUP_CONCAT(distinct tl_users.name) as user_name'),
            DB::raw('GROUP_CONCAT(distinct tl_users.image) as user_image'),
            DB::raw('GROUP_CONCAT(distinct tl_blog_categories.id) as category'),
            DB::raw('GROUP_CONCAT(distinct tl_blog_tags.id) as tag'),
        ];

        try {
            $match_case = [
                ['tl_blogs.publish_at', '<', currentDateTime()],
                ['tl_blogs.is_publish', '=',  config('settings.blog_status.publish')],
                ['tl_blogs.permalink', '=', $slug],
            ];
            $blog = $this->blog_repository->getBlogs($data, $match_case)->first();

            if ($blog != null) {
                $blog->name = $blog->translation('name', Session::get('api_locale'));
                $blog->short_description = $blog->translation('short_description', Session::get('api_locale'));
                $blog->content = TlBlog::find($blog->id)->content;
                $blog->content = $blog->translation('content', Session::get('api_locale'));

                if ($blog->image != null) {
                    $blog->image = getFilePath($blog->image, true);
                }

                if ($blog->category != null) {
                    $blog->category_list = TlBlogCategory::whereIn('id', explode(',', $blog->category))->select(['id', 'name', 'permalink'])->get()->map(function ($item, $key) {
                        return [
                            'id' => $item->id,
                            'name' => $item->translation('name', Session::get('api_locale')),
                            'permalink' => $item->permalink
                        ];
                    });
                }

                if ($blog->tag != null) {
                    $blog->tag_list = TlBlogTag::whereIn('id', explode(',', $blog->tag))->select(['id', 'name', 'permalink'])->get()->map(function ($item, $key) {
                        return [
                            'id' => $item->id,
                            'name' => $item->translation('name', Session::get('api_locale')),
                            'permalink' => $item->permalink
                        ];
                    });
                }
            }

            return response()->json(
                [
                    'success' => true,
                    'blog' => $blog,
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
     * Preview Blog
     */
    public function previewBlog($slug)
    {
        $data = [
            DB::raw('GROUP_CONCAT(distinct tl_blogs.id) as id'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.name) as name'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.permalink) as permalink'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.publish_at) as publish_at'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.short_description) as short_description'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.reading_time) as reading_time'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.visibility) as visibility'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.content) as content'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.image) as image'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.is_featured) as is_featured'),
            DB::raw('GROUP_CONCAT(distinct tl_blogs.is_publish) as is_publish'),
            DB::raw('GROUP_CONCAT(distinct tl_users.id) as user_id'),
            DB::raw('GROUP_CONCAT(distinct tl_users.name) as user_name'),
            DB::raw('GROUP_CONCAT(distinct tl_users.image) as user_image'),
            DB::raw('GROUP_CONCAT(distinct tl_blog_categories.id) as category'),
            DB::raw('GROUP_CONCAT(distinct tl_blog_tags.id) as tag'),
        ];

        try {
            $match_case = [
                ['tl_blogs.permalink', '=', $slug],
            ];
            $blog = $this->blog_repository->getBlogs($data, $match_case)->first();

            if ($blog != null) {
                $blog->name = $blog->translation('name', Session::get('api_locale'));
                $blog->short_description = $blog->translation('short_description', Session::get('api_locale'));
                $blog->content = $blog->translation('content', Session::get('api_locale'));

                if ($blog->image != null) {
                    $blog->image = getFilePath($blog->image, true);
                }

                if ($blog->category != null) {
                    $blog->category_list = TlBlogCategory::whereIn('id', explode(',', $blog->category))->select(['id', 'name', 'permalink'])->get();
                }

                if ($blog->tag != null) {
                    $blog->tag_list = TlBlogTag::whereIn('id', explode(',', $blog->tag))->select(['id', 'name', 'permalink'])->get();
                }
            }


            return response()->json(
                [
                    'success' => true,
                    'blog' => $blog,
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
     ** Load Comment for a blog
     *
     * @param Request $request via AJAX
     * @return \Illuminate\Http\Response json
     */
    public function loadBlogComment(Request $request)
    {
        try {
            $blog = $this->blog_repository->findBlog($request->permalink);
            $blog_comment_details = $this->blog_repository->getBlogComment($request->permalink);
            $blog_comments = $blog_comment_details['blog_comments'];
            $paginate = $blog_comment_details['paginate'];

            $should_auto_close_comment = commentClose($blog->publish_at);
            $comment_settings = commentFormSettings();

            $comment_settings['should_auto_close_comment'] = true;
            if (isset($comment_settings['close_comments_for_old_blogs']) && $comment_settings['close_comments_for_old_blogs'] == 1 && $should_auto_close_comment) {
                $comment_settings['should_auto_close_comment'] = false;
            }

            $view = view('theme/cartlooks-theme::frontend.blog.includes.blog_comment', compact('blog_comments', 'blog'))->render();
            return response()->json([
                'success' => true,
                'view' => $view,
                'lastPage' => isset($paginate) ? $blog_comments->lastPage() : 1,
                'currentPage' => isset($paginate) ? $blog_comments->currentPage() : 1,
                'isAdminLoggedIn' => Auth::check(),
                'commentSettings' => $comment_settings
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => translate('Comment Loading Failed')]);
        }
    }

    /**
     ** Create Blog Comment
     *
     * @param Request $request via AJAX
     * @return \Illuminate\Http\Response json
     */
    public function createBlogComment(Request $request)
    {
        try {
            $comment_setting = commentFormSettings();
            $rules = [
                'comment' => 'required'
            ];
            if (!Auth::check() && !$request->customerId) {
                if ($comment_setting['require_name_email'] == '1') {
                    $rules['user_name'] = 'required|max:50';
                    $rules['user_email'] = 'required|email';
                } else {
                    $rules['user_name'] = 'nullable|max:50';
                    $rules['user_email'] = 'nullable|email';
                }
            }
            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                DB::beginTransaction();
                $comment = $this->blog_repository->createBlogComment($request);
                $commentFiltrationResult = $this->blog_repository->commentFiltration($comment);
                DB::commit();
                return response()->json($commentFiltrationResult);
            }
            $validationMessages = [];
            foreach ($validator->errors()->messages() as $key => $value) {
                $validationMessages[$key] = $value[0];
            }

            return response()->json([
                'success' => false,
                'is_validation_error' => true,
                'error' => $validationMessages
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'is_validation_error' => false,
                'error' => translate('Comment Added Failed')
            ]);
        }
    }
}
