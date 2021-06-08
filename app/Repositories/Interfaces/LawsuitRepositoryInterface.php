<?php


namespace App\Repositories\Interfaces;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Interface LawsuitRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface LawsuitRepositoryInterface
{
    /**
     * Get's a log by it's ID
     *
     * @param int
     */
    public function get($id);

    /**
     * Get's a log by it's ID
     *
     * @param int
     */
    public function logs($id);

    /**
     * Get's all logs.
     *
     * @return mixed
     */
    public function all();

    /**
     * Get's my lawsuits.
     *
     * @return mixed
     */
    public function myLawsuits();

    /**
     * Deletes a log.
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
     * @param $id
     * @param boolean $status
     * @return mixed
     */
    public function archive($id, boolean $status);

    public function allDataTable($type ,array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function countDataTable($type ,array $data);
}
