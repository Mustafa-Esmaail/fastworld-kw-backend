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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->boolean('state')->default(true);
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            // $table->string('embed')->nullable();
            $table->json('text')->nullable();
            // $table->tinyInteger('order');  
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('subtype')->nullable();
            $table->string('path')->nullable();


    
            $table->foreignId('information_id')->constrained(table:'informations')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('owner_id')
            ->constrained(table: 'owners')
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
        Schema::dropIfExists('contents');
    }
};
