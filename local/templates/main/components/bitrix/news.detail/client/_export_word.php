<div id="word-content" style="display:none;    font-size: 13px;">
	<h3>Информация:</h3>
	<? include '_inform.php'?>
	
	<h3>Дополнительная информация</h3>
	<table style="width:auto">
	<tr>	    <td>Рейтинг доверия</td>   <td><?= $middleRaiting ?></td></tr>		
	<tr>	    <td>Консультаций оказано</td>   <td><?= $consultCount ?></td></tr>		
	<tr>	    <td>Услуг оказано</td>   <td> <?=Client::getServiceCountDone($arResult['ID'])?></td></tr>		
	
	<tr>	<td>Денег получено</td>	 <td> <? if ($clientMOneyCount > 0): ?> <?=number_format($clientMOneyCount, 0,'', ' ' ) ?> руб.<? endif ?></td></tr>		
	 </table> 
	   
	
	<h3>Оказанные услуги:</h3>
	<table style="font-size:12px;">
	<tr style="font-size:12px;">	    
		<td>Дата</td>
		<td>Тип/Статус</td>
	
		
		<td>Название</td>
		<td>Oтветственный</td>
		<td>Сумма</td>
		<td>Итоговый комментарий </td>
		<td>Оценка</td>
	   </tr>
	<? foreach ($allServices as $i => $ar):
		//if($ar['TYPE'] == 'CONSULT')continue;
		?>
		
		<?
		$taskStatusText = '';
		   if($ar['BX24_STATUS_EXT'] == 1){
		   $taskStatusText = 'завершен успешно';		   
	       }
	     if(
		   $ar['TYPE']  != 'CONSULT' && 
		   $ar['STATUS'] == Service::STATUS_CLOSED && 
		   $ar['BX24_STATUS_EXT'] != 1){
		   $taskStatusText = 'завершен неуспешно';		   
	   }
	   if($taskStatusText==""){
	     $taskStatusText=$ar['STATUS_TEXT'];
	   }
		
		
		?>
	   <tr style="font-size:12px;" class="item-<?=$ar['TYPE']== 'CONSULT'?'consult':'service'?>" >
	    <td><?= $ar['DATE'] ?></td>
		<td><?= $ar['TYPE'] == 'CONSULT'?'Консульт.':'Услуга' ?> <br> <?= $taskStatusText ?></td>
		

		<td><?= $ar['NAME'] ?></td>		
		<td><?= $allManagers[$ar['MANAGER_ID']]['FIO'] ?></td>
		<td> <? if ($ar['MONEY'] > 0): ?><span><?=number_format($ar['MONEY'], 0,'', ' ' ) ?></span> руб.<? endif ?></td>
		<td><?= $ar['~PREVIEW_TEXT'] ?>
		   <?if( strlen($ar['BX24_WHAT_DO']) > 1):?>
		   <br>
		   <b>Что было сделано:</b>
		   <p><?= $ar['BX24_WHAT_DO'] ?></p>
		   
		   <?endif?>
		</td>
		
		<td>
		  <? /*****************/?>
		  
		  <? //l($ar['SMS_RAITING'])?>
			<? if ($ar['SMS_RAITING']): ?>
				<?if($ar['SMS_RAITING']['UF_USER_VOTE']>0):?>
			
					<table class="sms-table">
						<tr style="font-size:12px;"><td> Смс оценка клиента: </td><td> <?= $ar['SMS_RAITING']['UF_USER_VOTE'] ?></td></tr>
						<tr style="font-size:12px;"><td> Комментарий: </td><td> <?= $ar['SMS_RAITING']['UF_SMS_TEXT'] ?></td></tr>
						<tr style="font-size:12px;"><td>   Время отправки смс:  </td><td> <?=date('d:m:Y H:i:s',$ar['SMS_RAITING']['UF_SMS_SEND_DATE'])?></td></tr>
						<tr style="font-size:12px;"><td>  Время оценки :  </td><td> <?=date('d:m:Y H:i:s',$ar['SMS_RAITING']['UF_SMS_VOTE_DATE'])?></td></tr>
					</table>
			
				<?else:?>
					<span class="tl-info-title">Клиенту отправлен смс <?=date('d:m:y H:i:s',$ar['SMS_RAITING']['UF_SMS_SEND_DATE'])?>, но оценка не поставлена:</span>
					<span class="tl-user"><?= $ar['SMS_RAITING']['UF_USER_VOTE'] ?></span>
				<?endif?>
			<?else:?>
			нет
			<? endif ?>
		</td>
	   </tr>
	<? endforeach ?>
	</table>
	<style>
	#word-content table * {font-size:10px;}
	</style>
</div>

<? //l($allServices)?>
