<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id')->unsigned()->nullable();
            $table->bigInteger('reciver_id')->unsigned()->nullable();
            $table->date('read_at')->nullable();
            $table->string('reciver_type')->default(0)->comment('student teacher');
            $table->string('sender_type')->default(0)->comment('student teacher');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
