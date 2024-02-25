<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_id')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('email_second')->unique()->nullable();

            $table->string('password',200)->nullable();
            $table->string('avater',100)->nullable();
            // $table->string('device_token',255)->nullable();
            // $table->boolean('block')->default(false);
            $table->boolean('verify_account')->default(false);
            $table->boolean('verify_second_email')->default(false);
            // $table->text('block_reason',300)->nullable();
            $table->timestamps();
            $table->softDeletes(); // [tl! ++]

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners');

        // Schema::table('posts', function (Blueprint $table) {
        //     $table->dropSoftDeletes(); // [tl! ++]
        // });
    }
}
