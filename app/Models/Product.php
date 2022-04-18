<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_AVAILABLE = 'available';
    const STATUS_UNAVAILABLE = 'unavailable';

    protected $table = 'products';

    protected $fillable = [
        'article',
        'name',
        'status',
        'data',
    ];

    public function getAvailableProducts()
    {
        return self::where('status', self::STATUS_AVAILABLE)->get();
    }
}
