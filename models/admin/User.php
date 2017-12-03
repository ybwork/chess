<?php

namespace models\admin;

use \interfaces\models\admin\IUserModel;

class User
{
    private $model;

    /**
     * Sets model
     *
     * IUserModel $model - object implementing interface IUserModel
     */
    public function set_model(IUserModel $model)
    {
        $this->model = $model;
    }

    /**
     * Gets all users
     *
     * @return result of the function get_all
     */
    public function get_all()
    {
        return $this->model->get_all();
    }

    /**
     * Gets all users by offset/limit
     * 
     * @param $offset - plece for start query
     * @param $limit - limit records on each query
     * @return result of the function get_all_by_offset_limit
     */
    public function get_all_by_offset_limit(int $offset, int $limit)
    {
        return $this->model->get_all_by_offset_limit($offset, $limit);
    }

    /**
     * Creates user
     *
     * @param $data - data user
     * @return result of the function create
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * Updates user
     *
     * @param $data - new data user
     * @return result of the function update
     */
    public function update(array $data)
    {
        return $this->model->update($data);
    }

    /**
     * Deletes user
     *
     * @param $id - user id
     * @return result of the function delete
     */
    public function delete(int $id)
    {
        return $this->model->delete($id);
    }

    /**
     * Counts users
     *
     * @return result of the function count
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Checks user on exists
     *
     * @param $data - data user
     * @return result of the function check_exists
     */
    public function check_exists(array $data)
    {
        return $this->model->check_exists($data);
    }
}