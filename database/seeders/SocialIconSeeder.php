<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SocialIcon;
use App\Models\SocialCategories;

class SocialIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $Cat1= SocialCategories::create([
            'name'=>'social',
        ]);
        SocialIcon::create([ 
            'name'=>'facebook',
            'icon'=>  'icons8-facebook-circled.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'instagram',
            'icon'=>  'icons8-instagram.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'airbnb',
            'icon'=>  'icons8-airbnb.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'store',
            'icon'=>  'icons8-app-store.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'behance',
            'icon'=>  'icons8-behance.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'cash-app',
            'icon'=>  'icons8-cash-app.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'bubble',
            'icon'=>  'icons8-discord-bubble.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'new',
            'icon'=>  'icons8-discord-new.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'dribble',
            'icon'=>  'icons8-dribble.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'dropbox',
            'icon'=>  'icons8-dropbox.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'messenger',
            'icon'=>  'icons8-facebook-messenger.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'gmail',
            'icon'=>  'icons8-gmail.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'google-drive',
            'icon'=>  'icons8-google-drive.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'google-maps',
            'icon'=>  'icons8-google-maps.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'google-play',
            'icon'=>  'icons8-google-play.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'google-plus',
            'icon'=>  'icons8-google-plus.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'itranslate',
            'icon'=>  'icons8-itranslate.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'line',
            'icon'=>  'icons8-line.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'linkedin',
            'icon'=>  'icons8-linkedin.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'medium',
            'icon'=>  'icons8-medium.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'message',
            'icon'=>  'icons8-message.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'odnoklassniki',
            'icon'=>  'icons8-odnoklassniki.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'patreon',
            'icon'=>  'icons8-patreon-logo.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'paypal',
            'icon'=>  'icons8-paypal.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'pinterest',
            'icon'=>  'icons8-pinterest.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'podcasts',
            'icon'=>  'icons8-podcasts.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'reddit',
            'icon'=>  'icons8-reddit.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'signal-app',
            'icon'=>  'icons8-signal-app.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'skype',
            'icon'=>  'icons8-skype.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'snapchat',
            'icon'=>  'icons8-snapchat-circled-logo.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'telegram',
            'icon'=>  'icons8-telegram.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'tiktok',
            'icon'=>  'icons8-tiktok.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'tumblr',
            'icon'=>  'icons8-tumblr.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'twitch',
            'icon'=>  'icons8-twitch.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'twitter',
            'icon'=>  'icons8-twitter.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'twitterx',
            'icon'=>  'icons8-twitterx.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'vimeo',
            'icon'=>  'icons8-vimeo.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'vine',
            'icon'=>  'icons8-vine.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'vk',
            'icon'=>  'icons8-vk-circled.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'wechat',
            'icon'=>  'icons8-wechat.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'whatsapp',
            'icon'=>  'icons8-whatsapp.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'youtube',
            'icon'=>  'icons8-youtube.svg',
            'social_categorie_id'=>$Cat1->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'zalo',
            'icon'=>  'icons8-zalo.svg',
            'social_categorie_id'=>$Cat1->id
        ]);

        $Cat2= SocialCategories::create([
            'name'=>'online store',
        ]);

        SocialIcon::create([ 
            'name'=>'aliexpress',
            'icon'=>  'icons8-aliexpress.svg',
            'social_categorie_id'=>$Cat2->id
        ]);

        SocialIcon::create([ 
            'name'=>'amazon',
            'icon'=>  'icons8-amazon.svg',
            'social_categorie_id'=>$Cat2->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'ebay',
            'icon'=>  'icons8-ebay-logo.svg',
            'social_categorie_id'=>$Cat2->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'flipkart',
            'icon'=>  'icons8-flipkart.svg',
            'social_categorie_id'=>$Cat2->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'poshmark',
            'icon'=>  'icons8-poshmark.svg',
            'social_categorie_id'=>$Cat2->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'shopee',
            'icon'=>  'icons8-shopee.svg',
            'social_categorie_id'=>$Cat2->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'shopify',
            'icon'=>  'icons8-shopify.svg',
            'social_categorie_id'=>$Cat2->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'wish',
            'icon'=>  'icons8-wish.svg',
            'social_categorie_id'=>$Cat2->id
        ]);
        
        SocialIcon::create([ 
            'name'=>'wix',
            'icon'=>  'icons8-wix.svg',
            'social_categorie_id'=>$Cat2->id
        ]);

        $Cat3= SocialCategories::create([
            'name'=>'contact',
        ]);

        $Cat4= SocialCategories::create([
            'name'=>'uploaded_icon',
        ]);
        
    }
}
