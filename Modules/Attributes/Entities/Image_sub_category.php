<?php

namespace Modules\Attributes\Entities;

use App\MediaUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Product;

class Image_sub_category extends Model
{
    use HasFactory,SoftDeletes;

    // protected $with = ['logo'];
   
    protected $table = "image_sub_categories";
    protected $fillable = ["imagecategories_id","image_url"];

    // public function logo(): HasOne
    // {
    //     return $this->hasOne(MediaUpload::class,"id","image_id");
    // }

    // public function banner(): HasOne
    // {
    //     return $this->hasOne(MediaUpload::class,"id","banner_id");
    // }

}
