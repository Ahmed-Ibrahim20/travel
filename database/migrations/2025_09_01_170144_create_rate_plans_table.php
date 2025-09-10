<?php
// 4- Rate Plans Table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rate_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();

            $table->json('name'); // {"en":"Standard Package","fr":"Forfait Standard","ar":"الباقة العادية"}
            $table->string('room_type')->nullable(); // Single, Double, Triple
            $table->date('start_date'); // بداية الفترة
            $table->date('end_date');   // نهاية الفترة
            $table->string('board_type')->nullable(); // All inclusive, Half board, etc.
            $table->string('transportation')->nullable(); // No transfers, Bus, Private car

            $table->decimal('price', 10, 2); // السعر للشخص
            $table->string('currency', 3)->default('EGP');

            $table->json('details')->nullable(); // وصف الباقة
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rate_plans');
    }
};

