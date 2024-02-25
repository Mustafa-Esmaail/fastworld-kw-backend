<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\objectResources;
use App\Models\Obj;
use App\Models\Link;
use App\Http\Traits\CustomTrait;

class InformationResources extends JsonResource
{
    use CustomTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [

            'id'                => $this->id,
            'created_at'            =>$this->created_at,
            'source'            => $this->source,
            // 'domain'         => $this->id,
            // 'link'              => new LinkCustomResources($this->Link),
            'substate'          => $this->substate,
            'dnstate'           => $this->dnstate,
            'suffix'            => $this->suffix,
            'title'             => $this->title,
            // 'themeid'        => $this->themeid,
            // 'path'           => $this->path,
            // 'part'           => $this->part,
            'description'       => $this->description,
            'theme'             => $this->theme,
            'verified'          => $this->verified,
            // 'uid'            => $this->uid,
            'discover_state'    => $this->discover_state,
            'state'             => $this->state,
            'version_state'     => $this->version_state,
            'image'             => $this->cover_path, 
            'background_image'  => $this->background_image_path, 
            //'background_image'  => $this->backgroundimage_Path,
            'object'              =>new objectResources(Obj::where('information_id',$this->id)->first()),

            'design_id'  => $this->design_id,
            'owner_id'  => $this->owner_id,
            'remove_brand'  => $this->owner->Profile_setting !=null ? $this->owner->Profile_setting->remove_brand: 0 ,
            'Contents'  => ContentResources::collection($this->Contents),
            'orders'  => self::getorders($this->Contents()->orderBy('created_at', 'ASC')->get()),
            
            
            
            // 'title'                    =>  $this->title,
            // 'second_title'             =>  $this->second_title,
            // 'description'              =>  $this->description,
            // 'image'                    =>  $this->image_path,
            // 'backgroundimage'          =>  $this->backgroundimage_Path,

            // 'socials'	               => $this->socials,

            // 'facebook'                 =>  $this->facebook,
            // 'youtube'                  =>  $this->youtube,
            // 'instgram'                 =>  $this->instgram,
            // 'x'                        =>  $this->x,
            // 'tiktok'                   =>  $this->tiktok,
            // 'gmail'                    =>  $this->gmail,

            // 'our_store'                =>  $this->our_store,
            // 'monicur_store'            =>  $this->monicur_store,
            // 'online_shop'              =>  $this->online_shop,
            // 'online_store'             =>  $this->online_store,
            // 'shop'                     =>  $this->shop,
            // 'shopee'                   =>  $this->shopee,
            // 'shop_products'            => $this->shop_products,
            // 'shop_new'                 =>  $this->shop_new,

            // 'website'                  =>  $this->website,
            // 'video'                    =>  $this->video_path,
            // 'videos_title'             =>  $this->videos_title,
            // 'videos_description'       =>  $this->videos_description,

            // 'services'                 =>  $this->services,
            // 'our_services'             =>  $this->our_services,

            // 'about_studio'             =>  $this->about_studio,
            // 'about_the_farm'           =>  $this->about_the_farm,
            // 'about_us'                 =>  $this->about_us,
            // 'about_me'                 =>  $this->about_me,
            // 'about'                    =>  $this->about,

            // 'contact_us'               =>  $this->contact_us,
            // 'contact'                  =>  $this->contact,

            // 'plans_and_pricing'        =>  $this->plans_and_pricing,
            // 'plans'                    =>  $this->plans,

            // 'book_online'              =>  $this->book_online,
            // 'book_aclass'              =>  $this->book_aclass,

            // 'activities'               =>  $this->activities,

            // 'facilities'               =>  $this->facilities,
            // 'treatments'               =>   $this->treatments,
            // 'specials'                 =>  $this->specials,
            // 'challenges'               =>  $this->challenges,
            // 'new_inventory'            =>  $this->new_inventory,
            // 'per_owned'                =>  $this->per_owned,
            // 'financing'                =>  $this->financing,
            // 'testimonials'             =>  $this->testimonials,
            // 'faq'                      =>  $this->faq,
            // 'workpalces'               =>  $this->workpalces,
            // 'models'                   =>  $this->models,
            // 'info'                     =>  $this->info,
            // 'album'                    =>  $this->album,
            // 'vlog'                     =>  $this->vlog,
            // 'location'                 =>  $this->location,
            // 'phone'                    =>  $this->phone,
            // 'our_member'               =>  $this->our_member,
            // 'sale_up_to_value'         =>  $this->sale_up_to_value,
            // 'buy_one_get_one_free'     =>  $this->buy_one_get_one_free,
            // 'get_discount'             =>  $this->get_discount,
            // 'items'                    =>  $this->items,
            // 'contest'                  =>  $this->contest,
            // 'follow_me'                =>  $this->follow_me,
            // 'jouney'                   =>  $this->jouney,
            // 'strength'                 =>  $this->strength,
            // 'bukalapak'                =>  $this->bukalapak,
            // 'lazada'                   =>  $this->lazada,
            // 'say_hello'                =>  $this->say_hello,
            // 'training'                 =>  $this->training,
            // 'why_naturopathy'          =>  $this->why_naturopathy,
            // 'riders'                   =>  $this->riders,
            // 'tokyo'                    =>  $this->tokyo,
            // 'spotify'                  =>  $this->spotify,
            // 'soundcloud'               =>  $this->soundcloud,
            // 'vibe'                     =>  $this->vibe,
            // 'apple_music'              =>  $this->apple_music,
            // 'tickets'                  =>  $this->tickets,
            // 'epk'                      =>  $this->epk,
            // 'tour'                     =>  $this->tour,
            // 'media'                    =>  $this->media,
            // 'seoul'                    =>  $this->seoul,
            // 'buy_me_ticket'            =>  $this->buy_me_ticket,
            // 'deezer'                   =>  $this->deezer,
            // 'bandcamp'                 =>  $this->bandcamp,
            // 'audiomack'                =>  $this->audiomack,
            // 'collection'               =>  $this->collection,

            // 'introduction'             =>  $this->introduction,

            // 'photographer'             =>  $this->photographer,
            // 'our_team'                 =>  $this->our_team,
            // 'menu'                     =>  $this->menu,
            // 'order'                    =>  $this->order,
            // 'rate_us'                  =>  $this->rate_us,
            // 'store_address'            =>  $this->store_address,
            // 'relax'                    =>  $this->relax,
            // 'pinterest'                =>  $this->pinterest,
            // 'skype'                    =>  $this->skype,
            // 'travel_vlog'              =>  $this->travel_vlog,
            // 'homestay'                 =>  $this->homestay,
            // 'traveling'                =>  $this->traveling,
            // 'google_map'               =>  $this->google_map,
            // 'travel_resources'         =>  $this->travel_resources,

            // 'portfolio'                =>  $this->portfolio,
            // 'style'                    =>  $this->style,
            // 'discount'                 =>  $this->discount,
            // 'show'                     =>  $this->show,
            // 'band'                     =>  $this->band,
            // 'summer_band'              =>  $this->summer_band,
            // 'socials_description'      =>  $this->socials_description,
            // 'blog'                     =>  $this->blog,

            // 'full_name'                =>  $this->full_name,
            // 'email'                    =>  $this->email,
            // 'title_of_send_email'      =>  $this->title_of_send_email,
            // 'footer_of_send_email'     =>  $this->footer_of_send_email,
            // 'follower_and_style_list'  =>  $this->follower_and_style_list,
            // // 'design_id'           => $this->design_id,
            // 'owner_id'            =>$this->owner_id,
            // // 'Design'              =>new DesignResources($this->Design),
            // 'object'              =>new objectResources(Obj::where('information_id',$this->id)->first()),
            // // 'link'              =>new LinkResources(Link::where('information_id',$this->id)->first())
        ];

       
    }
}
