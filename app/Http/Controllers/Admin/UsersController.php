<?php
/**
 * Created by PhpStorm.
 * User: mohammed
 * Date: 3/9/19
 * Time: 1:42 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\ModelHasPermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UsersController
 * @property UserRepositoryInterface $user_repo
 * @package App\Http\Controllers\Admin
 */
class UsersController extends AdminController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user_repo;

    /**
     * UsersController constructor.
     * @param UserRepositoryInterface $user_repo
     */
    public function __construct(UserRepositoryInterface $user_repo)
    {
        parent::__construct();
        $this->user_repo = $user_repo;
        parent::$data['active_menu'] = 'users';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return view('admin.users.view', parent::$data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getList(Request $request)
    {
        $info = $this->user_repo->allDataTable($request->all());
        $count =  $this->user_repo->countDataTable($request->all());
        $dataTable = Datatables::of($info)->setTotalRecords($count);

        $dataTable->editColumn('role_id', function ($row)
        {
            $roles = $row->roles->pluck('name')->toArray();
            return implode(',', $roles);
        });

        $dataTable->editColumn('rate', function ($row)
        {
            $rate = @($row->rate_sum / $row->rate_counter);

            if ($rate === false)
            {
                // Division by zero
            }
            else
            {
                return 'N/A';
            }
        });

        $dataTable->editColumn('status', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['status'] = $row->status;

            return view('admin.users.parts.status', $data)->render();
        });

        $dataTable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;

            return view('admin.users.parts.actions', $data)->render();
        });
        $dataTable->escapeColumns(['*']);
        return $dataTable->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd()
    {
        parent::$data['roles'] = Role::all();
        return view('admin.users.add', parent::$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request)
    {
        $data = [
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'password_confirmation' => $request->get('password_confirmation'),
            'status' => $request->get('status')
        ];
        $validator = Validator::make($data,[
            'username' => 'required|unique:users,username,0,id,deleted_at,NULL',
            'name' => 'required|min:3,max:100',
            'email' => 'required|unique:users,email,0,id,deleted_at,NULL',
//            'roles' => 'required',
            'password' => 'required|between:6,16|confirmed',
            'password_confirmation' => 'required|between:6,16',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }
        ///////////////////
        $add = $this->user_repo->store($request->all());
        if (!$add)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        $add->syncRoles($request->get('roles'));
        /////////////////////////////////////
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.added'),$add);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $info = $this->user_repo->get($id);
        if (!$info || $id == 1)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('users.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['roles'] = Role::all();
        return view('admin.users.edit', parent::$data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $info = $this->user_repo->get($id);
        if (!$info || $id == 1)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('users.view'));
        }

        $data = [
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role_id' => $request->get('role_id'),
            'online_status' => $request->get('online_status'),
            'status' => $request->get('status'),
        ];

        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users,username,' . $id . ',id,deleted_at,NULL',
            'name' => 'required|min:3,max:100',
            'email' => 'required|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'role_id' => 'required|numeric|in:1,2',
            'online_status' => 'required|numeric|in:1,2',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }
        $update = $this->user_repo->update($id, $data);
        if (!$update)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        $info->syncRoles($request->get('role_id'));
        Cache::forget('spatie.permission.cache');
        //////////////////////////////////////////////
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),$update);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getPassword(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $info = $this->user_repo->get($id);
        if (!$info || $id == 1)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('users.view'));
        }
        parent::$data['info'] = $info;
        return view('admin.users.password', parent::$data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postPassword(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $info = $this->user_repo->get($id);
        if (!$info || $id == 1)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('users.view'));
        }

        $data = [
            'password' => $request->get('password')
        ];

        $validator = Validator::make($request->all(), [
            'password' => 'required|between:6,16|confirmed',
            'password_confirmation' => 'required|between:6,16'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }

        $update = $this->user_repo->update($id, $data);
        if (!$update)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.changed'),$update);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDelete($id)
    {
        $id = $this->decrypt($id);
        ///////////////////
        $info = $this->user_repo->get($id);
        if (!$info || $id == 1)
        {
            return $this->generalResponse('false',300, trans('title.info'), trans('messages.not_found'),null);
        }
        $delete = $this->user_repo->delete($id);
        if (!$delete)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.deleted'),null);
    }
    /////////////////////////////////////////
    public function getPermissions(Request $request, $id)
    {
        if ($id == 1)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('users.view'));
        }
        /////////////////////////////////////////
        $info = User::find($id);
        if(!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('users.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['permissions'] = Permission::with('children')->where('parent_id', 0)->get();
        parent::$data['role_permissions'] = ModelHasPermission::where('model_id', $id)->get()->toArray();
        return view('admin.users.permissions', parent::$data);
    }
    public function postPermissions(Request $request, $id)
    {
        $user = User::find($id);
        $permissions = $request->get('permissions');
        if(is_array($permissions) && sizeof($permissions) > 0)
        {
            ModelHasPermission::where('model_id', $id)->delete();

            foreach ($permissions as $permission)
            {
                $user->givePermissionTo($permission);

            }
            Cache::forget('spatie.permission.cache');
            /////////////////////////////////////////
            return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),null);
        }
        else
        {
            ModelHasPermission::where('model_id', $id)->delete();
            /////////////////////////////////////////
            Cache::forget('spatie.permission.cache');
            /////////////////////////////////////////
            return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),null);
        }

    }
}
