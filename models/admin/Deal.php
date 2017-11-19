<?php 

namespace models\admin;

use \interfaces\models\admin\IDealModel;

class Deal
{
	private $model;

	/**
	 * Gets all dealings from db
	 *
	 * @return result of the function get_all
	 */
	public function get_all()
	{
		return $this->model->get_all();
	}

	/**
	 * Sets model
	 *
	 * IDealModel $model - object implementing interface IDealModel
	 */
	public function set_model(IDealModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Gets all dealings by offset/limit
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
	 * Counts dealings
	 *
	 * @return result of the function count
	 */
	public function count()
	{
		return $this->model->count();
	}
}