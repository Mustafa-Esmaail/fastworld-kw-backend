<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Advice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'category__advice';
    public function Advices()
    {
     return  $this->hasMany(Advice::class,'category_id');
    }
}
