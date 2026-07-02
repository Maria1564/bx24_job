<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
header('Content-Type: application/json');

$managrs = Helper::getManagers();
$clickItem = $_REQUEST['clickItemFunctionName'];
$selectedManager = $_REQUEST['selectedManager'];
//l($managrs);
$html .= '<input type="text" name="name" placeholder="Поиск">';
$html .= '<table class="table">';

foreach ($managrs as $id =>$manager) {
	$html .= '<tr '.($selectedManager==$id?'class="selected"':'').'>
      <td >' . $id . '</td>
      <td >' . $manager['FIO'] . '</td>
<td><button type="button" onclick="'.$clickItem.'(' .$id. ')'.';" class="btn btn-xs btn-primary"> выбрать</button></td>
    </tr>';
}
$html .= '</table>';
echo json_encode(['code' => 200, 'data' => $_REQUEST, "title" => "Выберите менеджера", "body" => $html]);

