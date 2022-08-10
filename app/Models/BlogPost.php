<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
