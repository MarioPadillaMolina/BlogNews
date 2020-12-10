<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    //lo contrario de fillable. En lugar de especificar lo rellenable, especifico qué quiero proteger
    protected $guarded = [];

    //relación N:1
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
}