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
        Schema::create('informations', function (Blueprint $table) {



            $table->id(); 
            $table->string('source')->nullable();
            $table->tinyInteger('substate')->nullable();
            $table->tinyInteger('dnstate')->nullable();
            $table->tinyInteger('suffix')->nullable();
            $table->string('title')->nullable();
            // $table->string('themeid')->nullable();
            $table->string('path')->nullable();
            $table->tinyInteger('part')->nullable();
            $table->string('description')->nullable();
            $table->json('theme')->nullable();
            $table->string('verified')->nullable();
            $table->string('uid')->nullable();
            $table->tinyInteger('discover_state')->nullable();
            $table->tinyInteger('state')->nullable();
            $table->tinyInteger('version_state')->nullable();
            $table->string('cover')->nullable();
            $table->string('background_image')->nullable();

            $table->foreignId('design_id')->nullable()
            ->constrained(table: 'designs')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('owner_id')
            ->constrained(table: 'owners')
            ->onUpdate('cascade')
            ->onDelete('cascade')->nullable();
            $table->timestamps();







        // $table->string('domain')->nullable();
        // $table->string('link')->nullable();













            // $table->text('title')->nullable();
            // $table->text('second_title')->nullable();
            // $table->text('description')->nullable();
            // $table->string('image')->nullable();
            // $table->string('backgroundimage')->nullable();

            // $table->json('socials')->nullable();

            // $table->text('facebook')->nullable();
            // $table->text('youtube')->nullable();
            // $table->text('instgram')->nullable();
            // $table->text('x')->nullable();
            // $table->text('tiktok')->nullable();
            // $table->text('gmail')->nullable();

            // $table->text('our_store')->nullable();
            // $table->text('monicur_store')->nullable();
            // $table->text('online_shop')->nullable();
            // $table->text('online_store')->nullable();
            // $table->text('shop')->nullable();
            // $table->text('shopee')->nullable();
            // $table->text('shop_products')->nullable();
            // $table->text('shop_new')->nullable();

            // $table->text('website')->nullable();

           

            // $table->text('video')->nullable();
            // $table->text('videos_title')->nullable();
            // $table->text('videos_description')->nullable();

            // $table->text('services')->nullable();
            // $table->text('our_services')->nullable();

            // $table->text('about_studio')->nullable();
            // $table->text('about_the_farm')->nullable();
            // $table->text('about_us')->nullable();
            // $table->text('about_me')->nullable();
            // $table->text('about')->nullable();

            // $table->text('contact_us')->nullable();
            // $table->text('contact')->nullable();

            // $table->text('plans_and_pricing')->nullable();
            // $table->text('plans')->nullable();

            // $table->text('book_online')->nullable();
            // $table->text('book_aclass')->nullable();

            // $table->text('activities')->nullable();

            // $table->text('facilities')->nullable();
            // $table->text('treatments')->nullable();
            // $table->text('specials')->nullable();
            // $table->text('challenges')->nullable();
            // $table->text('new_inventory')->nullable();
            // $table->text('per_owned')->nullable();
            // $table->text('financing')->nullable();
            // $table->text('testimonials')->nullable();
            // $table->text('faq')->nullable();
            // $table->text('workpalces')->nullable();
            // $table->text('models')->nullable();
            // $table->text('info')->nullable();
            // $table->text('album')->nullable();
            // $table->text('vlog')->nullable();
            // $table->text('location')->nullable();
            // $table->text('phone')->nullable();
            // $table->text('our_member')->nullable();
            // $table->text('sale_up_to_value')->nullable();
            // $table->text('buy_one_get_one_free')->nullable();
            // $table->text('get_discount')->nullable();
            // $table->text('items')->nullable();
            // $table->text('contest')->nullable();
            // $table->text('follow_me')->nullable();
            // $table->text('jouney')->nullable();
            // $table->text('strength')->nullable();
            // $table->text('bukalapak')->nullable();
            // $table->text('lazada')->nullable();
            // $table->text('say_hello')->nullable();
            // $table->text('training')->nullable();
            // $table->text('why_naturopathy')->nullable();
            // $table->text('riders')->nullable();
            // $table->text('tokyo')->nullable();
            // $table->text('spotify')->nullable();
            // $table->text('soundcloud')->nullable();
            // $table->text('vibe')->nullable();
            // $table->text('apple_music')->nullable();
            // $table->text('tickets')->nullable();
            // $table->text('epk')->nullable();
            // $table->text('tour')->nullable();
            // $table->text('media')->nullable();
            // $table->text('seoul')->nullable();
            // $table->text('buy_me_ticket')->nullable();
            // $table->text('deezer')->nullable();
            // $table->text('bandcamp')->nullable();
            // $table->text('audiomack')->nullable();
            // $table->text('collection')->nullable();
         
            // $table->text('introduction')->nullable();

            // $table->text('photographer')->nullable();
            // $table->text('our_team')->nullable();
            // $table->text('menu')->nullable();
            // $table->text('order')->nullable();
            // $table->text('rate_us')->nullable();
            // $table->text('store_address')->nullable();
            // $table->text('relax')->nullable();
            // $table->text('pinterest')->nullable();
            // $table->text('skype')->nullable();
            // $table->text('travel_vlog')->nullable();
            // $table->text('homestay')->nullable();
            // $table->text('traveling')->nullable();
            // $table->text('google_map')->nullable();
            // $table->text('travel_resources')->nullable();

            // $table->text('portfolio')->nullable();
            // $table->text('style')->nullable();
            // $table->text('discount')->nullable();
            // $table->text('show')->nullable();//لسه مش عارفين بتاعت اي
            // $table->text('band')->nullable();//لسه مش عارفين بتاعت اي
            // $table->text('summer_band')->nullable();//لسه مش عارفين بتاعت اي
            // $table->text('socials_description')->nullable();
            // $table->text('blog')->nullable();

            // $table->text('full_name')->nullable();//for sending email to owner
            // $table->text('email')->nullable();//for sending email to owner
            // $table->text('title_of_send_email')->nullable();//for sending email to owner
            // $table->text('footer_of_send_email')->nullable();//for sending email to owner
            // $table->text('follower_and_style_list')->nullable();//for sending email to owner

            // $table->foreignId('design_id')->nullable()
            // ->constrained(table: 'designs')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
            // $table->foreignId('owner_id')
            // ->constrained(table: 'owners')
            // ->onUpdate('cascade')
            // ->onDelete('cascade')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informations');
    }
};
