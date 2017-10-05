<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body'];
    //protected $guarded = ['_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
