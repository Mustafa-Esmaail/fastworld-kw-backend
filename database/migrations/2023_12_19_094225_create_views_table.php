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
        Schema::create('views', function (Blueprint $table) {
            $table->id();
         $table->foreignId('link_id')->constrained(table:'links')
         ->onUpdate('cascade')
         ->onDelete('cascade');
            // $table->tinyInteger('visit')->default(0);

            //source social
            //facebook 1
            //instagram 2
            //twitter 3
            //direct 4
            //other 5
            $table->tinyInteger('source_social')->nullable();

            //source Device 
            //mobil 1
            //pc 2
            //tab 3
            $table->tinyInteger('source_device')->nullable();
            
            //source system
            //ios 1
            //android 2 
            //windows 3
            //mac 4
            $table->tinyInteger('source_system')->nullable();

            //location
            //EGY 1
            //KSA 2
            //UAE 3
            //USA 4
            $table->tinyInteger('source_location')->nullable();
                  
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('views');
    }
};
