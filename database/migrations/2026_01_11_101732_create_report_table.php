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
        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reported_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('sale_post_id')
                ->constrained('sale_posts')
                ->cascadeOnDelete();
            $table->text('reason');
            $table->tinyInteger('status')->default(0); // 0: pending, 1: reviewed, 2: dismissed
            $table->boolean('is_action_taken')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report');
    }
};
