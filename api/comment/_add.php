<?
	
	
	
	/*
		|
		| 1. получаем услугу
		| 2. проверяем, была ли создана для этой услуни консультация (BX24_COMMENT_ID)
		| 3. Если нет, то выводим форму, гду можно указать время консультации
		| 4. Создаем консультацию, в BX24_COMMENT_ID записываем ID коментария
		|
	*/
	
    //Получаем услугу по BX24_ID
	$arService = Service::getServiceByBx24Id($taskId);
	$commentText = "";
	foreach($taskCommentsArr as $commentObj){
	  if($commentObj->ID == $_REQUEST['comment_id']){
	      $commentObj->POST_MESSAGE = preg_replace("'\[QUOTE\].*?\[/QUOTE\]'si","", $commentObj->POST_MESSAGE);
	      $commentText = $commentObj->POST_MESSAGE;
		  break;
	  }
	}
	$comment_id = $_REQUEST['comment_id'];
	
	//Проверяем. есть ли консультация по этому комментарию.
	$rsItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => IBLOCK_ID_SERVICE, "PROPERTY_BX24_COMMENT_ID" => $comment_id), false, false, array());
	$arItem = $rsItems->GetNext();
	//Если есть выводим ссылку на уже созданную консультацию
	if($arItem){
	echo '<h1>Консультация для этого комментария уже создана</h1>';
	 echo '<a target="_blank" href="https://bx24.arbko.ru/consult/'.$arItem['ID'].'/">перейти на страницу консультации</a>'; 
	 exit;
	}
	
	

?>
<div class="send-form">
	<h1>Создание консультации</h1>
	<form action="" method="post">
		<input  type="hidden" name="act" value="save">
		<input  type="hidden" name="taskId" value="<?=$taskId?>">		
		<label>Название</label>
		<input  type="text" name="name" value="Консультация для услуги - <?=$arService['NAME']?>">
		<label>Текст</label>
		<textarea name="text" ><?=$commentText?></textarea>
		<label>Дата</label>
		<input type="date" class="form-control" name="date" style="width: 150px;" value="<?=date("Y-m-d")?>">
		<button class="btn-send" type="submit">Создать консультацию</button>
	</form>
</div>

<style>
	.send-form {}
	.send-form label {display: block;
    margin-top: 18px;}
	.send-form input{display:block;width:100%;}
	.send-form textarea{display:block;width:100%;min-height:100px;}
</style>
<?
		//l($taskCommentsArr);
	//
//l($arService);