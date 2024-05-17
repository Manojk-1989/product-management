<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; 
    protected $table = 'products';

    protected $fillable = [
        'product_title', 
        'product_description', 
        'product_image', 
        'color_ids',
        'size_ids',
    ];

    protected $casts = [
        'color_ids' => 'array',
        'size_ids' => 'array',
    ];

}
