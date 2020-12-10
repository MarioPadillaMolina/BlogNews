<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    //relación N:1
    public function post() {
        return $this->belongsTo('App\Models\Post');
    }

}
