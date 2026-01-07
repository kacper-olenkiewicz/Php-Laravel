<?php
namespace App\Models;

use App\Traits\HasRentalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasRentalScope; 

    protected $fillable = [
        'rental_id',
        'name',
        'description',
        'daily_price',
        'stock_quantity',
        'image_path',
    ];

    protected $appends = ['preview_image_url'];

    protected static array $placeholderImages = [
        'https://picsum.photos/seed/gear-1/600/400',
        'https://picsum.photos/seed/gear-2/600/400',
        'https://picsum.photos/seed/gear-3/600/400',
        'https://picsum.photos/seed/gear-4/600/400',
        'https://picsum.photos/seed/gear-5/600/400',
        'https://picsum.photos/seed/gear-6/600/400',
        'https://picsum.photos/seed/gear-7/600/400',
        'https://picsum.photos/seed/gear-8/600/400',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->image_path)) {
                $product->image_path = static::placeholderImageFor();
            }
        });

        static::updating(function (Product $product) {
            if (empty($product->image_path)) {
                $product->image_path = static::placeholderImageFor($product->id);
            }
        });
    }
    
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
    
    
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
    
    
    public function bookingItems(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function getPreviewImageUrlAttribute(): string
    {
        $path = $this->image_path;

        if ($path) {
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }

            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->url($path);
            }
        }

        return static::placeholderImageFor($this->id);
    }

    public static function placeholderImageFor(?int $seed = null): string
    {
        $images = static::$placeholderImages;

        if (empty($images)) {
            $seed = $seed ?? random_int(1, 9999);
            return "https://picsum.photos/seed/product-{$seed}/600/400";
        }

        if ($seed === null) {
            $seed = random_int(0, count($images) - 1);
        }

        return $images[$seed % count($images)];
    }

    public static function randomPlaceholderImage(): string
    {
        return static::placeholderImageFor();
    }
}