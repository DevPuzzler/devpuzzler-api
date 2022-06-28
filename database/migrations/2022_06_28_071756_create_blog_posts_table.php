<?php

use App\Models\BlogPost;
use App\Models\PostCategories;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(BlogPost::COLUMN_CATEGORY_ID);
            $table->string(BlogPost::COLUMN_TITLE)->nullable(false);
            $table->tinyText(BlogPost::COLUMN_EXCERPT)->nullable(false);
            $table->mediumText(BlogPost::COLUMN_CONTENT);
            $table->boolean(BlogPost::COLUMN_IS_ACTIVE)->default(false);
            $table->boolean(BlogPost::COLUMN_IS_RESTRICTED)->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign(BlogPost::COLUMN_CATEGORY_ID)
                ->references(PostCategories::COLUMN_ID)
                ->on('post_categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
};
