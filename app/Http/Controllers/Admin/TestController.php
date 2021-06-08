<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends  Controller
{
    public function getIndex()
    {
//        $permissionNames = auth()->user()->getPermissionNames();
        $user = auth()->user();
        $data = $user->permissions;
        $roles = $user->getRoleNames();
//        $role = Role::create(['name' => 'writer']);
        dd($roles);
    }
}
