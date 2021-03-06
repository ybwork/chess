<?php

return array(
	'admin/role/delete' => 'controllers\admin\Role/delete',
	'admin/role/update' => 'controllers\admin\Role/update',
	'admin/role/edit/[0-9]+' => 'controllers\admin\Role/edit',
	'admin/role/create' => 'controllers\admin\Role/create',
	'admin/roles' => 'controllers\admin\Role/index',

	'admin/user/delete' => 'controllers\admin\User/delete',
	'admin/user/update' => 'controllers\admin\User/update',
	'admin/user/edit/[0-9]+' => 'controllers\admin\User/edit',
	'admin/user/create' => 'controllers\admin\User/create',
	'admin/users' => 'controllers\admin\User/index',
	
	'admin/prices/upload' => 'controllers\admin\Price/upload',
	'admin/prices/index' => 'controllers\admin\Price/index',

	'admin/settings/reserve/delete' => 'controllers\admin\SettingReserve/delete',
	'admin/settings/reserve/update' => 'controllers\admin\SettingReserve/update',
	'admin/settings/reserve/edit/[0-9]+' => 'controllers\admin\SettingReserve/edit',
	'admin/settings/reserve/create' => 'controllers\admin\SettingReserve/create',
	'admin/settings-reserve' => 'controllers\admin\SettingReserve/index',

	'admin/glazing/delete' => 'controllers\admin\Glazing/delete',
	'admin/glazing/update' => 'controllers\admin\Glazing/update', 
	'admin/glazing/edit/[0-9]+' => 'controllers\admin\Glazing/edit',
	'admin/glazing/create' => 'controllers\admin\Glazing/create',
	'admin/glazings' => 'controllers\admin\Glazing/index',

	'admin/type/delete' => 'controllers\admin\Type/delete',
	'admin/type/update' => 'controllers\admin\Type/update', 
	'admin/type/edit/[0-9]+' => 'controllers\admin\Type/edit',
	'admin/type/create' => 'controllers\admin\Type/create',
	'admin/types' => 'controllers\admin\Type/index',

	'admin/total/area/delete' => 'controllers\admin\Total/Area/delete',
	'admin/total/area/update' => 'controllers\admin\Total/Area/update', 
	'admin/total/area/edit/[0-9]+' => 'controllers\admin\Total/Area/edit',
	'admin/total/area/create' => 'controllers\admin\Total/Area/create',
	'admin/total/areas' => 'controllers\admin\Total/Area/index',

	'admin/window/delete' => 'controllers\admin\Window/delete',
	'admin/window/update' => 'controllers\admin\Window/update', 
	'admin/window/edit/[0-9]+' => 'controllers\admin\Window/edit',
	'admin/window/create' => 'controllers\admin\Window/create',
	'admin/windows' => 'controllers\admin\Window/index',

	'admin/apartment/delete' => 'controllers\admin\Apartment/delete',
	'admin/apartment/update' => 'controllers\admin\Apartment/update', 
	'admin/apartment/edit/[0-9]+' => 'controllers\admin\Apartment/edit',
	'admin/apartment/create' => 'controllers\admin\Apartment/create',
	'admin/apartments' => 'controllers\admin\Apartment/index',

	'admin/dealings' => 'controllers\admin\Deal/index',

	'buyer/show' => 'controllers\site\Buyer/show',

	'apartment/buy' => 'controllers\site\Apartment/buy',
	'apartment/reserve' => 'controllers\site\Apartment/reserve',
	'apartment/withdraw-reserve' => 'controllers\site\Apartment/withdraw_reserve',
	'apartment/auto-withdraw-reserve' => 'controllers\site\Cron/auto_withdraw_reserve',
	'apartments' => 'controllers\site\Apartment/index',

	'login/user' => 'controllers\auth\Login/login',
	'logout' => 'controllers\admin\User/logout',
	'login' => 'controllers\auth\Login/index',

	'' => 'controllers\site\Home/index',
);