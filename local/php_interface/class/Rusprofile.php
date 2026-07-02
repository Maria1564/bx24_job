<?php

/*
 * Класс для  реализации функционала изрбранное
 */

class Rusprofile {

	var $inn;
	var $requestContent;
	var $error;
	var $log = false;

	public function isMSP() {
		$this->request();
		$result = false;
		if ($this->requestContent !== false) {
		//l($this->requestContent);
			if (strpos($this->requestContent, 'микропредприятие')) {
				$this->l('микропредприятие');
				$result_text = 'микропредприятие';
				$result = true;
			} else if (strpos($this->requestContent, 'Микропредприятие')) {
				$this->l('Микропредприятие');
				$result_text = 'микропредприятие';
				$result = true;
			} else if (strpos($this->requestContent, 'малое предприятие')) {
				$this->l('малое предприятие');
				$result_text = 'малое предприятие';
				$result = true;
			} else if (strpos($this->requestContent, 'среднее предприятие')) {
				$this->l('среднее предприятие');
				$result_text = 'среднее предприятие';
				$result = true;
			} else {
				$this->l('НЕ микропредприятие');
				$result_text = 'не является мсп';
				$result = false;
			}
		}
		
		return [
			"result" => $result,
			'result_text' => $result_text,
		];
	}

	public function request() {
		if ($this->inn == null) {
			$this->l('ИНН не задан');
			$this->error = 'ИНН не задан!';
			return false;
		}
		$link = 'https://www.rusprofile.ru/search?query=' . $this->inn;
		$this->l('request->' . $link);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTREDIR, 3);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		//$agent = 'Chrome/72.0.3626.121 Safari/537.36';
	//	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
		$this->requestContent = curl_exec($ch);
		$this->l($this->requestContent);
		$this->error = curl_error($ch);
		$this->l($this->error);
		if ($this->requestContent === false) {
			$this->l('пустой контетн');
			$this->error = curl_error($ch);
			return false;
		}
		curl_close($ch);
		return true;
	}

	public function l($arr) {
		if ($this->log) {
			echo '<pre>';
			print_r($arr);
			echo '</pre>';
		}
	}

}
