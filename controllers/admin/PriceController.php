<?php

namespace controllers\admin;

use \components\Paginator;
use \paginators\YBPaginator;
use \components\Helper;
use \helpers\YBHelper;
use \components\Validator;
use \validators\YBValidator;
use \models\admin\Price;
use \implementing\models\admin\MySQLPriceModel;

class PriceController
{
	private $model;
	private $helper;
	private $validator;
	private $paginator; 

	public function __construct()
	{
		$this->validator = new Validator();
		$this->validator->set_validator(new YBValidator);
		$this->validator->check_auth();

        $roles = ['admin'];
        $this->validator->check_access($roles);

		$this->model = new Price();
		$this->model->set_model(new MySQLPriceModel());

		$this->helper = new Helper();
		$this->helper->set_helper(new YBHelper());
	}

	public function index()
	{
		require_once(ROOT . '/views/admin/price/index.php');
		return true;
	}

	public function upload()
	{
		$this->validator->check_request($_POST);

		$path_to_uploaded_files = $_FILES['prices']['tmp_name'];
		$files_names = $_FILES['prices']['name'];
		$files_params = $_FILES['prices'];

		if (in_array('', $files_params['name']) || !array_key_exists(1, $files_params['name'])) {
			header('HTTP/1.0 400 Bad Request', http_response_code(400));
			$response['message'] = 'Должно быть добавленно 2 файла. Первый в формате csv с новыми ценами для тесла дома, второй в формате excel для отправки экономистам!';
			echo json_encode($response);
			die();
		} else {

			// Удаление старых файлов с ценами
			$old_files = scandir(ROOT . '/public/files/', 1);
			foreach ($old_files as $old_file) {
				if (!is_dir($old_file)) {
					unlink(ROOT . '/public/files/' . $old_file);
				}
			}

			// Загрузка файлов с ценами
			$i = 0;
			foreach ($files_params['name'] as $file_name) {
				$new_path = ROOT . '/public/files/' . $file_name;
				$file = move_uploaded_file($files_params['tmp_name'][$i], $new_path);

				if (!$file) {
					http_response_code(500);
					$this->validator->check_response('ajax');
				}

				$i++;
			}

			// Обновление цен
			$new_files = scandir(ROOT . '/public/files/', 1);
			foreach ($new_files as $new_file) {
				if (mime_content_type(ROOT . '/public/files/' . $new_file) == 'text/plain') {
					$path_to_prices_csv = ROOT . '/public/files/' . $new_file;
					$open_file = fopen($path_to_prices_csv, 'r');
					$data = fgetcsv($open_file);

					$nums_prices = [];
					$i = 0;
					while ($row = fgetcsv($open_file)) {
						$clean_string = str_replace(' ', '', $row[0]);
						$values = explode(';', $clean_string);
						$nums_prices[$i]['num'] = $values[0];
						$nums_prices[$i]['price'] = $values[1];
						$i++;
					}

					if (count($nums_prices) < 1) {
						header('HTTP/1.0 400 Bad Request', http_response_code(400));
						$response['message'] = 'Файл с ценами не может быть пустым!';
						echo json_encode($response);
						die();
					} else {
						$this->model->upload($nums_prices);
					}
				}
			}

			$emails = ['ilia.kaduk@in-pk.com','dmitriy.sergeev@in-pk.com'];
			$subject = 'Тесла |дом - Обновились цены на квартиры';
			$this->helper->send_excel_file($files_names, $emails, $subject);
		}
	}
}