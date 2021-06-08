<?php


namespace App\Repositories\Interfaces;
/**
 * Interface RoleRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface RoleRepositoryInterface
{
    /**
     * Get's a role by it's ID
     *
     * @param int
     */
    public function get($id);

    /**
     * Get's all roles.
     *
     * @return mixed
     */
    public function all();

    /**
     * Deletes a role.
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

    public function allDataTable(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function countDataTable(array $data);
}
