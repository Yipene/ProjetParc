<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function AllPermission()
    {
        $permissions = Permission::all();

        return view('admin/backend/permission/permission', compact('permissions') );
    }
}
