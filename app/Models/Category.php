<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

    const NAME = 'name';
    const POSITION = 'position';
    const SLUG = 'slug';
    const RSS_URL = 'rss_url';
    const PARENT_ID = 'parent_id';
    const DESCRIPTION = 'description';
    const STATUS = 'status';
    public $fillable = [
        self::NAME,
        self::POSITION,
        self::SLUG,
        self::RSS_URL,
        self::PARENT_ID,
        self::DESCRIPTION,
        self::STATUS,
    ];
    public function posts()
    {
        return $this->hasMany(Post::class,'category_id','id');
    }
}
