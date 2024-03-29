<?php

use App\Models\PostCategory;
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
    public function up()
    {
        Schema::create(PostCategory::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(PostCategory::COLUMN_NAME)->unique()->nullable(false);
            $table->tinyText(PostCategory::COLUMN_DESCRIPTION)->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(PostCategory::TABLE_NAME);
    }
};
