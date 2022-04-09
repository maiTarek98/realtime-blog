<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guard=[];
    protected $table = 'comments';

      public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function post_id() {
        return $this->belongsTo(\App\Models\Post::class, 'id', 'post_id');
    }
}
