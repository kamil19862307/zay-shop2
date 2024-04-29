<?php

namespace App\Models;

use App\Facades\Sorter;
use App\Jobs\ProductJsonProperties;
use App\Support\Casts\PriceCast;
use App\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;


    protected $fillable = [
        'title',
        'slug',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting',
        'text',
        'json_properties'
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array'
    ];

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();
    }

    public function scopeSorted(Builder $query)
    {
        Sorter::run($query);
    }

    public function scopeHomePage(Builder $query)
    {
        $query->select(['id', 'title', 'slug', 'price', 'thumbnail'])
            ->where('on_home_page', true)
            ->orderBy('sorting', 'desc')
            ->limit(3);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function(Product $product){
            ProductJsonProperties::dispatch($product)
                ->delay(now()->addSeconds(10));
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }
}
