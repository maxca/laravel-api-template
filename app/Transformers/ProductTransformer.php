<?php

namespace App\Transformers;

use App\Order;
use App\Product;
use League\Fractal\TransformerAbstract;

/**
 * Class OrderTransformer
 * @package App\Transformers
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
class ProductTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * @param \App\Product $order
     * @return array
     * @throws \Exception
     */
    public function transform(Product $order)
    {
        $format = [
            'id'   => hashIdEncode($order->id),
            'name' => $order->products_name,
        ];
        return $format;
    }


}
