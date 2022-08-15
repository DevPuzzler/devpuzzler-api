<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostTag extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'blog_post_tags';

    public const COLUMN_BLOG_POST_ID = 'blog_post_id';
    public const COLUMN_TAG_ID = 'tag_id';

    protected $table = self::TABLE_NAME;
}
