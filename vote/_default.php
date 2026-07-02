<?
	$code = $_REQUEST['h'];
	$id ='';
	$words = "qwertyuiopasdfghjklzxcvbnm";
	for($i = 1; $i < strlen($code)-1; $i++ ){
		$k = $code[$i];
		$pos = strpos($words,$k);
		$id.=$pos;
	}
	
	$taskId = (int)$id;
	//проверяем поставлена ли оцека.
	
	//	l($raiting);
	//получаем клиента.
	//$arService = Service::getServiceByBx24Id($taskId);
	$arService = Service::getServiceById($taskId);
	//l($arService);
	$serviceID = $arService['ID'];
	$raiting = new Raiting();
	$raiting = $raiting->getServiceRaitingArray($serviceID);
//	l($raiting);
	
	if($raiting['UF_RAITING']>0){
	?>
	
	<center>Ваша оценка: <?=$raiting['UF_RAITING']?></center>
	
	<?
	return;
	}
	
?>
<form method="post">
	<center><h3>Оцените по 10-бальной шкале оказанную услугу</h3></center>
	<input  type="hidden" name="act" value="send">
	<input  type="hidden" name="taskId" value="<?=$taskId?>">
	<input  type="hidden" name="serviceId" value="<?=$serviceID?>">
	<div class="inp-item">
		<div class="label">Ваша оценка от 1 до 10:</div>
		<div>
			<select name="vote" required>
			    <option value="">Выберите оценку</option>
				<?for($i=1; $i<=10;$i++):?>
				<option value="<?=$i?>"><?=$i?></option>
				<?endfor?>
			</select>
		</div>
	</div>
	<div class="inp-item">
	   <label>Комментарий (не обязательно)</label>
		<textarea name="text" placeholder="Комментарий"></textarea>
	</div>
	<button class="btn-success" type="submit">Отправить</button>
</form>