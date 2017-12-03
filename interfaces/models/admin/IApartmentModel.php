<?php

namespace interfaces\models\admin;

interface IApartmentModel
{
   public function get_all();
   public function get_all_by_offset_limit(int $offset, int $limit);
   public function create(array $data);
   public function show(int $id);
   public function update(array $data);
   public function delete(int $id);
   public function count();
   public function check_exists(int $apartment_num);
}