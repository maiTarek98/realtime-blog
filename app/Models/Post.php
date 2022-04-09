<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guard=[];
    protected $table = 'posts';

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function comments() {
        return $this->hasMany(\App\Models\Comment::class, 'post_id');
    }

}
