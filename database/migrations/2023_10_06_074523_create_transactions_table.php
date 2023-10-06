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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->timestamp('date')->nullable();
            $table->decimal('qty', 20, 2)->default(0);
            $table->decimal('cost', 20, 2)->default(0);
            $table->decimal('price', 20, 2)->default(0);
            $table->decimal('total_cost', 20, 2)->default(0);
            $table->decimal('qty_balance', 20, 2)->default(0);
            $table->decimal('value_balance', 20, 2)->default(0);
            $table->decimal('hpp', 20, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
