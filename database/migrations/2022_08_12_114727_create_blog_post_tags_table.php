<?php

use App\Models\BlogPost;
use App\Models\BlogPostTag;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(BlogPostTag::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(BlogPostTag::COLUMN_BLOG_POST_ID)->nullable(false);
            $table->unsignedBigInteger(BlogPostTag::COLUMN_TAG_ID)->nullable(false);
            $table->timestamps();

            $table
                ->foreign(BlogPostTag::COLUMN_BLOG_POST_ID)
                ->references(BlogPost::COLUMN_ID)
                ->on(BlogPost::TABLE_NAME);

            $table
                ->foreign(BlogPostTag::COLUMN_TAG_ID)
                ->references(Tag::COLUMN_ID)
                ->on(Tag::TABLE_NAME);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(BlogPostTag::TABLE_NAME);
    }
};
