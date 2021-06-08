<?php
namespace App\Repositories\Interfaces;

/**
 * Interface UserRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface UserRepositoryInterface
{
    /**
     * Get's a user by it's ID
     *
     * @param int
     */
    public function get($id);

    /**
     * Get's all users.
     *
     * @return mixed
     */
    public function all();

    /**
     * Deletes a user.
     *
     * @param int
     */
    public function delete($id);

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);


    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * @param $type
     * @return mixed
     */
    public function UserStatistics($type);

    /**
     * @return mixed
     */
    public function getActiveUser();

    /**
     * @param $user_id
     * @return mixed
     */
    public function RateUser($user_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function allDataTable(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function countDataTable(array $data);
}
