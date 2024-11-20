<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function legoSets()
    {
        return $this->belongsToMany(LegoSet::class, 'lego_set_interest');
    }

}
