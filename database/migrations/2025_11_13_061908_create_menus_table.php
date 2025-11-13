<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Nama menu
            $table->string('icon')->nullable(); // Icon menu opsional
            $table->string('url')->nullable(); // URL menu (jika menu punya link)
            $table->unsignedBigInteger('parent_id')->nullable(); // parent_id null = menu utama
            $table->integer('order')->default(0); // Urutan menu
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('menus');
    }
};

