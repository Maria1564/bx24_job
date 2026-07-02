<?
	$arr = json_decode($_REQUEST['PLACEMENT_OPTIONS'],true);
	$taskId = $arr['taskId'];
	
	//получаем клиента.
	$arService = Service::getServiceByBx24Id($taskId);
	if(!$arService){
	   include '_service_not_found.php';
	   return;
	
	}
	$serviceID = $arService['ID'];
	$taskId = $arService['ID'];
	$clientID = $arService['PROPERTIES']['CLIENT']['VALUE'];
	
	//проверяем поставлена ли оцека.
	$raiting = new Raiting();
	$raiting = $raiting->getServiceRaitingArray($serviceID);

	
	$arClient = Client::getClientById($clientID);
	$bx24CompanyId = $arClient['PROPERTIES']['BX24_COMPANY_ID']['VALUE'];
	//l($arClient);
	$clientPhone = $arClient['PROPERTIES']['PHONE']['VALUE'];

	//Кодируем 
	$words = "qwertyuiopasdfghjklzxcvbnm";	
	$hash = $words[rand(0,strlen($words)-1)];
	for($i = 0; $i < strlen($taskId); $i++ ){
	$k = $taskId[$i];
	     $hash.=$words[$k];	
	}
	$hash.= $words[rand(0,strlen($words)-1)];
	$link ='https://bx24.arbko.ru/vote/?h='.$hash;
	if($bx24CompanyId > 0){	
	  $arContacts = getCompayContacts($bx24CompanyId);
	  //Получаем доп. контакты из системы
	 $arContacts2 =  Contact::getClientContacts($clientID);
	// l($arContacts);
	 foreach($arContacts2 as $cont){
	   $arContacts[] = [
		"PHONE"=>$cont['PHONE'],
	   "NAME"=>$cont['NAME'].' ('.$cont['PREVIEW_TEXT'].')',
	   ];
	 }
	  
	}
	//l($arContacts );
?>
<?if($raiting['ID'] >0 && $raiting['UF_RAITING']==0):?>
<br>
SMS клиенту  уже отправлен <?=date('d:m:Y H:i:s',$raiting['UF_SMS_SEND_DATE'])?>. Но клиент еще оценку не поставил. При желании можете отправить еще!
<br><br>
<?endif?>
<?if($raiting['UF_RAITING'] >0):?>
<div class="warning">
	<h3>Этой услуге оценка поставлена.</h3>
	<table>
		<tr>
	    <td>Оценка</td>
	    <td><?=$raiting['UF_RAITING']?></td>
	  </tr>
	   <tr>
	    <td>Комментарий</td>
	    <td><?=$raiting['UF_SMS_TEXT']?></td>
	  </tr>
	   <tr>
	    <td>Дата отправки</td>
	    <td><?=date('d:m:Y H:i:s',$raiting['UF_SMS_SEND_DATE'])?></td>
	  </tr>
	  
	   <tr>
	    <td>Дата оценки</td>
	    <td><?=date('d:m:Y H:i:s',$raiting['UF_SMS_VOTE_DATE'])?></td>
	  </tr>
	  
	   <tr>
	    <td>Номер</td>
	    <td><?=$raiting['UF_SMS_NUMBER']?></td>
	  </tr>
	  
	</table>
</div>

<?endif?>
<script type="text/javascript" async="" src="https://yastatic.net/jquery/3.1.1/jquery.min.js?ver=2.2"></script>

<div class="send-form">
	<h1>Отправка смс клиенту: <span><?=$arClient['~NAME']?></span></h1>
<form action="">
	 <input  type="hidden" name="act" value="send">
	 <input  type="hidden" name="serviceID" value="<?=$serviceID?>">
	  <input  type="hidden" name="taskId" value="<?=$taskId?>">
	 <input  type="hidden" name="link" value="<?=$link?>">
	 
	<table>
	    <tr> <td>Ссылка: </td>  <td> <span class="link"><?=$link?></span></td></tr>
	   <tr> 
		    <td>Номер телефона: </td>  
			<td>
			  <span > <input  type="text" id="phone" name="phone" class="phone" value="<?=$clientPhone?>"></span> 
			 <?if(count($arContacts)>0):?>
			 <br><br>
			  Выбрать из списка:
			  <select onchange="$('#phone').val($(this).val() )">
			    
				<option value="<?=$clientPhone?>"> <?=$clientPhone?> Основной контакт</option>
				<?foreach($arContacts as $contaqct):?>
				  	<option value="<?=$contaqct['PHONE']?>"> <?=$contaqct['PHONE']?> - <?=$contaqct['NAME']?> </option>
				<?endforeach?>
			   </select>
			   <?endif?>
				</td></tr>	
	</table>
	<button class="btn-send" type="submit">Отправить смс</button>
</form>
</div>

v3
<style>
	.warning {    border: 1px solid red;
    background: #fbe8e8;
    width: 477px;}
	.warning h3 {text-align:center;}
	.warning table {}
	.warning table td{padding: 5px;
    border: 1px solid #ccc;}
	body {color: #535c69;
    font: 14px/22px "Helvetica Neue",Helvetica,Arial,sans-serif;}
	input,select {padding: 5px;}
	.send-form { width: 477px;
    border: 1px solid #ccc;
    padding: 24px;
    background: #f7f7f7;}
	.send-form h1{font-size: 14px;}
	.send-form h1 span{font-size: 14px;
    color: #000;}
	table {    border-collapse: collapse;}
	table td {padding: 9px;}
	.btn-send {    background: #b4e724;cursor:poiter;
    border: none;
    padding: 11px 13px;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 12px;
    margin-top: 23px;
    margin-left: 103px;}
	.link {color: #1f67b0;}
	span.phone {    font-weight: bold}
</style>