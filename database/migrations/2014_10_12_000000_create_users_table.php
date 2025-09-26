<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('is_admin')->default(0); // ✅ تم التصحيح هنا
            $table->rememberToken();
            $table->timestamps();
        });

        // ✅ إضافة مستخدم admin تلقائياً
        DB::table('users')->insert([
            'name' => 'khedr oniza',
            'email' => 'khedroniza1@gmail.com',
            'password' => Hash::make('987uykuhg7865675'), // كلمة سر افتراضية
            'is_admin' => 1, // قيمة 1 تعني admin
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
