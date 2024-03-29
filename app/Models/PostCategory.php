<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'post_categories';

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_DESCRIPTION = 'description';
    public const COLUMN_DELETED_AT = 'deleted_at';
    public const COLUMN_BLOG_POSTS = 'blog_posts';

    public const RELATION_BLOG_POSTS = 'blogPosts';

    protected $table = self::TABLE_NAME;


    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_DESCRIPTION
    ];

    protected $hidden = [
        self::UPDATED_AT,
        self::COLUMN_DELETED_AT
    ];

    public function blogPosts(): HasMany
    {
        return $this->hasMany(
            BlogPost::class,
            BlogPost::COLUMN_CATEGORY_ID,
            self::COLUMN_ID
        );
    }
}
