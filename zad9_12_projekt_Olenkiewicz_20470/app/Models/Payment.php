<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasRentalScope; 

class Payment extends Model
{
    use HasFactory, SoftDeletes, HasRentalScope; 

    protected $fillable = ['booking_id', 'user_id', 'amount', 'method', 'transaction_id', 'status'];
    
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
    
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}