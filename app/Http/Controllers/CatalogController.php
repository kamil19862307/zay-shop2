<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): View|Application|Factory
    {
        $categories = Category::query()
            ->select(['id', 'title', 'slug'])
            ->has('products')
            ->get();

        $products = Product::query()
            ->select(['id', 'title', 'slug', 'price', 'thumbnail'])
            ->when(request('search'), function (Builder $query){
                $query->whereFullText(['title', 'text'], request('search'));
            })
            ->when($category->exists, function (Builder $query) use ($category){
                $query->whereRelation('categories', 'categories.id', '=', $category->id);
                })
            ->filtered()
            ->sorted()
            ->paginate(9);

        return view('catalog.index', compact(
            'categories',
            'products',
            'category',
        ));
    }
}
