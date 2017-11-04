<?php

namespace interfaces\models\admin;

interface ISettingReserveModel
{
   public function get_all();
   public function create(array $data);
   public function show(int $id);
   public function update(array $data);
   public function delete(int $id);
}