<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends BackEndController
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //get all data of Model
      $rows = $this->model->when($request->search,function($query) use ($request){
        $query->where('name','like','%' .$request->search . '%')
        ->orWhere('description', 'like','%' . $request->search . '%');

    });
    $rows = $this->filter($rows,$request);
     $module_name_plural = $this->getClassNameFromModel();
     $module_name_singular = $this->getSingularModelName();
     // return $module_name_plural;
     return view('dashboard.' . $module_name_plural . '.index', compact('rows', 'module_name_singular', 'module_name_plural'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'                 => 'required|min:2|string|unique:roles,name',
            'description'          => 'nullable|min:2|string',
        ]);
        if($request->permissions == null)
        {
            session()->flash('error',_('site.add_permission_please'));
            return redirect()->route('dashboard.roles.create');
        }
        $newRole = new Role();

        $newRole->name         =  $request->name;
        $newRole->display_name = ucfirst($request->name);
        $newRole->description  =  $request->description;
        $newRole->save();
        $newRole->attachPermissions($request->permissions);

        session()->flash('success', __('site.add_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');
    }

    public function update(Request $request, $id)
    {
        $updateRole = $this->model->findOrFail($id);
        $request->validate([
            'name'                 => ['required','min:2|string',Rule::unique('roles','name')->ignore($id)],
            'description'          => 'nullable|min:2|string',
        ]);
        if($request->permissions == null)
        {
            session()->flash('error',_('site.add_permission_please'));
            $module_name_plural = $this->getClassNameFromModel();
            $module_name_singular = $this->getSingularModelName();
            $row=$updateRole;
            return view('dashboard.' . $this->getClassNameFromModel() . '.edit', compact('row', 'module_name_singular', 'module_name_plural'));
        }
        $updateRole->name         =  $request->name;
        $updateRole->display_name = ucfirst($request->name);
        $updateRole->description  =  $request->description;
        $updateRole->save();

        $updateRole->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfuly'));
        return redirect()->route('dashboard.' . $this->getClassNameFromModel() . '.index');
    }
    public function destroy($id,Request $request)
    {
        $role=Role::findOrFail($id);
        $role->delete();
        session()->flash('success',__('site.deleted_successfuly'));
        return redirect()->route('dashboard.'.$this->getClassNameFromModel().'.index');


    }
}
