<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'picture',
        'user_id',
        'post_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name','profile'); // use $comment->load('user') show only id and name
    }

    public function post()
    {
        return $this->belongsTo(Post::class)->select('id','title','picture');
    }
}
