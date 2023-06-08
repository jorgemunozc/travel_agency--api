<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_public')->default(false);
            $table->string('slug', 200)->unique();
            $table->string('name', 200);
            $table->text('description');
            $table->unsignedTinyInteger('num_of_days');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel');
    }
};
