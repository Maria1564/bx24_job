<?php
	
	/*
		* Обновляет данные сделки в црм
	*/
	
	class BX24SyncDeal {
		
		/**
		   
		*/
		public static function run($elementID) {
			$result = false;
			$service = Service::getServiceById($elementID);
			$bx24_task_id = $service['PROPERTIES']['BX24_TASK_ID']['VALUE'];
			//если уже связан с сделкой в crm bitrix24
			if ($bx24_task_id > 1) {
				self::update($service);
				} else {
				//Если нет, то создаем и обновляем данные
				self::add($service);
			}
			return [
			'result' => $result,
			];
		}
		
		/*
			* Обновялет данные компании в crm bitrx24 данными текущего 
			* элемента
		*/
		
		public static function update($service) {
			$bx24_task_id = $service['PROPERTIES']['BX24_TASK_ID']['VALUE'];
			$managerID = $service['PROPERTIES']['MANAGER']['VALUE'];//ID пользователя в системе
			$oBitrix = new \Zloykolobok\Bitrix24\Classes\Deal();
			$oBitrix->setUrl(BX_WEBHOOK_URL);
			$oBitrix->setTimeout(30);
			$result = $oBitrix->dealGet($bx24_task_id);
			$client = Client::getClientById($service['PROPERTIES']['CLIENT']['VALUE']);
			$clientBx24CompanyID = $client['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
			$log['$bx24_task_id'] = $bx24_task_id;
			$log['$result'] = $result;
			if ($result) {
				$fields = [
				"TITLE" => $service['~NAME'],
				"COMMENTS" => $service['~PREVIEW_TEXT'],
				"COMPANY_ID" => $clientBx24CompanyID,
			//	"RESPONSIBLE_ID" => Helper::getUserBx24Id(), //устанавливаем ответственного (текущий пользователь)
				"ASSIGNED_BY_ID" => Helper::getUserBx24Id($managerID), //устанавливаем ответственного (текущий пользователь)
				//"UF_CRM_TASK" => ["CO_" . $clientBx24CompanyID],
				];
				$log['fields'] = $fields;
				
				
				$oBitrix->dealUpdate($bx24_task_id, $fields, false);
				} else {
				return self::add($service);
			}
			log2file(__CLASS__ . '-' . __FUNCTION__, $log);
			return true;
		}
		
		/*
			* Добавляет компанию в crm bitrix24 и его ID
			* привязывает текущему клиенту
		*/
		
		public static function add($service) {
			//создаем поля!
			ob_start();
			$managerID = $service['PROPERTIES']['MANAGER']['VALUE'];//ID пользователя в системе
			$client = Client::getClientById($service['PROPERTIES']['CLIENT']['VALUE']);
			$clientBx24CompanyID = $client['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
			$log['$clientBx24CompanyID'] = $clientBx24CompanyID;
			$fields = [
			"TITLE" => $service['~NAME'],
			"COMMENTS" => $service['~PREVIEW_TEXT'],
			"COMPANY_ID" => $clientBx24CompanyID,
			"UF_CRM_1592896064805"=>"Да",
			"RESPONSIBLE_ID" => Helper::getUserBx24Id($managerID),
			//"UF_CRM_TASK" => ["CO_" . $clientBx24CompanyID],
			];
			$fields['params'] = [];
			$log['$fields'] = $fields;
			$oBitrix = new \Zloykolobok\Bitrix24\Classes\Deal();
			$oBitrix->setUrl(BX_WEBHOOK_URL);
			$oBitrix->setTimeout(30);
			$result = $oBitrix->dealAdd($fields);
			$task_id = $result->result;
			$log['$res2'] = $result;
			if ($task_id > 0) {
				CModule::IncludeModule("iblock");
				CIBlockElement::SetPropertyValuesEx($service['ID'], false, array('BX24_TASK_ID' => $task_id));
			}
			$log['content'] = ob_get_contents();
			log2file(__CLASS__ . '-' . __FUNCTION__, $log);
		}
		
	}
