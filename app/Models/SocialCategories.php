<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialCategories extends Model
{
    use HasFactory;
    protected $table = 'social_categories';
    protected $guarded = [];
    public function SocialIcons()
    {
     return  $this->hasMany(SocialIcon::class,'social_categorie_id');
    }
}
