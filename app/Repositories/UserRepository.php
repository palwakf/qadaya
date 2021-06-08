<?php
namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Arr;

/**
 * Class UserRepository
 * @property User $user
 * @package App\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     */
    function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->user->find($id);
    }

    /**
     * Get's all users.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * Deletes a user.
     *
     * @param int
     * @return int
     */
    public function delete($id)
    {
        return $this->user->destroy($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->user->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->user->find($id)->update($data);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function UserStatistics($type)
    {
        return $this->user->where('role_id', $type)->count('id');
    }

    /**
     * @return mixed
     */
    public function getActiveUser()
    {
        return $this->user->where('status', 1)->where('role_id', 2)->get();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function RateUser($user_id)
    {
        return $this->user->where('id', $user_id)->first();
    }

    /**
     * @param array $data
     * @return $this|\Illuminate\Database\Eloquent\Builder|mixed
     */
    public function allDataTable(array $data)
    {
        $query = $this->user;
        $skip = 0;
        $take = 25;

        if(Arr::exists($data,"username") && !is_null($data['username']))
        {
            $query = $query->where('username', 'LIKE', $data['username'].'%');
        }
        if(Arr::exists($data,"name") && !is_null($data['name']))
        {
            $query = $query->where('name', 'LIKE', '%' . $data['name']. '%');
        }
        if(Arr::exists($data,"email") && !is_null($data['email']))
        {
            $query = $query->where('email', 'LIKE', '%' . $data['email']. '%');
        }
        if(Arr::exists($data,"status") && !is_null($data['status']))
        {
            $query = $query->where('status', $data['status']. '%');
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
        $query = $this->user;

        if(Arr::exists($data,"username") && !is_null($data['username']))
        {
            $query = $query->where('username', 'LIKE', $data['username'].'%');
        }
        if(Arr::exists($data,"name") && !is_null($data['name']))
        {
            $query = $query->where('name', 'LIKE', '%' . $data['name']. '%');
        }
        if(Arr::exists($data,"email") && !is_null($data['email']))
        {
            $query = $query->where('email', 'LIKE', '%' . $data['email']. '%');
        }
        if(Arr::exists($data,"status") && !is_null($data['status']))
        {
            $query = $query->where('status', $data['status']. '%');
        }
        return $query->count('id');
    }

}
