<?php

namespace App\Transformers;

use App\Shop;
use League\Fractal\TransformerAbstract;

/**
 * Class MediaTransformer
 * @package App\Transformers
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
class ShopTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @var array
     */
    protected $defaultIncludes = [
        'orders',
        'products'
    ];

    /**
     * @param \App\Shop $media
     * @return arraysetCurrentScope
     */
    public function transform(Shop $shop)
    {
        $format = [
            'id'   => hashIdEncode($shop->id),
            'name' => $shop->shop_name,
        ];
        return $format;
    }

    /**
     * @param $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includeOrders($model)
    {
        if ($model->orders->count() > 0) {
            return $this->collection($model->orders, new OrderTransformer(), false);
        }
    }

    /**
     * @param $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includeProducts($model)
    {
        if ($model->products->count() > 0) {
            return $this->collection($model->products, new ProductTransformer(), false);
        }
    }
}
