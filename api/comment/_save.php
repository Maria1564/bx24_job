<?
	$arService = Service::getServiceByBx24Id($taskId);

	$comment_id = $_REQUEST['comment_id'];
	
	//Проверяем. есть ли консультация по этому комментарию.
	$rsItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "PROPERTY_BX24_COMMENT_ID" => $comment_id), false, false, array());
	$arItem = $rsItems->GetNext();
	//Если есть выводим ссылку на уже созданную консультацию
	if($arItem){
	echo '<h1>Консультация для этого комментария уже создана</h1>';
	 echo '<a target="_blank" href="https://bx24.arbko.ru/consult/'.$arItem['ID'].'/">перейти на страницу консультации</a>'; 
	}
	//Если нет, то создаем. И после показываем ссылку на консультацию
	else {
	
	     $arInput = [
		 "NAME"=>$_REQUEST['name'],
		 "PREVIEW_TEXT"=>$_REQUEST['text'],
		 "DATE_ACTIVE_FROM"=> date('d.m.Y',strtotime($_REQUEST['date'])),
		 "PROPERTY"=>[
		    "BX24_COMMENT_ID"=>$comment_id,
			"TYPE"=>Service::TYPE_CONSALT_ID,
			"SERVICE"=>$arService['ID'],
			"CLIENT"=>$arService['PROPERTIES']['CLIENT']['VALUE'],
			"MANAGER"=>$arService['PROPERTIES']['MANAGER']['VALUE'],
		 ],
		 ];
	     $arResutl = Service::save( $arInput );
		 echo '<h1>Консультация создана</h1>';
	    echo '<a target="_blank" href="https://bx24.arbko.ru/consult/'.$arResutl['ID'].'/">перейти на страницу консультации</a>'; 
	
	}

?>

<?
