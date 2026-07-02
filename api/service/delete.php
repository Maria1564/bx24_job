<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
	
	$id = $_REQUEST['id'];
	if($id > 0 ){
	    //Игнорируем обновление в Битрикс24
	    $GLOBALS['IGNORE_EVENT'] = true;
		
		$client = Service::getClient($id);
		$result = Service::delete($id);
		echo json_encode(['code' => 'ok','statusText'=>$result,'client_id'=>$client['ID']]);
	}
	else {
	   echo json_encode(['code' => 'error','statusText'=>"id is null"]);
	}
	
