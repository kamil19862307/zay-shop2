<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View|Factory|Application
    {
        $product->load(['optionValues.option']);

        $optons = $product->optionValues->mapToGroups(function ($item){
            return [$item->option->title => $item];
        });

        $viewed = session('viewed', []);

        if (!blank(session('viewed'))){
            $viewed = Product::query()
                ->where(function($q) use ($product){
                    $q->whereIn('id', session('viewed'))
                        ->where('id', '!=', $product->id);
                })
                ->limit(3)
                ->get();
        }

        session()->put('viewed.' . time(), $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $optons,
            'viewed' => $viewed
        ]);
    }
}
