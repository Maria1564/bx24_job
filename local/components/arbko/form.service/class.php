<?
	
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
	use Bitrix\Main\Loader;
	
	Loader::includeModule("highloadblock");
	
	use Bitrix\Highloadblock as HL;
	
	class ServiceComponent extends CBitrixComponent {
		
		private function addItems() {
			if (!isset($_POST['NAME']))
			return;
			if($_REQUEST['DATE']){
				$s = strtotime($_REQUEST['DATE']);
			}
			else {
				$s = time();
			}
			//l($_REQUEST);exit;
			if($_REQUEST['DATE_ACTIVE_FROM']==""){
				//$_REQUEST['DATE_ACTIVE_FROM'] = date('d.m.Y', $s) . ' ' . $_REQUEST['TIME'];
			}
			if($_REQUEST['DATE']!=""){
				$_REQUEST['DATE_ACTIVE_FROM'] = date('d.m.Y', $s) . ' ' . $_REQUEST['TIME'];
			}
			//DATE_ACTIVE_TO
			if($_REQUEST['DATE_END']!=""){
				$s = strtotime($_REQUEST['DATE_END']);
				$_REQUEST['DATE_ACTIVE_TO'] =  date('d.m.Y', $s) . ' ' . $_REQUEST['TIME_END'];
			}
			//CREATED
			// ������� �����������? PROPERTY[BX24_STATUS_EXT]
			
			if($_REQUEST['DATE_END']){
				$_REQUEST['PROPERTY']['STATUS'] =   Service::STATUS_CLOSED;		
			}
			else 
			{
				$_REQUEST['PROPERTY']['STATUS'] =   Service::STATUS_ACTIVE;		
			}
			
			$_REQUEST['PROPERTY']['CREATED'] = "SITE";
			if(isset($_REQUEST['ADD_TASK_TO_B24'])){
				$_REQUEST['PROPERTY']['CREATED'] = "SITE_AND_ADD_TO_BX24";
			}
			//��������� ����������
			if(!isset($_REQUEST['PROPERTY']['CLIENT_REFUSED'])){
				$_REQUEST['PROPERTY']['CLIENT_REFUSED'] = "";
			}
			if(!isset($_REQUEST['PROPERTY']['BX24_STATUS_EXT'])){
				$_REQUEST['PROPERTY']['BX24_STATUS_EXT'] = "";
			}
			else {
				//������� �����������? PROPERTY[BX24_STATUS_EXT] == 1
				if($_REQUEST['DATE_END']==""){
					$s = strtotime(time());
					$_REQUEST['DATE_ACTIVE_TO'] =  date('d.m.Y H:i:s');
				}	
				$_REQUEST['PROPERTY']['STATUS'] =   Service::STATUS_CLOSED;	
			}
			
			//l($_REQUEST);exit;
			session_start();
			$_SESSION['IGNORE_WEBHOOK'] = "Y";
			$arResutl = Service::save($_REQUEST);
			l($arResutl);
			$this->arResult["error"] = $arResutl['error'];
			if($this->arResult["error"]!=""){
				return false;
			}
			if ($arResutl['newRecord']) {
				
			}
			if (isset($_POST['BTN_UPDATE'])){
				header('location:/service/' . $arResutl['ID'] . '/');
				header('location:/service/edit/?id=' . $arResutl['ID'] . '&success=y');
				exit;
			}
			
			//header('location:?id=' . $arResutl['ID'].'&success=y');
			header('location:/service/edit/?id=' . $arResutl['ID'] . '&success=y');
		}
		
		public function executeComponent() {
			global $USER;
			$this->addItems();
			if ($_REQUEST['id'] > 0) {
				$this->arResult["CLIENT"] = Service::getServiceById($_REQUEST['id']);
				$this->setData($this->arResult["CLIENT"]);
				if($_GET['t'] == 1){
					//	l($this->arResult["CLIENT"]['PROPERTIES']['DIRECTION'] );
				}
				//l($this->arResult["CLIENT"] );
			}
			if ($_REQUEST['client_id'] > 0) {
				$this->arResult["CLIENT"] = Client::getClientById($_REQUEST['client_id']);
			}
			if ($this->startResultCache()) {
				
				$this->includeComponentTemplate();
			}
		}
		
		public function setData($arInput) {
			//l($arInput);
			$_REQUEST['NAME'] = $arInput['NAME'];
			$_REQUEST['PREVIEW_TEXT'] = $arInput['PREVIEW_TEXT'];
			
			$s = strtotime($arInput['DATE_ACTIVE_FROM']);
			$_REQUEST['DATE'] = date('Y-m-d', $s); 
			$_REQUEST['TIME'] = date('H:i', $s); 
			
			if($arInput['DATE_ACTIVE_TO']){
				$s = strtotime($arInput['DATE_ACTIVE_TO']);
				$_REQUEST['DATE_END'] = date('Y-m-d', $s); 
				$_REQUEST['TIME_END'] = date('H:i', $s); 
			}
			foreach ($arInput['PROPERTIES'] as $code => $arr) {
				$_REQUEST['PROPERTY'][$code] = $arr['VALUE'];
			}
			$_REQUEST['client_id'] = $arInput['PROPERTIES']['CLIENT']['VALUE'];
		}
		
	}
	
?>				
