<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'detail',
        'price',
        'stock',
        'discount'
    ];
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
