<?php
namespace App\Http\Controllers\Api\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VarificationIcon;
use App\Http\Resources\VarificationIconResource;
class VarificationIconController extends Controller
{
    protected $model;
    //protected $owner;
    public function __construct(VarificationIcon $model)
    {
        //$this->owner=auth('owner')->user();
        $this->model=$model;
    }
    public function getVarificationIcons()
    {
        $VarificationIcons=$this->model->get();
        return response()->json([
            'status'=>true,
            'Varification-Icon'=>VarificationIconResource::collection($VarificationIcons)->response()->getData(true)
        ],200); 
    }
}
