<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

abstract class AbstractController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = $this->active_menu;
    }

    public function index(Request $request)
    {
        $entries = $this->newModel()->latest();
        $name = trim(request()->input('name'));

        $datatable = Datatables::of($entries);
        $datatable->addColumn('actions', function ($row)
        {
            $data['id'] = $row->id;
            $data['btn_class'] = parent::$data['btn_class'];
            $data['btn_red'] = parent::$data['btn_red'];
            $data['btn_green'] = parent::$data['btn_green'];

            return view('admin.'.$this->viewsFolder.'.parts.actions', $data)->render();
        });
        if (!empty($name)) {
            $datatable->filter(function ($entity) use ($name) {
                $entity->where('name', 'like', "%{$name}%") ;
            });
        }
        $datatable->escapeColumns(['*']);
        return (request()->ajax()) ?  $datatable->make(true) : view('admin.'.$this->viewsFolder.'.index' , parent::$data) ;
    }

    public function create(){
        return view('admin.'.$this->viewsFolder.'.create' , parent::$data) ;
    }

    public function store(Request $request)
    {
        $entity = $this->newModel();

        $validator = Validator::make([
            'name' => $request->name,
        ], [
            'name' => 'required|min:3|max:60|unique:'.$this->table.',name',
        ]);
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }
        //////////////////////////////////////
        $entity->name = $request->input('name');
        if ($entity->created_at) {
            $entity->created_at =date('Y-m-d H:i:s');
        }
        if($entity->saveOrFail())
        {
            return $this->generalResponse('true',200, trans('title.success'), trans('messages.added'),$entity);
        }
        return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);

    }

    public function show($id)
    {
        return response()->json($this->findOrFail($id));
    }

    public function edit(Request $request, $id){
        $entity = $this->findOrFail($id);
        if (!$entity)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route(''.$this->viewsFolder.'.index'));
        }

        parent::$data['id'] = $id;
        parent::$data['info'] = $entity;
        //dd(parent::$data);
        return view('admin.'.$this->viewsFolder.'.edit' , parent::$data) ;
    }
    public function update(Request $request, $id)
    {
        $entity = $this->findOrFail($id);
        if (!$entity)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route(''.$this->viewsFolder.'.index'));
        }
        $validator = Validator::make([
            'name' => $request->name,
        ], [
            'name' => 'required|min:3|max:60|unique:'.$this->table.',name,' . $id,
        ]);
        if ($validator->fails())
        {
            return $this->generalResponse('false',400, trans('title.warning'), $validator->messages()->first(),null);
        }
        //////////////////////////////////////
        $entity->name = $request->input('name');

        if ($entity->updated_at) {
            $entity->updated_at =date('Y-m-d H:i:s');
        }
        if($entity->saveOrFail())
        {
            return $this->generalResponse('true',200, trans('title.success'), trans('messages.updated'),$entity);
        }
        return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
    }

    public function destroy(Request $request, $id)
    {
        $entity = $this->findOrFail($id);
        if (!$entity)
        {
            $request->session()->flash('data', ['title' => trans('title.info'),  'code' => 300, 'message' => trans('messages.not_found')]);
            return redirect(route(''.$this->viewsFolder.'.index'));
        }
        if($entity->delete())
        {
            return $this->generalResponse('true',200, trans('title.success'), trans('messages.deleted'),null);
        }
        return $this->generalResponse('false',500, trans('title.error'), trans('messages.error'),null);
    }


}
