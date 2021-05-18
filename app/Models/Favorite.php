<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'owner',
        'description',
        'stargazers',
        'url'
    ];

//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
