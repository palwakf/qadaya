<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionsGroup;
use App\Models\RoleHasPermissions;
use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class RolesController
 * @property RoleRepositoryInterface $role_repo
 * @package App\Http\Controllers\Admin
 */
class RolesController extends AdminController
{
    /**
     * UsersController constructor.
     * @param RoleRepositoryInterface $role_repo
     */
    public function __construct(RoleRepositoryInterface $role_repo)
    {
        parent::__construct();
        $this->role_repo = $role_repo;
        parent::$data['active_menu'] = 'roles';
    }
    /////////////////////////////////////////
    public function getIndex()
    {
        return view('admin.roles.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $role = new Role();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $role->getRoles($name);

        $datatable = Datatables::of($info);


        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;
            $data['btn_red'] = parent::$data['btn_red'];
            $data['btn_green'] = parent::$data['btn_green'];

            return view('admin.roles.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id'] = $row->id;
            $data['id_hash'] = $row->id;//Crypt::encrypt($row->id_hash);
            $data['btn_class'] = parent::$data['btn_class'];
            $data['btn_red'] = parent::$data['btn_red'];
            $data['btn_green'] = parent::$data['btn_green'];

            return view('admin.roles.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    /////////////////////////////////////////
    public function getAdd()
    {
        return view('admin.roles.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $status = (int)$request->get('status');

        $data = [
            'name' => $name,
            'status' => $status
        ];

        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:60|unique:roles,name',
            'status' => 'required|numeric|in:0,1'
        ]);
        /////////////////////////////////////
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }
        //////////////////////////////////////
//        $role = new Role();
//        $add = $role->addRole($name, $status);
        $add = $this->role_repo->store($data);
        if (!$add)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
//        Cache::forget('spatie.permission.cache');
        //////////////////////////////////////////
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.added'),$add);
    }
    /////////////////////////////////////////
    public function getEdit(Request $request, $id)
    {
//        try
//        {
//            $id = Crypt::decrypt($id);
//        }
//        catch (DecryptException $e)
//        {
//            $request->session()->flash('danger', self::NOT_FOUND_MESSAGE);
//            return redirect(route('roles.view'));
//        }
        if ($id == 1)
        {
            $request->session()->flash('danger', self::NOT_FOUND_MESSAGE);
            return redirect(route('roles.view'));
        }
        /////////////////////////////
        $role = new Role();
        $info = $role->getRole($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('users.view'));
        }
        parent::$data['info'] = $info;
        return view('admin.roles.edit', parent::$data);
    }
    /////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
//        try
//        {
//            $encrypted_id = $id;
//            $id = Crypt::decrypt($id);
//        }
//        catch (DecryptException $e)
//        {
//            $request->session()->flash('danger', self::NOT_FOUND_MESSAGE);
//            return redirect(route('roles.view'));
//        }
        if ($id == 1)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
        }
        /////////////////////////////////////////
        $role = new Role();
        $info = $role->getRole($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('roles.view'));
        }
        $name = $request->get('name');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'status' => $status
        ], [
            'name' => 'required|min:3|max:60|unique:roles,name,' . $id,
            'status' => 'required|numeric|in:0,1'
        ]);
        //////////////////////////////////////
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }
        $update = $role->updateRole($info, $name, $status);
        if (!$update)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
//        Cache::forget('spatie.permission.cache');
        //////////////////////////////////////////
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),$update);
    }
    /////////////////////////////////////////
    public function getPermissions(Request $request, $id)
    {
//        try
//        {
//            $id = Crypt::decrypt($id);
//        }
//        catch (DecryptException $e)
//        {
//            return response()->json(['status' => 'error', 'message' => 'Sorry, an error occurred during execution']);
//        }
        if ($id == 1)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('roles.view'));
        }
        /////////////////////////////////////////
        $roles = new Role();
        $info = $roles->getRole($id);
        if(!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('roles.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['permissions'] = Permission::with('children')->where('parent_id', 0)->get();
        parent::$data['role_permissions'] = RoleHasPermissions::where('role_id', $id)->get()->toArray();
        return view('admin.roles.permissions', parent::$data);
    }
    /////////////////////////////////////////
    public function postPermissions(Request $request, $id)
    {
//        try
//        {
//            $id = Crypt::decrypt($id);
//        }
//        catch (DecryptException $e)
//        {
//            return response()->json(['status' => 'error', 'message' => 'Sorry, an error occurred during execution']);
//        }
        $permissions = $request->get('permissions');
        if(is_array($permissions) && sizeof($permissions) > 0)
        {
            $role_has_permissions = new RoleHasPermissions();
            $role_has_permissions->deleteRoleHasPermissionsByRoleId($id);

            foreach ($permissions as $permission_id)
            {
                $role_has_permissions = new RoleHasPermissions();
                $role_has_permissions->addRoleHasPermissions($permission_id,$id);

            }
            Cache::forget('spatie.permission.cache');
            /////////////////////////////////////////
            return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),null);
        }
        else
        {
            $role_has_permissions = new RoleHasPermissions();
            $role_has_permissions->deleteRoleHasPermissionsByRoleId($id);
            /////////////////////////////////////////
            Cache::forget('spatie.permission.cache');
            /////////////////////////////////////////
            return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),null);
        }

    }
    /////////////////////////////////////////
    public function postStatus(Request $request)
    {
        $id = $request->get('id');
        try
        {
            $id = Crypt::decrypt($id);
        }
        catch (DecryptException $e)
        {
            return response()->json(['status' => 'error', 'message' => 'Sorry, an error occurred during execution']);
        }
        //////////////////////////////
        if ($id == 1)
        {
            $request->session()->flash('danger', self::NOT_FOUND_MESSAGE);
            return response()->json(['status' => 'error', 'message' => 'Sorry, an error has occurred - Data can not be found']);
        }
        /////////////////////////////////////////
        $roles = new Role();
        $info = $roles->getRole($id);
        if (!$info)
        {
            $request->session()->flash('danger', self::NOT_FOUND_MESSAGE);
        }
        $status = $info->status;
        if($status == 0)
        {
            $delete = $roles->updateStatus($id,1);
            if(!$delete)
            {
                return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR_MESSAGE]);
            }
            return response()->json(['status' => 'success', 'message' => self::ACTIVATION_SUCCESS_MESSAGE, 'type' => 'yes']);
        }
        $delete = $roles->updateStatus($id,0);
        if(!$delete)
        {
            return response()->json(['status' => 'error', 'message' => self::EXECUTION_ERROR_MESSAGE]);
        }
        Cache::forget('spatie.permission.cache');
        //////////////////////////////////////////
        return response()->json(['status' => 'success', 'message' => self::DISABLE_SUCCESS_MESSAGE, 'type' => 'no']);
    }
    /////////////////////////////////////////
    public function getDelete(Request $request, $id)
    {
//        $id = $request->get('id');
//        try
//        {
//            $id = Crypt::decrypt($id);
//        }
//        catch (DecryptException $e)
//        {
//            return response()->json(['status' => 'error', 'message' => 'Sorry, an error occurred during execution']);
//        }
        //////////////////////////////
        if ($id == 1)
        {
            $request->session()->flash('danger', self::NOT_FOUND_MESSAGE);
            return response()->json(['status' => 'error', 'message' => 'Sorry, an error has occurred - Data can not be found']);
        }
        ///////////////////////////////
        $roles = new Role();
        $info = $roles->getRole($id);
        if (!$info)
        {
            return $this->generalResponse('false',300, trans('title.info'), trans('messages.not_found'),null);
        }
        $delete = $roles->deleteRole($info);
        if (!$delete)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.deleted'),null);
    }
}
