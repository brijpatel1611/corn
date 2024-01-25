<?php

namespace Modules\Attributes\Entities;

use App\MediaUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Product;

class Modal extends Model
{
    use HasFactory,SoftDeletes;

    protected $with = ['logo'];

    protected $fillable = ["name","brand_id","thumb_icon_id","model_img_id"];

    public function logo(): HasOne
    {
        return $this->hasOne(MediaUpload::class,"id","thumb_icon_id");
    }

    public function banner(): HasOne
    {
        return $this->hasOne(MediaUpload::class,"id","model_img_id");
    }

  

}
