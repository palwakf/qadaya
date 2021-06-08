<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasPermission extends Model
{
    public $timestamps = false;
    protected $table = 'model_has_permissions';
    protected $fillable = [
        'permission_id', 'model_type', 'model_id',
    ];
    protected $hidden = [
        '',
    ];
    ////////////////////////////////////
    function addModelHasPermissions($permission_id, $role_id)
    {
        $this->permission_id = $permission_id;
        $this->role_id = $role_id;

        $this->save();
        return $this;
    }
    ////////////////////////////////////
    function updateModelHasPermissions($obj, $permission_id, $role_id)
    {
        $obj->permission_id = $permission_id;
        $obj->role_id = $role_id;

        $obj->save();
        return $obj;
    }
    ////////////////////////////////////
    function updateStatus($id, $status)
    {
        return $this
            ->where('id', '=', $id)
            ->update([
                'status' => $status
            ]);
    }
    ////////////////////////////////////
    function deleteModelHasPermissions($obj)
    {
        return $obj->delete();
    }
    ////////////////////////////////////
    function deleteModelHasPermissionsByModelId($role_id)
    {
        return $this->where('role_id',$role_id)->delete();
    }
    ////////////////////////////////////
    function getModelHasPermissions($id)
    {
        return $this->find($id);
    }
    ////////////////////////////////////
    function getModelHasPermissionsByModelId($id)
    {
        return $this->where('role_id', $id)->get()->toArray();
    }
    ////////////////////////////////////
    function getModelsHasPermissions($name = null)
    {
        return $this->where(function($query) use ($name) {
            if($name != "")
            {
                $query->where('name','LIKE','%'.$name.'%');
            }
        })->get();
    }
}
