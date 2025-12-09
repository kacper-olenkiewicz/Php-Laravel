<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingItem extends Model
{
    use HasFactory;

    
   

    protected $fillable = ['booking_id', 'product_id', 'quantity', 'price_per_day', 'days'];

    
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}