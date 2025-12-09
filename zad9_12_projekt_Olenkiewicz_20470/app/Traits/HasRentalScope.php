<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait HasRentalScope
{
    protected static function bootHasRentalScope()
    {
        // 1. Zastosowanie Global Scope: automatycznie filtruje zapytania
        static::addGlobalScope('rental', function (Builder $builder) {
            $user = Auth::user();

            // Scope działa tylko dla zalogowanych RentalOwner i Employee, 
            // SuperAdmin i Customer widzą wszystko/nie są scope'owani na ten sposób
            if ($user && ($user->hasRole('RentalOwner') || $user->hasRole('Employee'))) {
                // Dodaj alias tabeli, aby uniknąć kolizji z JOIN'ami
                $builder->where($builder->getModel()->getTable() . '.rental_id', $user->rental_id);
            }
        });

        // 2. Automatyczne przypisanie rental_id przy tworzeniu nowych rekordów
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && ($user->hasRole('RentalOwner') || $user->hasRole('Employee')) && empty($model->rental_id)) {
                $model->rental_id = $user->rental_id;
            }
        });
    }
}