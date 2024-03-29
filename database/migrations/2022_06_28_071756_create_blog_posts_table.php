<?php

use App\Models\BlogPost;
use App\Models\PostCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(BlogPost::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(BlogPost::COLUMN_CATEGORY_ID);
            $table->string(BlogPost::COLUMN_TITLE)->nullable(false)->unique();
            $table->tinyText(BlogPost::COLUMN_EXCERPT)->nullable(false);
            $table->mediumText(BlogPost::COLUMN_CONTENT);
            $table->boolean(BlogPost::COLUMN_IS_ACTIVE)->default(false);
            $table->boolean(BlogPost::COLUMN_IS_RESTRICTED)->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign(BlogPost::COLUMN_CATEGORY_ID)
                ->references(PostCategory::COLUMN_ID)
                ->on(PostCategory::TABLE_NAME);
        });
    }

    public function down()
    {
        Schema::dropIfExists(BlogPost::TABLE_NAME);
    }
};
