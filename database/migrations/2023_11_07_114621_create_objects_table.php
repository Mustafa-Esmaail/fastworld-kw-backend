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
        Schema::create('objects', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable(); 
            $table->string('img')->nullable();
            // $table->string('backgroundimage')->nullable();
            $table->string('imgtwo')->nullable();
            $table->json('data')->nullable();
            $table->json('Container')->nullable();
            $table->json('Contact')->nullable();
            $table->json('DivProfilePicture')->nullable();
            $table->json('ProfilePicture')->nullable();
            $table->json('StyledButton')->nullable();

            // $table->json('colors')->nullable();
            // $table->json('FontFace')->nullable();
            // $table->json('object')->nullable();
            // $table->json('borderStyle')->nullable();
            // $table->json('borderSize')->nullable();
            // // $table->json('borderStyle')->nullable();
            // $table->json('outlineStyle')->nullable();
            // $table->json('profileAlginment')->nullable();
            // $table->json('socialAlginment')->nullable();
            
            $table->foreignId('information_id')->constrained(table:'informations')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            // $table->foreignId('owner_id')
            // ->constrained(table: 'owners')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objects');
    }
};

