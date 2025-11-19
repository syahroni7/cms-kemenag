<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_type', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();     // superadmin, admin, publisher, author
            $table->string('name');               // Super Administrator, Administrator, Publisher, Author
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_type');
    }
};
