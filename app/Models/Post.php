<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category()
    {
    	return $this->belongsTo(Category::class,'category_id','id');
    }

    public function tags()
    {
    	return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
    public function Admin()
    {
    	return $this->belongsTo(Admin::class,'user_id','id');
    }
    public function files()
    {
    	return $this->hasMany(File::class, 'post_id','id');
    }
}
