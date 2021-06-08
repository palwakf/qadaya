<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;

class TypeController extends AbstractController
{
    protected $viewsFolder = 'types';
    protected $active_menu = 'types';
    protected $table = 'types';

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'types';
    }

    protected function newModel()
    {
        return new Type();
    }

    protected function findOrFail($id)
    {
        return  Type::findOrFail($id);
    }

}
