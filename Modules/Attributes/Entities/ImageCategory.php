<?php

namespace Modules\Attributes\Entities;

use App\MediaUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Product;

class ImageCategory extends Model
{
    use HasFactory,SoftDeletes;

    // protected $with = ['logo'];
   
    protected $table = "imagecategories";
    protected $fillable = ["image_url","name"];

    // public function logo(): HasOne
    // {
    //     return $this->hasOne(MediaUpload::class,"id","image_id");
    // }

    // public function banner(): HasOne
    // {
    //     return $this->hasOne(MediaUpload::class,"id","banner_id");
    // }

}
