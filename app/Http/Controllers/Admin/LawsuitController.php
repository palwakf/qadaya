<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Type;
use App\Models\User;
use App\Repositories\Interfaces\LawsuitRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class LawsuitsController
 * @property LawsuitRepositoryInterface $lawsuit_repo
 * @package App\Http\Controllers\Admin
 */

class LawsuitController extends AdminController
{
    /**
     * LawsuitController constructor.
     * @param LawsuitRepositoryInterface $lawsuit_repo
     */
    public function __construct(LawsuitRepositoryInterface $lawsuit_repo)
    {
        parent::__construct();
        $this->lawsuit_repo = $lawsuit_repo;
        parent::$data['active_menu'] = 'lawsuits';
    }
    /////////////////////////////////////////
    public function getIndex()
    {
        parent::$data['types'] = Type::all();
        parent::$data['courts'] = Court::all();
        return view('admin.lawsuits.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {

        if(auth()->user()->hasRole('Admin')){
            $info = $this->lawsuit_repo->allDataTable('admin',$request->all());
            $count =  $this->lawsuit_repo->countDataTable('admin',$request->all());
        }
        else{
            $info = $this->lawsuit_repo->allDataTable('employee',$request->all());
            $count =  $this->lawsuit_repo->countDataTable('admin',$request->all());
        }

        $datatable = Datatables::of($info)->setTotalRecords($count);
        $datatable->editColumn('status', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['status'] = $row->is_archived;
            return view('admin.lawsuits.parts.status', $data)->render();
        });
        $datatable->addColumn('actions', function ($row)
        {
            $data['id'] = $row->id;
            $data['id_hash'] = $row->id;//Crypt::encrypt($row->id_hash);
            $data['btn_class'] = parent::$data['btn_class'];
            $data['btn_red'] = parent::$data['btn_red'];
            $data['btn_green'] = parent::$data['btn_green'];

            $data['archive_btn_title'] = ($row->is_archived == 0) ? 'أرشفة' : 'استعادة';
            $data['archive_btn_icon']  = ($row->is_archived == 0) ? 'fa-archive' : 'fa-reply';
            return view('admin.lawsuits.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    /////////////////////////////////////////
    public function getAdd($parent_id = null)
    {
        parent::$data['types'] = Type::all();
        parent::$data['courts'] = Court::all();
        parent::$data['employees'] = User::all();

        if(! is_null($parent_id)){
            $info = $this->lawsuit_repo->get($parent_id);
            parent::$data['info'] = $info;
        }
        $view = (is_null($parent_id) ? 'admin.lawsuits.add' : 'admin.lawsuits.logs.add');
        return view($view, parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        if($request->has('parent_id')){
            $info = $this->lawsuit_repo->get($request->get('parent_id'));
            if (!$info)
            {
                return $this->generalResponse('false',300, trans('title.info'), trans('messages.not_found'),null);
            }
        }

        $lawsuit_number = $request->get('lawsuit_number');
        $claimant = $request->get('claimant');
        $defendant = $request->get('defendant');
        $type_id = (int)$request->get('type_id',1);
        $court_id= (int)$request->get('court_id',1);
        $user_id = (int)$request->get('user_id',auth()->id());
        $deposit_date = $request->get('deposit_date');
        $deposit_value = $request->get('deposit_value');
        $deposit_currency = $request->get('deposit_currency',null);
        $details = $request->get('details');
        $parent_id = $request->get('parent_id',null);

        $data = [
            'lawsuit_number' => $lawsuit_number,
            'claimant' => $claimant ,
            'defendant' => $defendant ,
            'type_id' => $type_id ,
            'court_id' => $court_id ,
            'user_id' => $user_id ,
            'deposit_date' => $deposit_date ,
            'deposit_value' => $deposit_value ,
            'deposit_currency' => $deposit_currency ,
            'details' => $details ,
            'parent_id' => $parent_id ,
        ];

        $validator = Validator::make($data, [
            'lawsuit_number' => 'required',
            'claimant' => 'required|min:3|max:60',
            'defendant' => 'required|min:3|max:60',
            'type_id' => 'required|exists:types,id',
            'court_id' => 'required|exists:courts,id',
            'user_id' => 'required|exists:users,id',
            'deposit_date' => 'nullable|date',
            'deposit_value' => 'nullable|numeric',
            'deposit_currency' => 'nullable|in:jod,usd,ils',
            'details' => 'nullable'

        ],
            // custom error messages
            [
                'lawsuit_number.required' => 'يجب ادخال رقم الدعوى القانونية',
                'lawsuit_number.unique' => 'رقم الدعوى موجود مسبقاً',
                'claimant.required' => 'يجب ادخال اسم المدعي',
                'claimant.min' => 'اسم المدعي على الأقل 3 حروف',
                'claimant.max' => 'اسم المدعي على الأكثر 60 حرف',
                'defendant.required' => 'يجب ادخال اسم المدعى عليه',
                'defendant.min' => 'اسم المدعى عليه على الأقل 3 حروف',
                'defendant.max' => 'اسم المدعى عليه على الأكثر 60 حرف',
                'type_id.required' => 'يجب اختيار نوع الدعوة',
                'court_id.required' => 'يجب اختيار المحكمة',
                'user_id.required' => 'يجب اختيار الموظف المسؤول عن الدعوة',
                'deposit_date.date' => 'يجب اختيار تاريخ صالح للايداع',
                'deposit_value.numeric' => 'يجب أن تكون قيمة الايداع قيمة عددية صالحة',
                'deposit_currency.in' => 'العملة يجب أن تكون احدى العملات التالية : دولار أمريكي ، دينار أردني ، شيكل',
            ]
        );

        /////////////////////////////////////
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }
        //////////////////////////////////////

        $add = $this->lawsuit_repo->store($data);

        if (!$add)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        $redirect = ($request->get('parent_id')) ? route('lawsuits.logs',$parent_id) : route('lawsuits.view') ;

        //////////////////////////////////////////
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.added'),$add,$redirect);
    }
    /////////////////////////////////////////
    public function getEdit(Request $request, $id)
    {
        $info = $this->lawsuit_repo->get($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('lawsuits.view'));
        }
        if($info->is_archived){
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.lawsuit_archived')]);
            return redirect(route('lawsuits.view'));
        }
//        $logs = $info->childrens->count();
//        if ($logs > 1)
//        {
//            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.lawsuit_not_editable')]);
//            return redirect(route('lawsuits.view'));
//        }

        parent::$data['info'] = $info;
        parent::$data['types'] = Type::all();
        parent::$data['courts'] = Court::all();
        parent::$data['employees'] = User::all();

        $view = (is_null($info->parent_id) ? 'admin.lawsuits.edit' : 'admin.lawsuits.logs.edit');
        return view($view, parent::$data);
    }
    /////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $info = $this->lawsuit_repo->get($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('lawsuits.view'));
        }

        $lawsuit_number = $request->get('lawsuit_number');
        $claimant = $request->get('claimant');
        $defendant = $request->get('defendant');
        $type_id = (int)$request->get('type_id',1);
        $court_id= (int)$request->get('court_id',1);
        $user_id = (int)$request->get('user_id',auth()->id());
        $deposit_date = $request->get('deposit_date');
        $deposit_value = $request->get('deposit_value');
        $deposit_currency = $request->get('deposit_currency',null);
        $details = $request->get('details');

        $data = [
            'lawsuit_number' => $lawsuit_number ,
            'claimant' => $claimant ,
            'defendant' => $defendant ,
            'type_id' => $type_id ,
            'court_id' => $court_id ,
            'user_id' => $user_id ,
            'deposit_date' => $deposit_date ,
            'deposit_value' => $deposit_value ,
            'deposit_currency' => $deposit_currency ,
            'details' => $details ,
        ];

        $validator = Validator::make($data, [
           // 'lawsuit_number' => 'required|unique:lawsuits,lawsuit_number,'.$id ,
            'claimant' => 'required|min:3|max:60',
            'defendant' => 'required|min:3|max:60',
            'type_id' => 'required|exists:types,id',
            'court_id' => 'required|exists:courts,id',
            'user_id' => 'required|exists:users,id',
            'deposit_date' => 'nullable|date',
            'deposit_value' => 'nullable|numeric',
            'deposit_currency' => 'nullable|in:jod,usd,ils',
            'details' => 'nullable'
        ]);
        //////////////////////////////////////
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }


        $update = $this->lawsuit_repo->update($id , $data);

        if (! $update )
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        $redirect = (! is_null($info->parent_id)) ? route('lawsuits.logs',$info->parent_id) : route('lawsuits.view') ;

        //////////////////////////////////////////
        return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),$update,$redirect);
    }
    /////////////////////////////////////////
    public function getDelete(Request $request, $id)
    {
        $info = $this->lawsuit_repo->get($id);
        if (!$info)
        {
            return $this->generalResponse('false',300, trans('title.info'), trans('messages.not_found'),null);
        }
        $delete = $this->lawsuit_repo->delete($id);
        if (!$delete)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }

        $redirect = (! is_null($info->parent_id)) ? route('lawsuits.logs',$info->parent_id) : route('lawsuits.view') ;

        return $this->generalResponse('true',200, trans('title.success'), trans('messages.deleted'),null , $redirect);

    }
    /////////////////////////////////////////
    public function getArchive(Request $request, $id)
    {
        $info = $this->lawsuit_repo->get($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('dashboard.view'));
        }
        $status = ($info->is_archived == 0) ? 1 : 0 ;
        $archive = $this->lawsuit_repo->archive($id , $status );
        if (!$archive)
        {
            return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
        }
        $msg = ($info->is_archived == 1) ? trans('messages.restored') : trans('messages.archived') ;
        return $this->generalResponse('true',200, trans('title.success'), $msg,null);
    }
    /////////////////////////////////////////
    public function getShow(Request $request, $kind , $id)
    {
        //dd($id);
        $info = $this->lawsuit_repo->get($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('dashboard.view'));
        }
        //dd($info);
        parent::$data['info'] = $info;
        parent::$data['kind'] = $kind;
        parent::$data['history_id'] = (is_null($info->parent_id)) ? $info->id : $info->parent_id ;
        return view('admin.lawsuits.show', parent::$data);
    }
    /////////////////////////////////////////
    public function getLogs(Request $request, $id)
    {
        $info = $this->lawsuit_repo->get($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('dashboard.view'));
        }
        parent::$data['info'] = $info;
        return view('admin.lawsuits.logs', parent::$data);
    }
    /////////////////////////////////////////
    public function getLogsList(Request $request , $id)
    {
        $info = $this->lawsuit_repo->logs($id);
        if (!$info)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route('dashboard.view'));
        }
        $datatable = Datatables::of($info);
        $datatable->addColumn('actions', function ($row)
        {
            $data['id'] = $row->id;
            $data['btn_class'] = parent::$data['btn_class'];
            $data['btn_red'] = parent::$data['btn_red'];
            $data['btn_green'] = parent::$data['btn_green'];
            $data['has_action'] = (! is_null($row->parent_id)) ? 1 : 0 ;
            $data['edit_route']   = ($row->parent_id) ? route('logs.edit',  $row->id )  : route('lawsuits.edit',  $row->id )  ;
            $data['delete_route'] = ($row->parent_id) ? route('logs.delete',  $row->id )  : route('lawsuits.delete',  $row->id ) ;
            $data['delete_class'] = ($row->parent_id) ? 'delete_log_btn'  : 'delete_btn' ;
            $data['kind'] =  (is_null($row->parent_id)) ? 'parent' : 'log'  ;
            return view('admin.lawsuits.parts.log-actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    /////////////////////////////////////////
}
