<?php

/*
 * Класс для  реализации функционала изрбранное
 */

class CFavor {
	/*
	 * Возвращает изрбанные обьекты для автоизованного и 
	 * не авторизованного пользователя
	 */

	public static function getList() {
		self::checkSessionData();
		global $USER;
		if (!$USER->IsAuthorized()) {
			return $_SESSION['USER_FAVORITE'];
		} else {
			$userData = new CUserData();
			return $userData->get('FAVOR');
		}
	}

	/*
	 * Проверяет избранные товары в сессии  если есть
	 * до обновляет хранилище в бд при авторизации пользователя
	 */

	private static function checkSessionData() {
		global $USER;

		if ($USER->IsAuthorized()) {
			$userData = new CUserData();
			$data = $userData->get('FAVOR');
			foreach ($_SESSION['USER_FAVORITE'] as $id => $arr) {
				$data[$id] = $arr;
			}
			$userData->add('FAVOR', $data);
			unset($_SESSION['USER_FAVORITE']);
		}
	}

	/*
	 * Удланеие
	 */

	public static function remove($arr) {
		self::checkSessionData();
		global $USER;

		if (!$USER->IsAuthorized()) {
			$_SESSION['USER_FAVORITE'][$arr['id']] = null;
		} else {
			$userData = new CUserData();
			$data = $userData->get('FAVOR');
			// если нет, то добавляем в массив
			$arTemp = [];
			foreach ($data as $id => $arr2) {
				if ($id == $arr['id'])
					continue;
				$arTemp[$id] = $arr2;
			}

			$userData->add('FAVOR', $arTemp);
		}
	}

	/*
	 * Добавление
	 */

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
