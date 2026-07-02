<?php

/*
 * 
 */

class Manager {

	const CLIENT_IBLOCK_ID = 1;

	/**
	 * Возвращает  данные клиента
	 * @param type $client_id
	 * @return type array
	 */
	public static function getManagerData($id = 0) {
		global $USER;
		if($id == 0){
			$id = $USER->GetID();
		}
		
		$dbUser = CUser::GetByID($id);
		$arUser = $dbUser->Fetch();
		l($arUser);
		return $arUser;
	}

	public static function add($arr) {
		self::checkSessionData();
		global $USER;
		if (!$USER->IsAuthorized()) {
			$_SESSION['USER_FAVORITE'][$arr['id']] = ['type' => $arr['type']];
		} else {
			//Получаем массив данных.
			$userData = new CUserData();
			$data = $userData->get('FAVOR');
			// если нет, то добавляем в массив
			$data[$arr['id']] = ['type' => $arr['type']];
			$userData->add('FAVOR', $data);
		}
	}

}
