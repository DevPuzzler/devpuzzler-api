<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'blog_posts';

    public const COLUMN_ID = 'id';
    public const COLUMN_TITLE = 'title';
    public const COLUMN_EXCERPT = 'excerpt';
    public const COLUMN_CATEGORY_ID = 'category_id';
    public const COLUMN_CONTENT = 'content';
    public const COLUMN_IS_ACTIVE = 'is_active';
    public const COLUMN_IS_RESTRICTED = 'is_restricted';
    public const COLUMN_DELETED_AT = 'deleted_at';

    public const RELATION_TAGS = 'tags';
    public const RELATION_CATEGORY = 'category';

    protected $fillable = [
        self::COLUMN_TITLE,
        self::COLUMN_EXCERPT,
        self::COLUMN_CATEGORY_ID,
        self::COLUMN_CONTENT,
        self::COLUMN_IS_RESTRICTED
    ];

    protected $hidden = [
        self::COLUMN_DELETED_AT
    ];

    public function category(): HasOne
    {
        return $this->hasOne(
            PostCategory::class,
            PostCategory::COLUMN_ID,
            self::COLUMN_CATEGORY_ID
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            BlogPostTag::TABLE_NAME,
            BlogPostTag::COLUMN_BLOG_POST_ID,
            BlogPostTag::COLUMN_TAG_ID
        );
    }
}
