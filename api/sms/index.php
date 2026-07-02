<?
	require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
	$act = $_REQUEST['act'];
	log2file('sms',$_REQUEST);
	
	
	if($_REQUEST['type'] =='deal'){
		switch($act){
			case "send":
			include '_send.php';
			break;
			
			
			default:
			include '_default_deal.php';
			break;
		}
	}
	else if($_REQUEST['type'] =='consult'){
		switch($act){
			case "send":
			include '_send.php';
			break;
			
			
			default:
			include '_default_consult.php';
			break;
		}
	}
	else {
		switch($act){
			case "send":
			include '_send.php';
			break;
			
			
			default:
			include '_default.php';
			break;
		}
	}
?>


<?
	
	//l($_REQUEST);
	
?>
