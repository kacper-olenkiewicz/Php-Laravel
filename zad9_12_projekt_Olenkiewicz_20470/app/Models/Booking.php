<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\HasRentalScope; 

class Booking extends Model
{
    use HasFactory, SoftDeletes, HasRentalScope; 

    protected $fillable = ['rental_id', 'user_id', 'start_date', 'end_date', 'status', 'total_amount', 'notes'];
    
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
    
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    
    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }
    
   
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}