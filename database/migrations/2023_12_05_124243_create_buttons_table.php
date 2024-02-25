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
        Schema::create('buttons', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->string('title')->nullable();
            $table->string('icon_name')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); 
            $table->string('type')->nullable(); 
            $table->tinyInteger('subtype')->nullable(); 
            // $table->string('source_id')->nullable();
            // $table->string('featured')->nullable();
            $table->string('tcolor')->nullable();
            $table->string('bcolor')->nullable();
            $table->string('link1')->nullable();
            $table->string('link2')->nullable();
            $table->tinyInteger('state')->nullable();
            $table->tinyInteger('scheduled')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->json('text')->nullable();
            $table->string('path')->nullable();
            
            $table->foreignId('content_id')->constrained(table:'contents')
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
        Schema::dropIfExists('buttons');
    }
};
