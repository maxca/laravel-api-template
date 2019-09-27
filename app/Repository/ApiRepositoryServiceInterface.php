<?php

namespace App\Repository;

/**
 * Interface RepositoryServiceInterface
 * @package App\Repositories\Services
 * @author samark chisanguan <samarkchsngn@gmail.com>
 */
interface ApiRepositoryServiceInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param $id
     * @return mixed
     */
    public function detail($id);

    /**
     * @param $params
     * @return mixed
     */
    public function store($params);

    /**
     * @param $params
     * @return mixed
     */
    public function update($params);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @return mixed
     */
    public function getFieldsSearchable();
}