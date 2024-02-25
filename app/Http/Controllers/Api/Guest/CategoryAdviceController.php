<?php
namespace App\Http\Controllers\Api\Guest;
use Illuminate\Http\Request;
use App\Models\Category_Advice;
use App\Models\Advice;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Category_AdviceResources;
use App\Http\Controllers\Controller;

class CategoryAdviceController extends Controller
{
    public function get_all_Category(){
        $Categories=Category_Advice::all();
       // return 555;

       return response()->json([
           'status'  => true,
           'Categories' => Category_AdviceResources::collection($Categories),
       ], 200);

   }
   public function get_Category(Request $request){
       $validator = Validator::make($request->all(), [
           'id' => 'required|exists:category__advice,id',
       ]);

       if($validator->fails()){
           return response()->json([
               "status" => false,
               'errors'=> $validator->errors(),
           ], 402);
       }
       $Category=Category_Advice::find($request->id);
       return response()->json([
           'status'  => true,
           'Category' => new Category_AdviceResources($Category),
       ], 200);

   }
}
