<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;


class CourtController extends AbstractController
{
    //
    protected $viewsFolder = 'courts';
    protected $active_menu = 'courts';
    protected $table = 'courts';

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'courts';
    }



    protected function newModel()
    {
        return new Court();
    }

    protected function findOrFail($id)
    {
        return  Court::findOrFail($id);
    }






}
