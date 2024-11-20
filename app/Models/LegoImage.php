<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegoImage extends Model
{
    use HasFactory;

    protected $fillable = ['lego_set_id', 'image_url'];

    public function legoSet()
    {
        return $this->belongsTo(LegoSet::class);
    }
}
