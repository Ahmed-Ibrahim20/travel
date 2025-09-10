<?php
// 3- Tours Table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('tours', function (Blueprint $table) {
      $table->id();
      $table->foreignId('destination_id')->constrained()->cascadeOnDelete();

      $table->json('title'); // {"en":"Desert Safari","fr":"Safari du désert","de":"Wüstensafari"} 
      $table->json('description')->nullable();
      $table->integer('capacity')->default(0); // عدد المقاعد المتاحة
      $table->json('image')->nullable();

      $table->decimal('rating', 2, 1)->default(0); // التقييم بالنجوم (مثلاً 4.5)

      // معلومات الفندق - منظم باللغات
      $table->json('hotel_info')->nullable();
      /*
      {
        "en": {
          "name": "Golf Strand Resort",
          "location": "Taba Heights",
          "features": ["Beach", "Pool", "Spa"]
        },
        "fr": {
          "name": "Golf Strand Resort",
          "location": "Taba Heights",
          "features": ["Plage", "Piscine", "Spa"]
        },
        "de": {
          "name": "Golf Strand Resort",
          "location": "Taba Heights",
          "features": ["Strand", "Schwimmbad", "Wellness"]
        }
      }
    */

      // معلومات الباكدج - منظم باللغات
      $table->json('package_info')->nullable();
      /*
            {
                "en": {
                "board": "All Inclusive",
                "activities": ["Snorkeling", "Safari"],
                "child_policy": "Free under 6"
                },
                "fr": {
                "board": "Tout inclus",
                "activities": ["Plongée", "Safari"],
                "child_policy": "Gratuit pour moins de 6 ans"
                },
                "de": {
                "board": "Alles inklusive",
                "activities": ["Schnorcheln", "Safari"],
                "child_policy": "Kostenlos unter 6 Jahren"
                }
            }
            */
      $table->enum('tour_type', ['hotel', 'honeymoon', 'trip'])
        ->default('trip');
        
      $table->unsignedBigInteger('user_add_id')->nullable();
      $table->timestamps();
    });

    Schema::table('tours', function (Blueprint $table) {
      $table->foreign('user_add_id')->references('id')->on('users')->onDelete('set null');
    });
  }
  public function down(): void
  {
    Schema::dropIfExists('tours');
  }
};
