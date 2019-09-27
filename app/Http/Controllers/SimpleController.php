<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\AuthRequest;
use App\Order;
use App\Product;
use App\Repository\Shop\ShopRepository;
use App\Services\Auth\JwtAuthentication;
use App\Shop;
use App\User;
use App\Http\Requests\FindShopRequest;

class SimpleController extends Controller
{
    public function index()
    {
        factory(User::class)->create();
        $user = User::find(1);
        $user->profile()->create([
            'name'      => 'test',
            'extension' => 'test',
            'path'      => 'path/path/path',
            'type'      => 'profile',
        ]);

        $user->book()->create([
            'name'      => 'test2',
            'extension' => 'test2',
            'path'      => 'path/path/path2',
            'type'      => 'book',
        ]);

        return ['profile' => $user->profile->where('type', 'profile'), 'book' => $user->book->where('type', 'book')];
    }

    public function shop(ShopRepository $repository)
    {
        return $repository->index();

        return Shop::find(6)->with('orders')->get();
    }

    public function createShop()
    {
        $shop    = factory(Shop::class)->create();
        $product = factory(Product::class)->create(['shop_id' => $shop->id]);
        factory(Order::class, 5)->create(['product_id' => $product->id]);
    }

    public function findShop(ShopRepository $repository, FindShopRequest $request)
    {
        return $repository->detail($request->id);
    }

    public function createUser()
    {
        return factory(User::class)->create(['password' => bcrypt('123456')]);
    }

    public function authen(JwtAuthentication $authentication, AuthRequest $request)
    {

        return $authentication->authenticate($request);
    }
}
