<?php

namespace App\Http\Controllers\Api\Guest;
use Illuminate\Http\Request;
use App\Models\Advice;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdviceResources;
use App\Http\Controllers\Controller;

class AdviceController extends Controller
{
    public function store_Advice(Request $request){

        
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:advices|max:100',
            'category_id'=> 'required|exists:category__advice,id',
            'url' => 'required|url',
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        }
        $Advice=Advice::create([
            'title'         =>  $request->title,
            'url'          =>  $request->url,
            'category_id'          =>  $request->category_id,
        ]);

        return response()->json([
            'status'  => true,
            'Advice' => new AdviceResources($Advice),
        ], 200);

    }
    public function get_all_Advice(){
         $Advices=Advice::all();
        // return 555;

        return response()->json([
            'status'  => true,
            'Advices' => AdviceResources::collection($Advices),
        ], 200);

    }
    public function get_Advice(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:advices,id',
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        }
        $Advice=Advice::find($request->id);
        return response()->json([
            'status'  => true,
            'Advice' => new AdviceResources($Advice),
        ], 200);

    }
}
