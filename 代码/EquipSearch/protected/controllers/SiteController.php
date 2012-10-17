<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionSearchFromEquipList(){
    	$session = new CHttpSession;
	    $session->open();
	    $player_name = isset($_REQUEST['player_name'])?$_REQUEST['player_name']:"";
	    $type = isset($_REQUEST['type'])?$_REQUEST['type']:0;
	    $criteria = new EMongoCriteria;
	    if($type==1){
	    	$criteria->name('==',new MongoRegex("/.*".$player_name.".*/"));
	    }else{
	    	$criteria->name('==',$player_name);
	    }
  		$equips = Equips::model()->findAll($criteria);
 		if(json_encode($equips)!='[]'){
			echo json_encode($equips);
		}else{
			echo null;
		}
		exit();
    }
	public function actionGetEquipInfo(){
    	$session = new CHttpSession;
	    $session->open();
	    $eid 		= isset($_REQUEST['eid'])?$_REQUEST['eid']:0;
	    $color		= isset($_REQUEST['color'])?$_REQUEST['color']:0;
 	    $msEquipTem = new MSEquipTemplate($eid,$color);
	    $res = array("img"=>$msEquipTem->getImgSrc(),"name"=>$msEquipTem->getEquipName(),"desc"=>$msEquipTem->getEquipDesc());
 		echo json_encode($res);
 		exit();
    }

}