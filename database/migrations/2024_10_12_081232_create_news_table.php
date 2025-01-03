<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->unique()->nullable();
            $table->text('slug')->nullable();
            $table->string('tag_name')->nullable();
            $table->longText('content')->nullable();
            $table->text('image')->nullable();
            $table->foreignId('cate_id')->constrained('categories','id')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
