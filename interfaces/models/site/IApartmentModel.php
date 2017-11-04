<?php

namespace interfaces\models\site;

interface IApartmentModel
{
   public function get_all(string $condition='');
   public function lead(array $data);
   public function get_floors_types_aparts();
   public function get_general_info_apartments();
   public function reserve(array $data);
   public function withdraw_reserve(int $apartment_id, int $buyer_id);
   public function auto_withdraw_reserve();
   public function actualize(array $closed_not_implement_apartments);
}