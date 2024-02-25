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
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->unique()->nullable();
            $table->string('public_id')->unique()->nullable();

            $table->foreignId('category_id')
            ->constrained(table: 'categories')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('image',100)->nullable();
            $table->string('backgroundimage',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
