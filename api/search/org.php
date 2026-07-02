<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");

if (strlen($_REQUEST['s']) > 5) {


	if (true) {
		$dadata = new Dadata(DADATA_API_KEY);
		$dadata->init();

		$fields = array("query" => $_REQUEST['s'], "count" => 10);
		$result = $dadata->suggest("party", $fields);
		$dadata->close();
	} else {
		$result = json_decode(file_get_contents('test.data'), true);
	}

	
	if (count($result['suggestions']) > 0) {
		foreach ($result['suggestions'] as $ar) {
			$arResult[] = [
				"NAME" => $ar['value'],
				"INN" => $ar['data']['inn'],
				"OGRN" => $ar['data']['ogrn'],
				"ADDRESS" => $ar['data']['address']['unrestricted_value'],
				"OKVED" => $ar['data']['okved'],
				"TYPE" => $ar['data']['type'],
			];
		}
	}
}

log2file('api-search-client-by-inn',[$_REQUEST,$arResult,$result]);
echo json_encode([
	'code' => 200,
	'result' => $arResult,
]);


