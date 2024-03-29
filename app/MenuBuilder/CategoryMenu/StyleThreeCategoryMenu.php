<?php


namespace App\MenuBuilder\CategoryMenu;

use App\BlogCategory;
use App\MenuBuilder\CategoryMenuBase;
use App\PageBuilder\Helpers\Traits\RenderMegaMenuView;
use Modules\Attributes\Entities\SubCategory;
use Modules\Product\Entities\ProductSubCategory;

class StyleThreeCategoryMenu extends CategoryMenuBase
{
    use RenderMegaMenuView;

    function model(){
        return 'Modules\Attributes\Entities\SubCategory';
    }

    function render($ids,$lang,$subcat_id=null,$title = null)
    {
        //it will have all html markup for the mega menu frontend
        $ids = explode(',',$ids);
        $sub_ids = explode(',',$subcat_id);
        $output = '';
        if (empty($ids)){
            return $output;
        }

        $mega_menu_items = SubCategory::whereIn('id',$sub_ids)->get();
        return $this->renderMegaMenuViews("style_three_category_menu",compact("mega_menu_items","title"));
    }

    function category($id)
    {
        $category = BlogCategory::where(['id' => $id])->first();
        return $category->name ?? __('Uncategorized');
    }

    function route()
    {
        //  Implement route() method.
        return 'frontend.blog.single';
    }

    function routeParams()
    {
        //  Implement routeParams() method.
        return ['id'];
    }

    function name()
    {
        //  Implement name() method.
        return __('Category Mega Menus 03');
    }

    function enable()
    {
        //  Implement enable() method.
        return true;
    }

    function query_type()
    {
        //  Implement query_type() method.
        return 'no_lang'; // old_lang|new_lang
    }
    function title_param()
    {
        //  Implement title_param() method.
        return 'title';
    }
    function slug()
    {
        //  Implement name() method.
        return 'blog_page_slug';
    }
}