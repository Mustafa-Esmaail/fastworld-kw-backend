<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;


class BackEndController extends Controller
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->middleware(['permission:read-'   . $this->getClassNameFromModel()])->only('index');
        $this->middleware(['permission:create-' . $this->getClassNameFromModel()])->only('create');
        $this->middleware(['permission:update-' . $this->getClassNameFromModel()])->only('update');
        $this->middleware(['permission:delete-' . $this->getClassNameFromModel()])->only('destroy');
    }

    public function index(Request $request)
    {
       //get all data of Model
       $rows = $this->model;
       $rows = $this->filter($rows,$request);

        // $path = app_path() . "\\Models";
        // $files = scandir($path, 1);
        // $newarray = array();
        // foreach ($files as $file) {
        //     if ($file == "." || $file == ".." || strchr($file, 'Translation')) {
        //     } else {
        //         $file = basename($file, '.php');
        //         $newarray[] = $file;
        //     }
        // }
        // return $newarray;

        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        // return $module_name_plural;
        return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    } //end of index


    public function create(Request $request)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();

        return view('dashboard.' . $this->getClassNameFromModel() . '.create', compact('module_name_singular', 'module_name_plural'))->with($append);
    } //end of create

    public function edit($id)
    {
        $module_name_plural = $this->getClassNameFromModel();
        $module_name_singular = $this->getSingularModelName();
        $append = $this->append();
        $row = $this->model->findOrFail($id);
        return view('dashboard.' . $this->getClassNameFromModel() . '.edit', compact('row', 'module_name_singular', 'module_name_plural'))->with($append);
    } //end of edit

    public function destroy($id, Request $request)
    {
        $this->model->findOrFail($id)->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route($this->getClassNameFromModel() . '.index');
    } //end of destroy function

    protected function filter($rows,$request){

        $rows = $rows->when($request->search , function ($q) use ($request){

            return $q->whereTranslationLike('name' , '%' .$request->search . '%' );

        })->latest()->get();
        return $rows;
    }
    public function getClassNameFromModel()
    {
        return Str::plural($this->getSingularModelName());
    } //end of get class name

    public function getSingularModelName()
    {

        return strtolower(class_basename($this->model));
    } //end of get singular model name

    protected function append()
    {
        return [];
    } //end of append

    protected function uploadImage($image, $path)
    {
        $imageName = $image->hashName();
        Image::make($image)->resize(360, 270)->save(public_path('uploads/' . $path . '/' . $imageName));
        return $imageName;
    }
 protected function uploadImageSlider($image, $path)
    {
        $imageName = $image->hashName();
        Image::make($image)->save(public_path('uploads/' . $path . '/' . $imageName));
        return $imageName;
    }

    //the tow function to delet the comments
    public function deletcomment_and_his_child( $var,$val)
    {
        if ($var=='investor_id')
        {
         $this->child($var,$val);
        }
        if ($var=='referendum_id')
        {
         $this->child($var,$val);
        }
        if ($var=='project_id')
        {
         $this->child($var,$val);
        }
    }

    public function child($x,$y)
    {
        $comments=Comment::where($x,$y)->get();
        if ($comments)
        {
            foreach ($comments as $value)
            {
                $value->likes()->delete();
                $repls=Reply::where('comment_id',$value->id)->get();
                foreach ($repls as  $items)
                {
                    $items->likes()->delete();

                    if($items->files != null)
                    {
                        foreach(json_decode($items->files) as $file){
                            if(file_exists(base_path('public/uploads/replies/') . $file)){
                                unlink(base_path('public/uploads/replies/') . $file );
                            }
                        }
                    }
                    Reply::where('id',$items->id)->delete();
                }
                if($value->files != null)
                {
                    foreach(json_decode($value->files) as $file){
                        if(file_exists(base_path('public/uploads/comments/') . $file)){
                            unlink(base_path('public/uploads/comments/') . $file );
                        }
                    }
                }


                Comment::where('id',$value->id)->delete();
            }

        }
    }



}
