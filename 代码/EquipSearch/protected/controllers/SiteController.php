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
    
    public function actionUpdateEquip(){
    	$this->render('updateEquip');
    }
	public function actionUpdate(){
    	$session = new CHttpSession;
	    $session->open();
	    $criteria = new EMongoCriteria;
	    $criteria->limit(1)->sort('updateEid' , EMongoCriteria::SORT_DESC);
	    $Res = UpdateRecord::model()->findAll($criteria);
	    $lastUpdateEid  = $Res[0]['updateEid'];
	    $dba = Yii::app()->db;
	    $cmd = $dba->createCommand("select p.name,e.id as eid,e.player_id,e.equip_id,e.level,e.status,e.star,e.type,e.ninja_id,e.color,e.del_flag,e.update_time,e.record_time from player_equip as e  left join player as p  on e.player_id = p.id where e.id>{$lastUpdateEid} and p.name<>'0'");
		$res = $cmd->queryAll();
   		$lasteid=0;
 		$eid_str='';
 		foreach($res as $key=>$value){
 			$cmd2 = $dba->createCommand("select type,val,add_type,val_type,source from magic where player_equip_id = {$value['eid']}");
			$res2 = $cmd2->queryAll();
			$model = new Equips();
 			$model->property = $res2;
			$model->color = $value['color'];
			$model->del_flag = $value['del_flag'];
			$model->eid = $value['eid'];
			$model->equip_id = $value['equip_id'];
			$model->level = $value['level'];
			$model->name = $value['name'];
			$model->ninja_id = $value['ninja_id'];
			$model->player_id = $value['player_id'];
			$model->record_time = $value['record_time'];
			$model->star = $value['star'];
			$model->status = $value['status'];
			$model->type = $value['type'];
			$model->update_time = $value['update_time'];
			$equip_list[] = $model;
 			$flag = $model->save();
 			$lasteid = $value['eid'];
			$eid_str.=$lasteid."_";
  		}
 		if($lasteid){
	 		$model2 = new UpdateRecord();
	 		$model2->updateEid = $lasteid;
	 		$model2->updateItems = $eid_str;
	 		$model2->save();
	 		echo json_encode($equip_list);
 		}else{
 			echo json_encode(0);
 		}
 		exit();
    }

}