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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            // người đại diện
            $table->string('representative',255)->unique()->nullable();
            // tên đầy đủ của công ty
            $table->string('company_name')->unique()->nullable();
            // tên thường gọi của công ty
            $table->string('short_name')->nullable();
            $table->text('image')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('slug')->nullable();
            $table->string('content')->nullable();
            $table->string('link',255)->unique()->nullable();
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
