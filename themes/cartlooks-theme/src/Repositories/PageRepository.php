<?php

namespace Theme\CartLooksTheme\Repositories;

use Core\Models\TlPage;
use Illuminate\Support\Facades\DB;

class PageRepository
{
    /**
     * Get page List by different conditions.
     * 
     * @param array $data select from
     * @param array $match_case where condition
     * @param integer $paginate_page paginate number
     * @param string $search search text
     *
     * @return mixed|integer|boolean
     */
    public function getPages($data = ['*'], $match_case = [], $paginate_page = null, $search = '')
    {
        $pages = TlPage::join('tl_users', 'tl_users.id', '=', 'tl_pages.user_id')
            ->leftJoin('tl_page_templates', 'tl_page_templates.id', '=', 'tl_pages.page_template')
            ->orderBy('tl_pages.order', 'asc')
            ->orderBy('tl_pages.id', 'desc')
            ->groupBy('tl_pages.id')
            ->where($match_case);

        $pages = $pages->where(function ($query) use ($search) {
            $query->where('tl_pages.title', 'like', '%' . $search . '%')
                ->orWhere('tl_pages.visibility', 'like', '%' . $search . '%')
                ->orWhere('tl_pages.content', 'like', '%' . $search . '%')
                ->orWhere('tl_users.name', 'like', '%' . $search . '%');
        });

        $pages = $pages->select($data);

        if (isset($paginate_page)) {
            $pages = $pages->paginate($paginate_page);
        } else {
            $pages;
        }
        return $pages;
    }

    /**
     ** get a page by permalink
     * @return mixed|array
     */
    public function findPage($permalink)
    {
        $page = TlPage::where('permalink', $permalink)->first();
        return $page;
    }
}
