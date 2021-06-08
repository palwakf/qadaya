<?php

namespace App\Models;

use App\Traits\EncryptionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lawsuit extends Model
{
    use EncryptionTrait , SoftDeletes;
    /**
     * @var string
     */
    protected $guard_name = 'admin';
    protected $table = 'lawsuits';
    protected $fillable = [
        'lawsuit_number', 'claimant','defendant','type_id','court_id','user_id','deposit_date',
        'deposit_value','deposit_currency','is_archived' ,'parent_id','details'
    ];
    protected $hidden = [
        '',
    ];
    /**
     * @var array
     */
    protected $appends = [
        'id_hash','type_name','court_name','employee_name','currency_name'
    ];
    /**
     * @return string
     */
    function getIdHashAttribute()
    {
        return $this->encrypt($this->id);
    }
    ///////////////////////////////////
    public function childrens()
    {
        return $this->hasMany('App\Models\Lawsuit','parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Lawsuit', 'parent_id', 'id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($entity) { // before delete() method call this
            $entity->childrens()->delete();
        });
    }

    /////////////////////////

    public function type(){
        return $this->belongsTo('App\Models\Type','type_id','id');
    }
    public function court(){
        return $this->belongsTo('App\Models\Court','court_id','id');
    }
    public function employee(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function getTypeNameAttribute()
    {
        if ($this->type) {
            return $this->type->name;
        } else {
            return null;
        }
    }
    public function getCourtNameAttribute()
    {
        if ($this->court) {
            return $this->court->name;
        } else {
            return null;
        }
    }
    public function getEmployeeNameAttribute()
    {
        if ($this->employee) {
            return $this->employee->name;
        } else {
            return null;
        }
    }
    public function getCurrencyNameAttribute()
    {
        switch ($this->deposit_currency){
            case 'jod':
                $name= 'دينار أردني';
                break ;
            case 'usd':
                $name= 'دولار أمريكي';
                break ;
            case 'ils':
                $name= 'شيكل';
                break ;
            default:
                $name= null ;
        }
        return $name ;
    }

    public function getFirstLogAttribute()
    {
        if ($this->childrens->count() > 0) {
            $min = $this->childrens->min('id');
            return $this->childrens->where('id',$min)->first();
        } else {
            return $this;
        }
    }
    public function getLastLogAttribute()
    {
        if ($this->childrens->count() > 0) {
            $max = $this->childrens->max('id');
            return $this->childrens->where('id',$max)->first();
        } else {
            return $this;
        }
    }
    /////////////////

}
