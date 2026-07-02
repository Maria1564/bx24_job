<?
		function getTaskCommets2(){		
		$json = file_get_contents('commets2.json');
		if($json!=""){return json_decode($json,true);			}
		echo '<p style="color:red">do request</p>';
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		$oBitrix->setUrl(BX_WEBHOOK_URL_KALOBL);
		$oBitrix->setTimeout(1000);
		$arResult = [];
		$start = 0;
		$arTasks = getKOtasks('task2');
		foreach($arTasks as $task){
			//l($task);
			$taskR = $oBitrix->getComments($task->ID);
			$result = $taskR->result;
			foreach($result as &$c){
			$c->TASK_ID = $task->ID;
			}			
			$arResult = array_merge($arResult,$result);			
			//break;
		}		
		l(count($arResult));
		file_put_contents('commets2.json',json_encode($arResult));
		
		
	}
		function addTask2(){
		$arUserBridge =  getUserBridge();
		$arTasks = getKOtasks('task2',['RESPONSIBLE_ID'=>[493,1007],"GROUP_ID"=>101, /*,'REAL_STATUS'=>4*/ ],true);		
		$json = file_get_contents('task2.bridge.json');
		if($json!=""){
			$arBridge =  json_decode($json,true);
			
		}
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(1000);

		
		foreach($arTasks as $task){					
			$arT  = (Array)$task;
			if($arBridge[$arT['ID']]>0){
				echo '<br>пропускаем задачу с ID '.$arT['ID'];
				continue;
				
			}
			$arT['UF_AUTO_817942750407'] = $arT['ID'];
			$idTask =  $arT['ID'];
			unset($arT['ALLOWED_ACTIONS']);unset($arT['ID']);unset($arT['DESCRIPTION_IN_BBCODE']);unset($arT['REAL_STATUS']);
			unset($arT['RESPONSIBLE_NAME']);unset($arT['RESPONSIBLE_LAST_NAME']);unset($arT['RESPONSIBLE_SECOND_NAME']);unset($arT['CREATED_BY_NAME']);unset($arT['CREATED_BY_LAST_NAME']);unset($arT['CREATED_BY_SECOND_NAME']);unset($arT['STATUS_CHANGED_BY']);unset($arT['STATUS_CHANGED_DATE']);unset($arT['GUID']);unset($arT['VIEWED_DATE']);  unset($arT['FAVORITE']);  unset($arT['SUBORDINATE']);  unset($arT['MULTITASK']);  unset($arT['CHANGED_BY']);unset($arT['CHANGED_DATE']);
			unset($arT['FORKED_BY_TEMPLATE_ID']);unset($arT['FORUM_ID']);unset($arT['SITE_ID']);unset($arT['TIME_SPENT_IN_LOGS']);
			unset($arT['ALLOW_TIME_TRACKING']);unset($arT['MATCH_WORK_TIME']);unset($arT['ADD_IN_REPORT']);unset($arT['FORUM_TOPIC_ID']);unset($arT['COMMENTS_COUNT']);unset($arT['STAGE_ID']);unset($arT['START_DATE_PLAN']);unset($arT['END_DATE_PLAN']);unset($arT['ADD_IN_REPORT']);unset($arT['FORUM_TOPIC_ID']);unset($arT['COMMENTS_COUNT']);unset($arT['DECLINE_REASON']);unset($arT['PARENT_ID']);unset($arT['DURATION_TYPE']);unset($arT['DURATION_FACT']);unset($arT['DURATION_PLAN']);unset($arT['MARK']);unset($arT['CREATED_DATE']);unset($arT['CLOSED_BY']);
			if($arT['STATUS'] < 0 ){
				$arT['STATUS'] = 6;
			}
			unset($arT['DATE_START']);
			unset($arT['CLOSED_DATE']);
			
			//	if($arT['DATE_START']=="")unset($arT['DATE_START']);
			//if($arT['CLOSED_DATE']=="")unset($arT['CLOSED_DATE']);
			//956
			//$arT['PARENT_ID'] = 956;
			$arT['CREATED_BY'] = $arUserBridge['BRIDGE'][$arT['CREATED_BY']];
			$arT['RESPONSIBLE_ID'] = $arUserBridge['BRIDGE'][$arT['RESPONSIBLE_ID']];
			//	l($arT);
			if($arT['AUDITORS']){				
				if(is_array($arT['AUDITORS'])){
					$arTemp = [];
					foreach($arT['AUDITORS'] as $idUser){
						$arTemp[] = $arUserBridge['BRIDGE'][$idUser];
					}
					$arT['AUDITORS'] =  $arTemp ;
				}
				else {
					$arT['AUDITORS'] = $arUserBridge['BRIDGE'][$arT['AUDITORS']];
				}
			}			
			if($arT['ACCOMPLICES']){				
				if(is_array($arT['ACCOMPLICES'])){
					$arTemp = [];
					foreach($arT['ACCOMPLICES'] as $idUser){
						$arTemp[] = $arUserBridge['BRIDGE'][$idUser];
					}
					$arT['ACCOMPLICES'] =  $arTemp ;
				}
				else {
					$arT['ACCOMPLICES'] = $arUserBridge['BRIDGE'][$arT['ACCOMPLICES']];
				}
			}
			
			
			$arT['GROUP_ID'] = 12;
			//	l($arT); 
			
			
			$task = $oBitrix->taskItemAdd(['fields'=>$arT]);
			$result = $task->result;
			l($result);
			if(!is_numeric($result)){
				echo '<BR>________________ERROR_______________';
				exit;
			}
			$arBridge[$idTask] = $result;
			$N++;
			file_put_contents('task2.bridge.json',json_encode($arBridge));
			if($N>10){
				
				
				echo '<script>window.location.href="/test/import/get-task.php?act=get_task&step='.($_GET['step']+1).'"</script>';
				break;
			}
			
		}
		l("DONE!!!");
		
	}
	
	function addTask(){
		$arUserBridge =  getUserBridge();
		$arTasks = getKOtasks();
		
		$json = file_get_contents('task.bridge.json');
		if($json!=""){
			$arBridge =  json_decode($json,true);
			
		}
		// l($arUserBridge);
		//10 ID_BX24_OLD  UF_AUTO_817942750407
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(1000);
		//	$task = $oBitrix->taskItemGetdata(884);
		//	$result = $task->result;
		//l($result);
		foreach($arTasks as $task){
			
			
			$arT  = (Array)$task;
			if($arBridge[$arT['ID']]>0){
				//echo '<br>пропускаем задачу с ID '.$arT['ID'];
				continue;
				
			}
			$arT['UF_AUTO_817942750407'] = $arT['ID'];
			$idTask =  $arT['ID'];
			unset($arT['ALLOWED_ACTIONS']);unset($arT['ID']);unset($arT['DESCRIPTION_IN_BBCODE']);unset($arT['REAL_STATUS']);
			unset($arT['RESPONSIBLE_NAME']);unset($arT['RESPONSIBLE_LAST_NAME']);unset($arT['RESPONSIBLE_SECOND_NAME']);
			
			unset($arT['CREATED_BY_NAME']);unset($arT['CREATED_BY_LAST_NAME']);unset($arT['CREATED_BY_SECOND_NAME']);
			unset($arT['STATUS_CHANGED_BY']);unset($arT['STATUS_CHANGED_DATE']);
			
			unset($arT['GUID']);unset($arT['VIEWED_DATE']);  unset($arT['FAVORITE']);  unset($arT['SUBORDINATE']);  unset($arT['MULTITASK']);  unset($arT['CHANGED_BY']);unset($arT['CHANGED_DATE']);
			unset($arT['FORKED_BY_TEMPLATE_ID']);unset($arT['FORUM_ID']);unset($arT['SITE_ID']);unset($arT['TIME_SPENT_IN_LOGS']);
			unset($arT['ALLOW_TIME_TRACKING']);unset($arT['MATCH_WORK_TIME']);unset($arT['ADD_IN_REPORT']);unset($arT['FORUM_TOPIC_ID']);unset($arT['COMMENTS_COUNT']);
			
			unset($arT['STAGE_ID']);unset($arT['START_DATE_PLAN']);unset($arT['END_DATE_PLAN']);unset($arT['ADD_IN_REPORT']);unset($arT['FORUM_TOPIC_ID']);unset($arT['COMMENTS_COUNT']);
			//unset($arT['CREATED_BY']);
			
			unset($arT['DECLINE_REASON']);
			unset($arT['PARENT_ID']);//!~
			
			unset($arT['DURATION_TYPE']);unset($arT['DURATION_FACT']);unset($arT['DURATION_PLAN']);unset($arT['MARK']);
			
			//	l($arT);
			unset($arT['CREATED_DATE']);
			unset($arT['CLOSED_BY']);
			if($arT['STATUS'] < 0 ){
				$arT['STATUS'] = 6;
			}
			//$time = strtotime($arT['CREATED_DATE']);
			//	$timeNew = date("c",$time);
			//$arT['CREATED_DATE'] = $timeNew;
			unset($arT['DATE_START']);
			unset($arT['CLOSED_DATE']);
			
			//	if($arT['DATE_START']=="")unset($arT['DATE_START']);
			//if($arT['CLOSED_DATE']=="")unset($arT['CLOSED_DATE']);
			//956
			//$arT['PARENT_ID'] = 956;
			$arT['CREATED_BY'] = $arUserBridge['BRIDGE'][$arT['CREATED_BY']];
			$arT['RESPONSIBLE_ID'] = $arUserBridge['BRIDGE'][$arT['RESPONSIBLE_ID']];
			//	l($arT);
			if($arT['AUDITORS']){
				
				if(is_array($arT['AUDITORS'])){
					$arTemp = [];
					foreach($arT['AUDITORS'] as $idUser){
						$arTemp[] = $arUserBridge['BRIDGE'][$idUser];
					}
					$arT['AUDITORS'] =  $arTemp ;
				}
				else {
					$arT['AUDITORS'] = $arUserBridge['BRIDGE'][$arT['AUDITORS']];
				}
			}
			
			if($arT['ACCOMPLICES']){
				
				if(is_array($arT['ACCOMPLICES'])){
					$arTemp = [];
					foreach($arT['ACCOMPLICES'] as $idUser){
						$arTemp[] = $arUserBridge['BRIDGE'][$idUser];
					}
					$arT['ACCOMPLICES'] =  $arTemp ;
				}
				else {
					$arT['ACCOMPLICES'] = $arUserBridge['BRIDGE'][$arT['ACCOMPLICES']];
				}
			}
			
			
			$arT['GROUP_ID'] = 10;
			//	l($arT); 
			
			
			$task = $oBitrix->taskItemAdd(['fields'=>$arT]);
			$result = $task->result;
			l($result);
			if(!is_numeric($result)){
				echo '<BR>________________ERROR_______________';
				exit;
			}
			$arBridge[$idTask] = $result;
			$N++;
			file_put_contents('task.bridge.json',json_encode($arBridge));
			if($N>10){
				
				
				echo '<script>window.location.href="/test/import/get-task.php?act=addtask&step='.($_GET['step']+1).'"</script>';
				break;
			}
			
		}
		l("DONE!!!");
		
	}
	
	function getUserBridge(){
		
		$json = file_get_contents('users.bridge.json');
		if($json!=""){
			return json_decode($json,true);
			
		}
		$arUser = [];
		$arTasks = getKOtasks();
		$arUsers = getKOusers();
		$arUsersNew = getNEWusers();
		foreach($arTasks as $task){
			$arT  = (Array)$task;
			$arUser[$arT['RESPONSIBLE_ID'] ] = 1;
			if(count($arT['ACCOMPLICES'])>0){
				foreach($arT['ACCOMPLICES'] as $userID){
					$arUser[$userID ] = 1;
				}
			}
			if(count($arT['AUDITORS'])>0){
				foreach($arT['AUDITORS'] as $userID){
					$arUser[$userID ] = 1;
				}
			}
		}
		
		l( $arUser);
		$arUserResult = [];
		foreach($arUser as $userID => $noUse){
			$emial = $arUsers[$userID]['EMAIL'];
			$userIDOld = $arUsers[$userID]['ID'];
			//	l($emial);
			
			$isFound = false;
			foreach($arUsersNew as $userID2 =>$ar2){
				$emialNew = $ar2['EMAIL'];
				if( strtolower($emial) == strtolower($emialNew) ){
					$arUserResult["BRIDGE"][$userIDOld] = $ar2['ID'];
					$arUserResult["DATA"][$userIDOld] = $emial.' = '.$emialNew.' '.$arUsers[$userID]['LAST_NAME'].' '.$arUsers[$userID]['NAME'];
					//   $arUser["FULL"][$userIDOld] =$arUsers[$userID];
					$isFound =true;
					break;
				}
			}
			
			if($isFound == false){
				echo '<br>no found: '.$emial.' '.$arUsers[$userID]['LAST_NAME'].' '.$arUsers[$userID]['NAME'];;
				
			}
		}
		l($arUserResult);
		
		file_put_contents('users.bridge.json',json_encode($arUserResult));
	}
	
	
	
	
	

	
	function getTaskCommets(){
		
		$json = file_get_contents('commets.json');
		if($json!=""){
			return json_decode($json,true);
			
		}
		echo '<p style="color:red">do request</p>';
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		$oBitrix->setUrl(BX_WEBHOOK_URL_KALOBL);
		$oBitrix->setTimeout(1000);
		$arResult = [];
		$start = 0;
		$arTasks = getKOtasks();
		foreach($arTasks as $task){
			//l($task);
			$taskR = $oBitrix->getComments($task->ID);
			$result = $taskR->result;
			foreach($result as &$c){
			$c->TASK_ID = $task->ID;
			}
			//l($result);
			//'	l(count($result));		
			
			$arResult = array_merge($arResult,$result);			
			//break;
		}
		
		
		l(count($arResult));
		file_put_contents('commets.json',json_encode($arResult));
		
		
	}
	
	
	
	
	
	function getNEWusers(){
		
		$json = file_get_contents('users.new.json');
		if($json!=""){
			$arT = json_decode($json);
			$arRet = [];
			foreach(	$arT  as $user){
				$ar = (array)$user;
				$arRet[$ar['ID']] = $ar;
				
			}
			return $arRet;
			
		}
		echo '<p style="color:red">do request</p>';
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(1000);
		$arResult = [];
		$start = 0;
		for($i=0; $i < 100; $i++){
			$task = $oBitrix->userSearch([],$start );
			$result = $task->result;
			
			//'	l(count($result));
			
			$arResult = array_merge($arResult,$result);
			if(count($result)<50)break;
			$start+=50;
			//sleep(5);
		}
		
		
		l(count($arResult));
		file_put_contents('users.new.json',json_encode($arResult));
		
		
	}
	
	
	
	function getKOusers(){
		
		$json = file_get_contents('users.json');
		if($json!=""){
			$arT = json_decode($json);
			$arRet = [];
			foreach(	$arT  as $user){
				$ar = (array)$user;
				$arRet[$ar['ID']] = $ar;
				
			}
			return $arRet;
			
		}
		echo '<p style="color:red">do request</p>';
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\User();
		$oBitrix->setUrl(BX_WEBHOOK_URL_KALOBL);
		$oBitrix->setTimeout(1000);
		$arResult = [];
		$start = 0;
		for($i=0; $i < 100; $i++){
			$task = $oBitrix->userSearch([],$start );
			$result = $task->result;
			
			//'	l(count($result));
			
			$arResult = array_merge($arResult,$result);
			if(count($result)<50)break;
			$start+=50;
			//sleep(5);
		}
		
		
		l(count($arResult));
		file_put_contents('users.json',json_encode($arResult));
		
		
		
	}
	
	
	
	/*
	  tasks
	  ["GROUP_ID"=>216,]
	*/
	function getKOtasks($dbName = 'tasks_1',$filer = [],$isUseCache = true){	
		$json = file_get_contents($dbName.'.json');
		if($json!="" && $isUseCache){
			return json_decode($json,true);			
		}
		echo '<p style="color:red">do request</p>';
		l($filer);
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		$oBitrix->setUrl(BX_WEBHOOK_URL_KALOBL);
		$oBitrix->setTimeout(1000);
		$arResult = [];
		$start = 0;
		for($i=0; $i < 100; $i++){
		echo '<br>$i = '.$i;
			$task = $oBitrix->getList(["ID"=>"DESC"],$filer,[],$start );
			$result = $task->result;
			
			//'	l(count($result));
			
			$arResult = array_merge($arResult,$result);
			if(count($result)<50){
			  l('break/////////');
			  break;
			  
			}
			$start+=50;
			//sleep(5);
		}				
		l(count($arResult));
		l($arResult);
		file_put_contents($dbName.'.json',json_encode($arResult));						
	}						