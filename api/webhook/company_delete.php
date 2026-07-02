<?php
	/*
		* 1. получаем новые данные из црм
		* 2. обновляем данные на сайте
		* 3. добавляем событие изменения.
	*/
	
	$oBitrix = new \Zloykolobok\Bitrix24\Classes\Company();
	$oBitrix->setUrl(BX_WEBHOOK_URL);
	$oBitrix->setTimeout(100);
	
	$company = $oBitrix->companyGet($ID);
	$log['ID'] = $ID;
	$log['company'] = $company;
	
	log2file('bx24Log-company_delete', $log,true);
	log2file('bx24Log-company_delete_REQUEST', $_REQUEST,true);
	
//l($company);