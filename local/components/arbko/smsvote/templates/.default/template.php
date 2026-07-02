<?
	
	$raiting = new Raiting();
	$raiting = $raiting->getServiceRaitingArray($arParams['ID']);
//	l($serviceRaiting);
?>
<?if($raiting['ID'] >0 && $raiting['UF_RAITING']==0):?>
<br>
SMS клиенту  уже отправлен <?=date('d:m:Y H:i:s',$raiting['UF_SMS_SEND_DATE'])?>. При желании можете отправить еще!
<br><br>
<?endif?>
<?if($raiting['UF_USER_VOTE'] >0):?>
<div class="warning warning-table">
	<h3>Смс оценка.</h3>
	<table>
		<tr>
	    <td>Оценка</td>
	    <td><?=$raiting['UF_USER_VOTE']?></td>
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
<iframe id="sms-vote-iframe" src="https://bx24.arbko.ru/api/sms/index.php?type=consult&id=<?=$arParams['ID']?>" style="width:600px; height:400px; border:none;display:none"></iframe>
