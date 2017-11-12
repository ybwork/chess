<?php

namespace interfaces\models\admin;

interface IDealModel
{
	public function get_all_by_offset_limit(int $offset, int $limit);
	public function count();
}