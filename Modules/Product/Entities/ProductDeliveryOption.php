<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDeliveryOption extends Model
{
    use HasFactory;

    protected $fillable = ["product_id","delivery_option_id"];
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductDeliveryOptionFactory::new();
    }
}
