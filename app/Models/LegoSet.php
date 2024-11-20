<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegoSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'series_id', 'price', 'recommended_age',
        'piece_count', 'is_new', 'is_sale', 'discount'
    ];

    public function series()
    {
        return $this->belongsTo(LegoSeries::class, 'series_id');
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'lego_set_interest');
    }

    public function images()
    {
        return $this->hasMany(LegoImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
