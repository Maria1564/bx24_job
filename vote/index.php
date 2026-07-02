<?
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");	
	$act = $_REQUEST['act'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>Оценка услуги</title>
		<link href="/local/templates/main/css/vote.css?ver=3" type="text/css" rel="stylesheet">
	</head>
	<body>
		
		<div class="container">
			<?if($act=='send'):?>
			
			<?include '_send.php'?>
			
			<?else:?>
			<?include '_default.php'?>
			<?endif?>
		</div>
	</body>
</html>				