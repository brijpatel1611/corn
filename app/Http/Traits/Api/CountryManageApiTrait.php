<?php

namespace App\Http\Traits\Api;

use Modules\CountryManage\Entities\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\CountryManage\Entities\City;
use Modules\CountryManage\Entities\Country;
use Modules\Attributes\Entities\Brand;
use Modules\Attributes\Entities\Modal;
use Modules\Attributes\Entities\ImageCategory;
use Modules\Attributes\Entities\Image_sub_category;

trait CountryManageApiTrait
{
   /*
    * fetch all country lists from a database
    */
    public function country(Request $request): JsonResponse
    {
        // before change please mind it this method is also used on vendor api
        $country = Country::select('id', 'name')
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where("name","LIKE", "%" . strip_tags($request->only("name")['name']) ."%");
            })
            ->orderBy('name', 'asc')->paginate(20);

        return response()->json([
            'countries' => $country,
        ]);
    }

    /*
    * fetch all state list based on provided country id from a database
    */
    public function stateByCountryId($id, Request $request)
    {
        // before change please mind it this method is also used on vendor api
        if(empty($id)){
            return response()->json([
                'message' => __('provide a valid country id'),
            ])->setStatusCode(422);
        }

        $state = State::select('id', 'name','country_id')
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where("name","LIKE", "%" . strip_tags($request->only("name")['name']) ."%");
            })
            ->where('country_id',$id)
            ->orderBy('name', 'asc')->paginate(20);

        return response()->json([
            'state' => $state,
        ]);
    }

    public function cityByCountryId(Request $request, $id){
        // before change please mind it this method is also used on vendor api
        if(empty($id)){
            return response()->json([
                'message' => __('provide a valid country id'),
            ])->setStatusCode(422);
        }

        $cities = City::select('id', 'name','state_id')
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where("name","LIKE", "%" . strip_tags($request->only("name")['name']) ."%");
            })->where('state_id',$id)->orderBy('name', 'asc')->paginate(20);

        return response()->json([
            'state' => $cities,
        ]);
    }
    
    
     public function brand()
    {
        $brands = Brand::all();

        if ($brands->count() > 0) {
            // Success case: Brands found
            return response()->json([
                'status' => true,
                'message' => 'Brands fetched successfully',
                'brands' => $brands,
            ]);
        } else {
            // Error case: No brands found
            return response()->json([
                'status' => false,
                'message' => 'No brands found',
            ]);
        }
    }
    
     public function model(Request $request)
    {
        try {
            // Validate that 'brand_id' is present in the request
            $request->validate([
                'brand_id' => 'required',
            ]);
    
            $brand_id = $request->input('brand_id');
        
            $models = Modal::where('brand_id', $brand_id)->get();
    
            // Assuming you have a configuration for your base URL
            $baseURL = config('app.url') . '/core/public/storage/';
            // dd($baseURL);
            foreach ($models as $model) {
                // Set the complete image paths with the base URL
                $model->thumb_icon_id = $baseURL . $model->thumb_icon_id;
                $model->model_img_id = $baseURL . $model->model_img_id;
            }
    // dd($models);
            return response()->json([
                'success' => true,
                'message' => 'Models retrieved successfully',
                'models' => $models
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving models: ' . $e->getMessage(),
            ]);
        }
    }
    
    
    
     public function image_cat()
		{
		  //  dd("skaslka");
			$image_category = ImageCategory::all();
		
			if ($image_category->count() > 0) {
				// Assuming you have a configuration for your base URL
				$baseURL = config('app.url') . '/core/public/storage/';
		
				foreach ($image_category as $category) {
					// Set the complete image path with the base URL
					$category->image_url = url($baseURL . $category->image_url);
				}
		
				return response()->json([
					'status' => true,
					'message' => 'Image category fetched successfully',
					'image_category' => $image_category,
				]);
			} else {
				return response()->json([
					'status' => false,
					'message' => 'No brands found',
				]);
			}
		}
		
		
		public function image_sub_cat(Request $request)
			{
				try {
					// Validate that 'imagecategories_id' is present in the request
					$request->validate([
						'imagecategories_id' => 'required',
					]);
			
					$imagecategories_id = $request->input('imagecategories_id');
					
					$images = Image_sub_category::where('imagecategories_id', $imagecategories_id)->get();
			
					if ($images->count() > 0) {
						// Assuming you have a configuration for your base URL
						$baseURL = config('app.url') . '/core/public/storage/';
			
						foreach ($images as $image) {
							// Set the complete image path with the base URL
							$image->image_url = url($baseURL . $image->image_url);
						}
			
						return response()->json([
							'success' => true,
							'message' => 'Image subcategories retrieved successfully',
							'subimages' => $images,
						]);
					} else {
						return response()->json([
							'success' => false,
							'message' => 'No images found for the specified category',
						]);
					}
				} catch (\Exception $e) {
					return response()->json([
						'success' => false,
						'message' => 'Error retrieving images: ' . $e->getMessage(),
					]);
				}
			}
}