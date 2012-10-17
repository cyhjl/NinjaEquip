<?php
class Util {
	public static function loadconfig($k){
		static $cfg;
		if(!$cfg){
			$cfg = array();
		}
		if(!isset($cfg[$k])){
			if(file_exists(dirname(__FILE__).'/../config/mars/'.$k.'.cfg.php')){
 			   	$cfg[$k] = require(dirname(__FILE__).'/../config/mars/'.$k.'.cfg.php');
 			}
		}
		if(isset($cfg[$k])){
			return $cfg[$k];
		}else{
			return null;
		}
	}
	
}
?>