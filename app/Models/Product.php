<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // This is where you specify the table name (not necessary here) if its name doesn't follow the Laravel naming convension.
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price'
    ];
}
