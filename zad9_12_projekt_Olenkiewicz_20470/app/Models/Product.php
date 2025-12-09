<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasRentalScope; 

class Product extends Model
{
    use HasFactory, SoftDeletes, HasRentalScope; 

    protected $fillable = ['rental_id', 'name', 'description', 'daily_price', 'stock_quantity'];
    
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
}