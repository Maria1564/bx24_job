<?
	require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

	//https://bx24.arbko.ru/api/comment/index.php?PLACEMENT_OPTIONS={%22taskId%22:%224686%22}
	if($_REQUEST['PLACEMENT_OPTIONS']){
	$arr = json_decode($_REQUEST['PLACEMENT_OPTIONS'],true);
	$taskId = $arr['taskId'];
	}
	else {
	$taskId = $_REQUEST['taskId'];
	}
	if(!$taskId){
	  die("Неправильный ID");
	}
	$act = $_REQUEST['act'];	
	$taskCommentsArr = getTaskCommets($taskId);

	
	
	switch($act){
		case "add":
		include '_add.php';
		break;
		
		case "save":
		include '_save.php';
		break; 
		default:
		include '_default.php';
		break;
	}
//l($taskCommentsArr);
?>

<style>
	* {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;}
		.warning {    border: 1px solid red;
    background: #fbe8e8;
    width: 477px;}
	.warning h3 {text-align:center;}
	.warning table {}
	.warning table td{padding: 5px;
    border: 1px solid #ccc;}
	body {color: #535c69;
    font: 14px/22px "Helvetica Neue",Helvetica,Arial,sans-serif;}
	input {padding: 5px;}
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
	.name {
    border-bottom: 1px solid transparent;
    font-size: 13px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    margin-right: 7px;
	}
	.item {
    position: relative;
    padding: 7px 21px 7px 15px;
    max-width: 820px;
    border-radius: 23px;
    background-color: #edf1f3;
    box-sizing: border-box;
    overflow: hidden;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	margin-bottom:10px
	}
	.text {
    clear: both;
    font-size: 13px;
    line-height: 18px;
    margin-right: -21px;
    overflow: hidden;
    position: relative;
    color: #333;
	margin-top:8px;
	margin-bottom:8px;
	}
	.date { color:#ccc}
	.btn-a {
    color: #828b95;
    cursor: pointer;
    display: inline-block;
    font-size: 12px;
    line-height: 12px;
    vertical-align: top;
}
.btns {}
</style>
<?
	
	function getTaskCommets($taskId){		
		$oBitrix = new \Zloykolobok\Bitrix24\Classes\Task();
		$oBitrix->setUrl(BX_WEBHOOK_URL);
		$oBitrix->setTimeout(1000);
		$arResult = [];
		$taskR = $oBitrix->getComments($taskId);
		$result = $taskR->result;
		foreach($result as &$c){
			$c->TASK_ID = $task->ID;		
		}
		return $result;
	}
	
	
