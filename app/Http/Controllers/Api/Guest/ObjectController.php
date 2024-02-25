<?php


namespace App\Http\Controllers\Api\Guest;
use App\Http\Resources\objectResources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Obj;

class ObjectController extends Controller
{
    public function store(Request $request){

        
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|unique:advices|max:100',
        //     'category_id'=> 'required|exists:category__advice,id',
        //     'url' => 'required|url',
        // ]);

        // if($validator->fails()){
        //     return response()->json([
        //         "status" => false,
        //         'errors'=> $validator->errors(),
        //     ], 402);
        // }
      
        $Obj=Obj::create([
            'name'    =>  $request->name,
            'colors'    =>  $request->colors,
            'FontFace'  =>  $request->FontFace,
            'object'    =>  $request->object,
            'borderStyle'      =>  $request->borderStyle,
            'outlineStyle'     =>  $request->outlineStyle,
            'profileAlginment' =>  $request->profileAlginment,
            'socialAlginment'  =>  $request->socialAlginment,
        ]);

        return response()->json([
            'status'  => true,
            'Obj' => new objectResources($Obj),
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
