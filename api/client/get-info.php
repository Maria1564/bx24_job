<?php
/*
 * Получаем данные о контрагенте
 * 
 */
//require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
$client_id = $_REQUEST['client_id'];

if ($client_id > 0) {
	$client = Client::getClientById($client_id);
	$inn = $client['PROPERTIES']['INN']['VALUE'];
	/*
	  if (strlen($inn) > 5) {
	  $dadata = new Dadata(DADATA_API_KEY);
	  $dadata->init();
	  $fields = array("query" => $inn, "count" => 1);
	  $result = $dadata->suggest("party", $fields);
	  log2file('$result', $result);
	  $dadata->close();
	  } else {
	  $message = "У клиента не указан ИНН";
	  }
	 * 
	 */
} else {
	exit;
}
?>

<h3>Сервисы проверки контрагентов</h3>
<? if (strlen($inn) > 5): ?>
	<ul>
	    <li>
		<a href='https://www.rusprofile.ru/search?query=<?= $inn ?>' target='_blank'>Предоставление сведений из rusprofile</a> </li>
	    <li><a href='https://egrul.nalog.ru/index.html?query=<?= $inn ?>' target='_blank'>Предоставление сведений из ЕГРЮЛ/ЕГРИП</a> </li>
	    <li><a href='https://pb.nalog.ru/search.html#quick-result?query=<?= $inn ?>' target='_blank'>Сервис Прозрачный бизнес</a></li>
	</ul>
<? else: ?>  
Не указан или не корректный ИНН.
<a href='https://www.rusprofile.ru/search?query=<?= $client['NAME'] ?>' target='_blank'>Искать на сайте rusprofile</a> 

<? endif ?>
<?
if (count($result['suggestions']) > 0) {
	$arr = $result['suggestions'][0];
	?>

	<h3>Данные из сервиса https://dadata.ru/</h3>
	<table class='table table-striped'>
	    <tr><td>Наименование</td><td><?= $arr['data']['name']['full'] ?></td></tr>
	    <tr><td>ИНН</td><td><?= $arr['data']['inn'] ?></td></tr>
	    <tr><td>ОГРН</td><td><?= $arr['data']['ogrn'] ?></td></tr>
	    <? if ($arr['data']["type"] != "INDIVIDUAL"): ?>
		    <tr><td>Руководитель</td><td> <?= $arr['data']['management']['name'] ?></td></tr>
	    <? endif ?>
	</table><br/><br/>
	<?
}
