<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            Product::class,
            'shop_id',
            'product_id',
            'id'
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
