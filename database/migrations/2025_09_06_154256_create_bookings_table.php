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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->foreignId('rate_plan_id')->constrained('rate_plans')->onDelete('cascade');
            
            // Customer Information
            $table->string('customer_name', 100);
            $table->string('customer_phone', 20);
            $table->string('customer_email', 150)->nullable();
            
            // Booking Details
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->tinyInteger('adults')->unsigned()->default(1);
            $table->tinyInteger('children')->unsigned()->default(0);
            $table->tinyInteger('nights')->unsigned();
            $table->enum('room_type', ['standard', 'pool_sea', 'sea_facing', 'superior'])->default('standard');
            $table->text('special_requests')->nullable();
            
            // Pricing Information
            $table->decimal('base_price', 10, 2);
            $table->decimal('room_upgrade_cost', 8, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->char('currency', 3)->default('EGP');
            
            // Payment Information
            $table->enum('payment_method', ['bank_transfer', 'instapay'])->default('bank_transfer');
            $table->string('payment_reference', 50)->nullable();
            $table->string('receipt_image', 255)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'verified', 'failed', 'refunded'])->default('pending');
            $table->timestamp('payment_date')->nullable();
            
            // Booking Management
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->string('booking_reference', 15)->unique();
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
