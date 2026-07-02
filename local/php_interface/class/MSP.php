<?php
	
	/*
		* Проверка контрагента на принадлежность к мсп
	*/
	
	class MSP {
		
		var $log = false;
		var $inn = 0;
		
		function __construct($inn=false) {
			$this->inn = $inn;
		}
		
		
		function isMSP(){
			$retArr = ['IS_MSP'=>false, 'TEXT'=>''];
			$resultArr =     $this->getOrgData($this->inn);
			$this->l($resultArr['ОткрСведения']);
			if($resultArr['ОткрСведения']){
				$arr1 = (Array)$resultArr['ОткрСведения'];
				$colSotrund  = $arr1['КолРаб'];
				if($colSotrund<=15){
					$return = 'микропредприятию';
					$retArr = ['IS_MSP'=>true, 'TEXT'=>'микропредприятие'];
				}
				if($colSotrund>15 && $colSotrund <=100){
					$return = 'малое предприятие';
					$retArr = ['IS_MSP'=>true, 'TEXT'=>'малое предприятие'];
				}
			}
			return $retArr;
		}
		function getOrgData($inn){
			$key ='CHANGE_ME';
			$url = 'https://api-fns.ru/api/egr?req='.$inn.'&key='.$key;
			$result = file_get_contents($url);
			$arr = json_decode($result);	
			$ar1 = $arr->items[0];
			$resultObj = null;
			if($ar1->ЮЛ){
				$resultObj = $ar1->ЮЛ;
			}
			if($ar1->ИП){
				$resultObj = $ar1->ИП;
			}
			$resultArr = (Array)$resultObj;
			
			$resultArr['СПВЗ']="";
			$resultArr['История']="";
			$resultArr['ДопВидДеят']="";
			return $resultArr;
		}
		
		
		/*
			public function isMSP() {
			$retArr = ['IS_MSP'=>true, 'TEXT'=>'микропредприятию'];
			$resultArr =      $this->getOrgData($this->inn);
			$this->l($resultArr['ОткрСведения']);
			if($resultArr['ОткрСведения']){
			$arr1 = (Array)$resultArr['ОткрСведения'];
			$colSotrund  = $arr1['КолРаб'];
			if($colSotrund<=15){
			$return = 'микропредприятию';
			$retArr = ['IS_MSP'=>true, 'TEXT'=>'микропредприятие'];
			}
			if($colSotrund>15 && $colSotrund <=100){
			$return = 'малое предприятие';
			$retArr = ['IS_MSP'=>true, 'TEXT'=>'малое предприятие'];
			}
			}
			return $retArr;
			}
			
			public function getOrgData($inn) {
			$key ='CHANGE_ME';
			$url = 'https://api-fns.ru/api/egr?req='.$inn.'&key='.$key;
			$result = file_get_contents($url);
			$arr = json_decode($result);	
			$ar1 = $arr->items[0];
			$resultObj = null;
			if($ar1->ЮЛ){
			$resultObj = $ar1->ЮЛ;
			}
			if($ar1->ИП){
			$resultObj = $ar1->ИП;
			}
			$resultArr = (Array)$resultObj;
			
			$resultArr['СПВЗ']="";
			$resultArr['История']="";
			$resultArr['ДопВидДеят']="";
			return $resultArr;
			}
		*/
		public function l($arr) {
			if ($this->log) {
				echo '<pre>';
				print_r($arr);
				echo '</pre>';
			}
		}
		
	}
