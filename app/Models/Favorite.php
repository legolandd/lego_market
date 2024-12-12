<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lego_set_id'];

    public function legoSet()
    {
        return $this->belongsTo(LegoSet::class);
    }
}
