<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customers extends Model
{
    use HasFactory, softDeletes;

    /**
     * Get the category associated with the client.
     */
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category');
    }
}
