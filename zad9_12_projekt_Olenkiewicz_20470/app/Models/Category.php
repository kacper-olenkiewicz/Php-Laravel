<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasRentalScope; 

class Category extends Model
{
    use HasFactory, SoftDeletes, HasRentalScope; 

    protected $fillable = ['rental_id', 'name', 'description'];
    
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
    
    
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
}