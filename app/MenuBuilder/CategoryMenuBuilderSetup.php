<?php

namespace App\MenuBuilder;

use App\Helpers\LanguageHelper;

class CategoryMenuBuilderSetup  {


    public  function register_mega_menu(){
        return [
            'App\MenuBuilder\CategoryMenu\StyleOneCategoryMenu',
            'App\MenuBuilder\CategoryMenu\StyleTwoCategoryMenu',
            'App\MenuBuilder\CategoryMenu\StyleThreeCategoryMenu',
        ];
    }

    public function render_mega_menu_list($lang){

        $output  = '';
        $output .= '<div class="card"> <div class="card-header" id="megamenu-page-list-items">';
        $output .= '<h2 class="mb-0"><button class="btn btn-link" type="button"  data-bs-toggle="collapse" data-bs-target="#megamenu-page-list-items-content" aria-expanded="true" aria-controls="page-list-items-content"> ';
        $output .= __('Mega Menus').' </button> </h2> </div>';
        $output .= ' <div id="megamenu-page-list-items-content" class="collapse" aria-labelledby="page-list-items"  data-parent="#add_menu_item_accordion"> <div class="card-body">';
        $output .= '<ul class="page-list-ul">';

        foreach ($this->register_mega_menu() as $item){
            $instance = new $item();
            $lang = $lang ?? LanguageHelper::default_slug();
            $output .= '<li data-ptype="'.$item.'"><label class="menu-item-title"> <input type="checkbox" class="menu-item-checkbox"> ';
            $output .= __($instance->name()).'</label></li>';
        }

        $output .= '</ul>';
        $output .= ' <div class="form-group"> <button type="button" id="add_dynamic_page_to_menu"  class="btn btn-primary btn-xs mt-4 pr-4 pl-4 add_mega_menu_to_menu">';
        $output .=__('Add MegaMenu').'</button> </div> </div></div> </div>';
        return $output;
    }

}
