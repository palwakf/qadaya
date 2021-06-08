<?php

namespace App\Models;

use App\Traits\EncryptionTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use EncryptionTrait;
    /**
     * @var string
     */
    protected $guard_name = 'admin';

    protected $table = 'roles';
    protected $fillable = [
        'name', 'status', 'guard_name'
    ];
    protected $hidden = [
        '',
    ];
    /**
     * @var array
     */
    protected $appends = [
        'id_hash'
    ];
    /**
     * @return string
     */
    function getIdHashAttribute()
    {
        return $this->encrypt($this->id);
    }
    ////////////////////////////////////
//    public function user()
//    {
//        return $this->hasMany('App\Models\User');
//    }
    ////////////////////////////////////
    function addRole($name, $status)
    {
        $this->name = $name;
        $this->guard_name = 'admin';
        $this->status = $status;

        $this->save();
        return $this;
    }
    ////////////////////////////////////
    function updateRole($obj, $name, $status)
    {
        $obj->name = $name;
        $obj->status = $status;

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
    function deleteRole($obj)
    {
        return $obj->delete();
    }
    ////////////////////////////////////
    function getRole($id)
    {
        return $this->find($id);
    }
    ////////////////////////////////////
    function getAllRolesActive()
    {
        return $this->where('status','=',1)->get();
    }
    ////////////////////////////////////
        function getRoles($name = null)
    {
        return $this->where(function($query) use ($name) {
            if($name != "")
            {
                $query->where('name','LIKE','%'.$name.'%');
            }
        })->get();
    }
}
