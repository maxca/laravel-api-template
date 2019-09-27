<?php

namespace App\Repository\Shop;

use App\Repository\ApiBaseRepository;
use App\Shop;
use App\Transformers\ShopTransformer;

class ShopRepository extends ApiBaseRepository
{
    protected $eloquent = Shop::class;

    protected $transformer = ShopTransformer::class;
}