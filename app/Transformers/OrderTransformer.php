<?php

namespace App\Transformers;

use App\Order;
use League\Fractal\TransformerAbstract;
use Hashids\Hashids;

/**
 * Class OrderTransformer
 * @package App\Transformers
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
class OrderTransformer extends TransformerAbstract
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
     * @param \App\Order $order
     * @return array
     * @throws \Exception
     */
    public function transform(Order $order)
    {
        $format = [
            'id'       => hashIdEncode($order->id),
            'name'     => $order->order_name,
        ];
        return $format;
    }


}
