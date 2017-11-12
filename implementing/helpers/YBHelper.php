<?php

namespace implementing\helpers;

use \interfaces\helpers\IHelper;

class YBHelper implements IHelper
{
	public function get_select2_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
    		$data = [];

    		foreach ($request["$field"] as $key => $value) {
    			$data[$key] = (int) $value;
    		}
		} else {
			$data = '';
		}

		return $data;
    }

	public function get_checkbox_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
    		$data = [];
    		
    		foreach ($request["$field"] as $key => $value) {
    			$data[$key] = (int) $value;
    		}
		} else {
			$data = '';
		}

		return $data;
    }

    public function create_select2_data(string $field, $data='')
    {
    	$result = [];
    	
    	$i = 0;
    	switch ($field) {
    		case 'roles':
		    	$arr = (array) $data;
				foreach($arr as $value) {
					$result[$i]['id'] = preg_replace('/[^0-9]/', '', $value);
					$result[$i]['name'] = preg_replace('/[^a-zA-ZА-Яа-я\s]/ui', '', $value);
					$i++;
				}
				break;
			case 'groups':
				$arr = explode(',', $data);
				foreach($arr as $value) {
					$result[$i]['id'] = preg_replace('/[^0-9]/', '', $value);
					$result[$i]['name'] = preg_replace('/[^a-zA-ZА-Яа-я\s]/ui', '', $value);
					$i++;
				}
				break;
			case 'windows':
				$arr = explode(',', $data);
				foreach($arr as $value) {
					$result[$i]['id'] = preg_replace('/[^0-9]/', '', $value);
					$result[$i]['name'] = preg_replace('/[^a-zA-ZА-Яа-я\s]/ui', '', $value);
					$i++;
				}
				break;
			case 'apartments':
				if ($data) {				
					$arr = explode(',', $data);
					foreach($arr as $value) {
						$result[$i]['id'] = $value;
						$i++;
					}
				}
				break;
    	}

		return $result;
    }

    public function do_query_to_amocrm_api($url, $data='', $method='')
    {
    	$subdomain = 'inpk';
        $link = 'https://'.$subdomain.'.amocrm.ru'.$url;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        if ($method == 'POST') {
	        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'POST');
	        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE,dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR,dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int) $code;

        if ($code != 200 && $code != 204) {
        	return false;
        } else {
        	return $out;
        }
    }

    public function auth_amocrm()
    {
	    $url = '/private/api/auth.php?type=json';
	    $method = 'POST';
	    
	    $settings = array(
	        'USER_LOGIN' => 'it@in-pk.com',
	        'USER_HASH' => '43562a1e01abf5a1a3ce3fd4b78d82f8'
	    );

	    return $this->do_query_to_amocrm_api($url, $settings, $method);
    }

    public function get_page()
    {
    	if (!$_GET) {
			$page = 1;
        } else {        	
			if (isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
        }

        return $page;
    }

    public function get_id()
    {
        $arr = explode('/', $_SERVER['REQUEST_URI']);
        return $id = (int) end($arr);
    }

    public function send_excel_file(array $files_names, array $emails, string $subject)
    {
        foreach ($files_names as $file_name) {
            if (mime_content_type(ROOT . '/public/files/' . $file_name) == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {

                $count_send = 0;
                foreach ($emails as $email) {
                    $to = $email;
                    $from = "info@crm.inpk-development.ru";
                    $message = '';

                    $separator = md5(date('r', time()));
                    $eol = PHP_EOL;

                    $path_to_prices_excel = ROOT . '/public/files/' . $file_name;
                    $attachment = chunk_split(base64_encode(file_get_contents($path_to_prices_excel)));

                    $headers  = "From: ".$from.$eol;
                    $headers .= "MIME-Version: 1.0".$eol; 
                    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

                    $body = "--".$separator.$eol;
                    $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;

                    $body .= "--".$separator.$eol;
                    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
                    $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
                    $body .= $message.$eol;

                    $body .= "--".$separator.$eol;
                    $body .= "Content-Type: application/octet-stream; name=\"".$file_name."\"".$eol; 
                    $body .= "Content-Transfer-Encoding: base64".$eol;
                    $body .= "Content-Disposition: attachment;  filename=\"".$file_name."\"".$eol.$eol;
                    $body .= $attachment.$eol;
                    $body .= "--".$separator."--";

                    $result = mail($to, $subject, $body, $headers);

                    if ($result) {
                        $count_send += 1;
                    } else {
                        $count_send -= 1;
                    }
                }

                if ($count_send <= 0) {
                    http_response_code(500);
                    $this->validator->check_response('ajax');               
                } else {
                    $response['message'] = 'Готово';
                    echo json_encode($response);
                    return true;
                }
            }
        }
    }
}