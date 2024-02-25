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
        Schema::create('varification_profiles', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('position')->nullable()->default(0);//0,1,2
            
            $table->foreignId('owner_id')
            ->constrained(table: 'owners')
            ->onUpdate('cascade')
            ->onDelete('cascade')->nullable();

            $table->foreignId('varification_icon_id')
            ->constrained(table: 'varification_icons')
            ->onUpdate('cascade')
            ->onDelete('cascade')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varification_profiles');
    }
};
