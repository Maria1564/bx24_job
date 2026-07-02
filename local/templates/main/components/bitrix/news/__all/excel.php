<?
	
	
	$APPLICATION->RestartBuffer();
	$filePath = $_SERVER['DOCUMENT_ROOT'] . "/upload/csv/все-" . $APPLICATION->GetTitle() . ".xls";
	
	$fileName = str_replace($_SERVER['DOCUMENT_ROOT'],"",$filePath);
	$objWriter = new PHPExcel_Writer_Excel5($xls);
	$objWriter->save($filePath);
	header('Content-Type: application/json');
	//echo download_send_headers("1");
	echo json_encode(['fileName' => $fileName]);
exit;