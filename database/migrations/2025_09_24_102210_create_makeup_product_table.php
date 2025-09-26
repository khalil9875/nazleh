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
        Schema::create('makeup_product', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المنتج
            $table->text('description')->nullable(); // وصف المنتج
            $table->string('image')->nullable(); // صورة المنتج
            $table->decimal('price', 10, 2); // السعر
            $table->integer('quantity')->default(0); // الكمية
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة المنتج
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade'); // المفتاح الخارجي
            
            // العمود الجديد
            $table->enum('categ', ['cosmatic', 'skin care', 'makeup'])->default('makeup');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makeup_product');
    }
};