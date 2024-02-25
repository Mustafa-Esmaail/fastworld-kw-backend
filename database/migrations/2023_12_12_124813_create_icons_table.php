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
        Schema::create('icons', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('content_id')->constrained(table:'contents')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            $table->tinyInteger('type')->nullable(); //1 =>social =>button

            $table->foreignId('button_id')->nullable()
            ->constrained(table:'buttons')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('social_id')->nullable()
            ->constrained(table:'socials')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->foreignId('social_icon_id')->constrained(table:'social_icons')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icons');
    }
};
