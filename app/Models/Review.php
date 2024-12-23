<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['pros', 'cons', 'comment', 'rating'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function legoSet(){
        return $this->belongsTo(LegoSet::class);
    }

    public function adminReply()
    {
        return $this->hasOne(AdminReply::class);
    }
}
