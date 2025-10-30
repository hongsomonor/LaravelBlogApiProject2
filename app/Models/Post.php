<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'picture',
        'user_id',
        'category_id'
    ];

    // protected $hidden = ['user_id','category_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->select('name','profile');
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->select('name');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
}
