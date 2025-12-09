<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; 

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'rental_id', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
    
    
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    
    
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}