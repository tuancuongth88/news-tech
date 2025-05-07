<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['name','link','post_id','post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
}
