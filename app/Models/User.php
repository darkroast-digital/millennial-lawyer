<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username',
        'name',
        'email',
        'username',
        'password',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
