<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, softDeletes;

    /**
     * Get the customer that is connected to this category.
     */
    public function customers()
    {
        return $this->hasOne(Customers::class);
    }
}
