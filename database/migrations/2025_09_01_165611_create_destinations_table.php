<?php
// 2- Destinations Table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // {"en":"Dahab","fr":"Dahab","ar":"دهب"}
            $table->json('description')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_add_id')->nullable();
            $table->timestamps();
        });
         Schema::table('destinations', function (Blueprint $table) {
            $table->foreign('user_add_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
