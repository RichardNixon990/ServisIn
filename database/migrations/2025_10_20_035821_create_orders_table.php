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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('tecnician_id');
            $table->string('device_type');
            $table->string('brand');
            $table->text('issue_description');
            $table->text('address');
            $table->date('schedule_date');
            $table->enum('status', ['pending','assigned','on_process','completed','cancelled']);
            $table->decimal('estimated_cost');
            $table->decimal('final_cost');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
