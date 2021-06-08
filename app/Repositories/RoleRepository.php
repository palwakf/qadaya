<?php


namespace App\Repositories;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @property Role $role
 * @package App\Repositories
 */
class RoleRepository implements RoleRepositoryInterface
{
    /**
     * RoleRepository constructor.
     */
    function __construct()
    {
        $this->role = new Role();
    }
    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->role->find($id);
    }
    /**
     * Get's all roles.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->role->all();
    }

    /**
     * Deletes a role.
     *
     * @param int
     * @return int
     */
    public function delete($id)
    {
        return $this->role->destroy($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->role->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->role->find($id)->update($data);
    }

    /**
     * @param array $data
     * @return $this|\Illuminate\Database\Eloquent\Builder|mixed
     */
    public function allDataTable(array $data)
    {
        $query = $this->role;
        $skip = 0;
        $take = 25;

        if(Arr::exists($data,"name") && !is_null($data['name']))
        {
            $query = $query->where('name', 'LIKE', '%' . $data['name']. '%');
        }
        if(Arr::exists($data,"start") && !is_null($data['start']))
        {
            $skip = $data['start'];
        }
        if(Arr::exists($data,"length") && !is_null($data['length']))
        {
            $take = $data['length'];
        }
        return $query->skip($skip)->take($take);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function countDataTable(array $data)
    {
        $query = $this->role;

        if(Arr::exists($data,"name") && !is_null($data['name']))
        {
            $query = $query->where('name', 'LIKE', '%' . $data['name']. '%');
        }
        return $query->count('id');
    }

}

