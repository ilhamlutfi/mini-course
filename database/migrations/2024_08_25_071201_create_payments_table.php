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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentee_id')->constrained('users')->onDeleteCascade();
            $table->foreignId('course_id')->constrained('courses')->onDeleteCascade();
            $table->decimal('amount', 5, 2)->nullable()->default(123.45);
            $table->enum('status', ['pending', 'rejected', 'approved'])->default('pending');
            $table->datetime('paid_at')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
