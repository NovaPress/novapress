<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        Schema::dropIfExists('settings');
    }
};
