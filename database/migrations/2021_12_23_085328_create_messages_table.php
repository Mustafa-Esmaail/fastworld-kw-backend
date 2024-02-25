<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            // $table->bigInteger('teacher_id')->nullable();
            // $table->bigInteger('student_id')->nullable();
            $table->bigInteger('sender_id')->unsigned()->nullable();
            $table->bigInteger('reciver_id')->unsigned()->nullable();
            $table->string('reciver_type')->default(0)->comment('student teacher');
            $table->string('sendr_type')->default(0)->comment('student teacher');
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
        Schema::dropIfExists('messages');
    }
}
