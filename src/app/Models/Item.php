<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{

use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'price',
        'description',
        'condition',
        'image',
    ];
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}
public function categories()
{
    return $this->belongsToMany(Category::class);
}
}