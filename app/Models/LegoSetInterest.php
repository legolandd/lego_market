<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegoSetInterest extends Model
{
    use HasFactory;

    protected $fillable = ['lego_set_id', 'interest_id'];
}
