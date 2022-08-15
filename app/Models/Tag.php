<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'tags';

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_DELETED_AT = 'deleted_at';
    public const COLUMN_PIVOT = 'pivot';

    public const RELATION_BLOG_POSTS = 'blogPosts';

    protected  $table = self::TABLE_NAME;
    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::COLUMN_DELETED_AT,
        self::COLUMN_PIVOT
    ];

    protected $fillable = [
        self::COLUMN_NAME,
    ];

    public function blogPosts(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogPost::class,
            BlogPostTag::TABLE_NAME,
            BlogPostTag::COLUMN_TAG_ID,
            BlogPostTag::COLUMN_BLOG_POST_ID
        );
    }

}
