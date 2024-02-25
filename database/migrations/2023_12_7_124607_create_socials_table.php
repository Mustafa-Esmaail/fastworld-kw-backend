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
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->nullable();
            $table->string('title')->nullable();
            $table->string('icon_name')->nullable();
            $table->string('link')->nullable();
            // $table->tinyInteger('order');
            $table->string('image')->nullable();
            // $table->string('pid')->nullable();

            $table->foreignId('content_id')->constrained(table:'contents')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();

            // $table->id();
            // $table->string('name',100)->unique(); 
            // $table->string('image',100)->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socials');
    }
};
