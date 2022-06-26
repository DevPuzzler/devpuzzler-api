<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategories extends Model
{
    use HasFactory, SoftDeletes;

    public const COLUMN_ID = 'id';
    public const COLUMN_NAME = 'name';
    public const COLUMN_DESCRIPTION = 'description';
    public const COLUMN_CREATED_AT = 'created_at';
    public const COLUMN_UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::COLUMN_NAME,
        self::COLUMN_DESCRIPTION
    ];
}
