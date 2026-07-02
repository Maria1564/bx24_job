<?php
/*
	Класс для синхроинзации услуг в системе с задачами в Битиркс24
*/
class BX24SyncTask {

   public static function getTaskLink($idTask){
	
	 return 'https://bx24.arbko.ru/service/'.$idTask.'/';
   }
	public static function bx24SynchronizationElement($elementID) {
		$result = false;
		$service = Service::getServiceById($elementID);
		$bx24_task_id = $service['PROPERTIES']['BX24_TASK_ID']['VALUE'];
		//log2file('bx24SyncTaskUpdate', $service);return;
		if ($bx24_task_id > 1) {
			self::taskUpdate($service);
		} else {
		//Если нет, то создаем и обновляем данные
			self::taskAdd($service);
			$error = "Элемент не привязан к компаниям в B24";
		}

		return [
			'result' => $result,
			'error' => $error,
		];
	}

	/*
	 * Обновялет данные компании в crm bitrx24 данными текущего 
	 * элемента
	 */

	public static function taskUpdate($service) {
		$bx24_task_id = $service['PROPERTIES']['BX24_TASK_ID']['VALUE'];
		
		//Если услуга создана через сайт, то не нужно добавлять в Б24
		if($service['PROPERTIES']['CREATED']['VALUE'] == 'SITE'){
		   return false;	
		}
		
		
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(30);
		$result = $oBitrix->taskItemGetdata($bx24_task_id);
		//Есть задача
		$log['$bx24_task_id'] = $bx24_task_id;
		$log['$result'] = $result;
		
		//получаем рейтинг 
		$raitingObj = new Raiting();
		if ($result) {
			$fields = [
				"TITLE" => $service['~NAME'],
				"DESCRIPTION" => $service['~PREVIEW_TEXT'],
				"UF_AUTO_775796871108"=>$raitingObj->getServiceRaiting($service['ID']),// рейтинг в Битрикс24 имеет кастомное поле с кодом UF_AUTO_775796871108
				"UF_AUTO_178495370868"=>BX24SyncTask::getTaskLink($service['ID']),
				"UF_AUTO_704497779638" => $service['ID'],
				"UF_AUTO_496520653117" => $service['PROPERTIES']['BX24_STATUS_EXT']['VALUE'],//Удалось реализовать?
					"UF_AUTO_917547704171"=>  $service['PROPERTIES']['MONEY']['VALUE'],//Денег получено (прямая поддержка)
				"UF_AUTO_838424754255"=>$service['PROPERTIES']['MONEY2']['VALUE'],//Денег получено (непрямая поддержка)
				
				"UF_AUTO_512193261528" => $service['DATE_ACTIVE_FROM'],//Дата начала услуги
				"UF_AUTO_241329687317"=> $service['DATE_ACTIVE_TO'],//Дата начала услуги
				
					"UF_AUTO_972964280193" => $service['PROPERTIES']['DIRECTION']['VALUE'],//Направление (код )
				//"DEADLINE" => "2020-03-19T08:11:39+03:00",
				//"PRIORITY" => 1,
				//"UF_STATUS" => 226,
				//"ALLOW_CHANGE_DEADLINE" => "Y",
				//"TASK_CONTROL" => "N",
				//"STATUS" => 1,
				//"SITE_ID" => "s1",
				//"RESPONSIBLE_ID" => 1385,
				//"UF_CRM_TASK" => ["CO_479"],
			];
			 $fields['STATUS'] = 1;
           if ($service['PROPERTIES']['STATUS']['VALUE'] == 2) {
		   $fields['STATUS'] = 5;
}
			$log['fields'] = $fields;


			$oBitrix->taskItemUpdate($bx24_task_id, $fields);
		} else {
			return self::taskAdd($service);
		}
		log2file('bx24SyncTaskUpdate', $log);
		return true;
	}

	/*
	 * Добавляет компанию в crm bitrix24 и его ID
	 * привязывает текущему клиенту
	 */

	public static function taskAdd($service) {
		//создаем поля!
		ob_start();
		$client = Client::getClientById($service['PROPERTIES']['CLIENT']['VALUE']);
		$clientBx24CompanyID = $client['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
		$log['$clientBx24CompanyID'] = $clientBx24CompanyID;
		//Если услуга создана через сайт, то не нужно добавлять в Б24
		if($service['PROPERTIES']['CREATED']['VALUE'] == 'SITE'){
		   return false;
		
		}
		/*
		 * У клиента есть связь с компанией в CRM Bitrxi24,
		 * получаем его ID в CRM
		 */
		if ($clientBx24CompanyID > 0) {
			$fields['fields'] = [
				"TITLE" => $service['~NAME'],
				"DESCRIPTION" => $service['~PREVIEW_TEXT'],
				"UF_AUTO_178495370868"=>BX24SyncTask::getTaskLink($service['ID']),
				"UF_AUTO_704497779638" => $service['ID'],
				
				"UF_AUTO_496520653117" => $service['PROPERTIES']['BX24_STATUS_EXT']['VALUE'],//Удалось реализовать?
				"UF_AUTO_917547704171"=>  $service['PROPERTIES']['MONEY']['VALUE'],//Денег получено (прямая поддержка)
				"UF_AUTO_838424754255"=>$service['PROPERTIES']['MONEY2']['VALUE'],//Денег получено (непрямая поддержка)
				
				"UF_AUTO_512193261528" => $service['DATE_ACTIVE_FROM'],//Дата начала услуги
				"UF_AUTO_241329687317"=> $service['DATE_ACTIVE_TO'],//Дата начала услуги
				"UF_AUTO_972964280193" => $service['PROPERTIES']['DIRECTION']['VALUE'],//Направление (код )
				
			//	'BX24_STATUS_EXT'=>$dealObj->UF_AUTO_496520653117,//Удалось реализовать?
				//"DEADLINE" => "2020-03-19T08:11:39+03:00",
				//"PRIORITY" => 1,
				//"UF_STATUS" => 226,
				//"ALLOW_CHANGE_DEADLINE" => "Y",
				//"TASK_CONTROL" => "N",
				//"STATUS" => 1,
				//"SITE_ID" => "s1",
				
				"CREATED_BY"=>Helper::getUserBx24Id(),
				"RESPONSIBLE_ID" => Helper::getUserBx24Id(),
				"UF_CRM_TASK" => ["CO_" . $clientBx24CompanyID],
			];
			$fields['params'] = [];
			$log['$fields'] = $fields;
			$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
			$oBitrix->setUrl(BX_WEBHOOK_URL);
			$oBitrix->setTimeout(30);
			$result = $oBitrix->taskItemAdd($fields);
			$task_id = $result->result;
			$log['$res2'] = $result;
			if ($task_id > 0) {
				CModule::IncludeModule("iblock");
				CIBlockElement::SetPropertyValuesEx($service['ID'], false, array('BX24_TASK_ID' => $task_id));
			}
			$log['content'] = ob_get_contents();
			log2file('bx24SyncTaskAdd', $log);
		}
	}

}
