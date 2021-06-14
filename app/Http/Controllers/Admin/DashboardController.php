<?php

namespace App\Http\Controllers\Admin;

use App\Models\Court;
use App\Models\Lawsuit;
use App\Models\Role;
use App\Models\Type;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class DashboardController
 * @property UserRepositoryInterface $user_repo
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends AdminController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user_repo;

    /**
     * DashboardController constructor.
     * @param UserRepositoryInterface $user_repo
     */
    public function __construct(UserRepositoryInterface $user_repo)
    {
        parent::__construct();
        $this->user_repo = $user_repo;
        self::$data['active_menu'] = 'dashboard';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        /* Statistics */
        self::$data['roles'] = Role::count();
        self::$data['users'] = User::where('status',1)->count();
        self::$data['courts'] = Court::count();
        self::$data['types'] = Type::count();
        self::$data['all_lawsuits'] = $all = Lawsuit::whereNull('parent_id')->count();
        self::$data['active_lawsuits'] = $active = Lawsuit::whereNull('parent_id')->where('is_archived',0)->count();
        self::$data['archived_lawsuits'] = $archived = Lawsuit::whereNull('parent_id')->where('is_archived',1)->count();
        self::$data['active_lawsuits_percentage'] = ($all == 0) ? 0 : ($active/ $all) * 100;
        self::$data['archived_lawsuits_percentage'] = ($all == 0) ? 0 : ($archived/ $all) * 100;

        $tribunals = Court::all();
        foreach ($tribunals as $court){
            $court_labels[] = $court->name;
            $court_lawsuits[] = Lawsuit::where('user_id',$court->id)->distinct('lawsuit_number')->count();
        }
        self::$data['court_labels'] = $court_labels;
        self::$data['court_lawsuits'] = $court_lawsuits ;

        $lawyers= $items= [] ;
        $lawyers_users = User::all();
        foreach ($lawyers_users as $lawyer ){
            $lawyer_name = $lawyer->name ;
            $count = Lawsuit::where('user_id',$lawyer->id)->distinct('lawsuit_number')->count() ;
            array_push($lawyers,['name'=>$lawyer_name , 'count'=>$count]);
        }
        self::$data['lawyers'] = $lawyers ;


        $kinds = Type::all();
        foreach ($kinds as $kind){
            $kind_name = $kind->name ;
            $count2 = Lawsuit::where('type_id',$kind->id)->distinct('lawsuit_number')->count() ;
            array_push($items,['name'=>$kind_name , 'count'=>$count2]);
        }
        self::$data['items'] = $items ;
        //dd($lawyers);
        //dd(self::$data );
        return view('admin.dashboard.view', self::$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile()
    {
        $id = Auth::guard('admin')->user()->id;
        parent::$data['info'] = $this->user_repo->get($id);
        return view('admin.dashboard.profile', self::$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postProfile(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ];

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3,max:100',
            'email' => 'required|unique:users,email,' . $id . ',id,deleted_at,NULL',
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
        //////////////////////////////////////////////
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),$update);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPassword()
    {
        $id = Auth::guard('admin')->user()->id;

        parent::$data['info'] = $this->user_repo->get($id);
        return view('admin.dashboard.password', self::$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPassword(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('dashboard.view'));
    }
}
