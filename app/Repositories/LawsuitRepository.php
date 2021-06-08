<?php


namespace App\Repositories;
use App\Models\Lawsuit;
use App\Repositories\Interfaces\LawsuitRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Arr;

/**
 * Class LawsuitRepository
 * @property Lawsuit $lawsuit
 * @package App\Repositories
 */
class LawsuitRepository implements LawsuitRepositoryInterface
{

    /**
     * LawsuitRepository constructor.
     */
    function __construct()
    {
        $this->lawsuit = new Lawsuit();
    }
    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->lawsuit->find($id);
    }
    /**
     * Get's all lawsuits.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->lawsuit->whereNull('parent_id')->orderByDesc('created_at')->get();
    }
    /**
     * @param $id
     * @return mixed
     */
    public function logs($id)
    {
        $lawsuit = $this->lawsuit->find($id);
        $lawsuit_number = $lawsuit->lawsuit_number ;
        return $this->lawsuit->where('lawsuit_number',$lawsuit_number)->orderByDesc('id')->get();
    }

    /**
     * Deletes a lawsuit.
     *
     * @param int
     * @return int
     */
    public function delete($id)
    {
        return $this->lawsuit->destroy($id);
    }

    public function archive($id , $status)
    {
        $lawsuit = $this->lawsuit->find($id);
        $lawsuit_number = $lawsuit->lawsuit_number ;
        return $this->lawsuit->where('lawsuit_number',$lawsuit_number)->update(['is_archived'=> $status]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->lawsuit->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->lawsuit->find($id)->update($data);
    }
    /**
     * Get's my lawsuits.
     * @return mixed
     */
    public function myLawsuits()
    {
        return $this->lawsuit->whereNull('parent_id')
                             ->where('user_id',auth()->id())
                             ->get();
    }

    /**
     * @param string $type
     * @param array $data
     * @return $this|\Illuminate\Database\Eloquent\Builder|mixed
     */
    public function allDataTable($type , array $data)
    {
        $query = ($type== 'admin') ? $this->all() : $this->myLawsuits() ;
        $skip = 0;
        $take = 25;

        if(Arr::exists($data,"lawsuit_number") && !is_null($data['lawsuit_number']))
        {
            $query = $query->where('lawsuit_number', $data['lawsuit_number']);
        }
        if(Arr::exists($data,"type_id") && !is_null($data['type_id']))
        {
            $query = $query->where('type_id', $data['type_id']);
        }
        if(Arr::exists($data,"court_id") && !is_null($data['court_id']))
        {
            $query = $query->where('court_id', $data['court_id']);
        }
        if(Arr::exists($data,"is_archived") && !is_null($data['is_archived']))
        {
            $query = $query->where('is_archived', $data['is_archived']);
        }
        if(Arr::exists($data,"claimant") && !is_null($data['claimant']))
        {
            $query = $query->where('claimant', 'LIKE', '%' . $data['claimant']. '%');
        }
        if(Arr::exists($data,"defendant") && !is_null($data['defendant']))
        {
            $query = $query->where('defendant', 'LIKE', '%' . $data['defendant']. '%');
        }
        return $query->skip($skip)->take($take);
    }

    /**
     * @param string $type
     * @param array $data
     * @return mixed
     */
    public function countDataTable($type , array $data)
    {
        $query = ($type== 'admin') ? $this->all() : $this->myLawsuits() ;

        if(Arr::exists($data,"lawsuit_number") && !is_null($data['lawsuit_number']))
        {
            $query = $query->where('lawsuit_number', $data['lawsuit_number']);
        }
        if(Arr::exists($data,"type_id") && !is_null($data['type_id']))
        {
            $query = $query->where('type_id', $data['type_id']);
        }
        if(Arr::exists($data,"court_id") && !is_null($data['court_id']))
        {
            $query = $query->where('court_id', $data['court_id']);
        }
        if(Arr::exists($data,"is_archived") && !is_null($data['is_archived']))
        {
            $query = $query->where('is_archived', $data['is_archived']);
        }
        if(Arr::exists($data,"claimant") && !is_null($data['claimant']))
        {
            $query = $query->where('claimant', 'LIKE', '%' . $data['claimant']. '%');
        }
        if(Arr::exists($data,"defendant") && !is_null($data['defendant']))
        {
            $query = $query->where('defendant', 'LIKE', '%' . $data['defendant']. '%');
        }
        return $query->count('id');
    }

}

