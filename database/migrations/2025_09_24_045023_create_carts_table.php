<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('size')->nullable()->after('quantity');
        $table->string('color')->nullable()->after('size');
        $table->decimal('price', 10, 2)->after('color');
            $table->timestamps();
            
            $table->unique(['user_id', 'product_id']); // منع تكرار المنتج في السلة
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};