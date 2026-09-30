<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('platform', 60)->index();
            $table->string('genre', 80)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('games'); }
};
