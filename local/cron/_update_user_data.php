<?
	
	CModule::IncludeModule('socialservices');
	$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
	$oBitrix->setUrl(BX_WEBHOOK_URL);
	$oBitrix->setTimeout(1000);
	
	$usersArr = [];
	$task = $oBitrix->userSearch([],0);
	$usersArr = $task->result;
	$task = $oBitrix->userSearch([],50);
	$usersArr = array_merge($usersArr  ,$task->result);
	
	l(count($usersArr));
	
	//WORK_DEPARTMENT
	foreach($usersArr as $userObj){
		//$EMAIL = $user['EMAIL'];[NAME] => Денис    [LAST_NAME] => Кагарманов  [PERSONAL_PHOTO] => https://cdn-ru.bitrix24.ru/b13491102/main/9a3/9a3e2b25928e9352a0b8f53aa57f3ca2/61afdc0b5a5f6aa862145e789057b808.jpg
		
		echo PHP_EOL.'<br><br>---------------------------------<br>';
		echo 'EMAIL=>'.$userObj->EMAIL .' DEPARTAMENT = '.$userObj->UF_DEPARTMENT[0];
		//l($userObj->UF_DEPARTMENT);
		if(strlen($userObj->EMAIL)>5){
		  
			$sql = CUser::GetList(($by = "id"), ($order = "desc"), ["=EMAIL" =>$userObj->EMAIL]);
			if($arUser = $sql->Fetch()){
				
				echo ' найден пользователь '.$arUser['ID'];
				$user = new CUser;
			    $fields = Array(
				"UF_BX24_USER_ID" =>$userObj->ID,
				"WORK_DEPARTMENT" =>$userObj->UF_DEPARTMENT[0],
			    );
				$user->Update($arUser["ID"], $fields);
			}
			else{
				echo 'не найден. Создаю нового '.$userObj->EMAIL;
				$arResult = $USER->Register($userObj->EMAIL, $userObj->NAME, $userObj->LAST_NAME, $userObj->EMAIL, $userObj->EMAIL, $userObj->EMAIL);
				if (isset($arResult["ID"])) {
					CUser::SetUserGroup($arResult["ID"], [5]);
					//UF_BX24_USER_ID
					$user = new CUser;
					$fields = Array(
				    "UF_BX24_USER_ID" =>$userObj->ID,
					"WORK_DEPARTMENT" =>$userObj->UF_DEPARTMENT[0],
					);
					$user->Update($arResult["ID"], $fields);
					//$USER->Authorize($arResult["ID"],true);
				} 
			}
		}
		else {
			
			echo '<br>'.$userObj->EMAIL.' | '.$userObj->NAME.' | '.$userObj->LAST_NAME.' | '.$userObj->EMAIL;
		}
		
	}	