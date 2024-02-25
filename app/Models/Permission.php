<?php

namespace App\Models;

// use Laratrust\Models\Permission as PermissionModel;1
// use Laratrust\Models\LaratrustPermission;2

use Laratrust\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    public $guarded = [];
}
// use Laratrust\Models\LaratrustPermission;

// class Permission extends LaratrustPermission
// {
//     protected $guarded = [];
 
// }