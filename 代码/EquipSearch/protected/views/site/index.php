<script><!--
var type;
var CONTENT;
function search_friends(){
 	$.layer({
	    type : 3,
	    success :function(){
			var player_name = $("#player_name").val();
			var data = 'r=site/searchFromEquipList&player_name='+player_name+'&type='+type;
			$.ajax({ 
				type: "GET", 
				url: 'index.php', 
				dataType: 'json', 
				data: data, 
				success: function(content){
					CONTENT = content;	
					if(content){
						str = '<tr style="color:#519CC6"><td>玩家名字</td><td>玩家id</td><td>装备id</td><td>装备等级</td><td>持有忍着id</td><td>color</td><td>是否删除</td><td>update_time</td><td>record_time</td></tr>';			
						for(var key in content){
		 					str+="<tr><td>"+content[key].name+"</td><td>"+content[key].player_id+"</td><td onclick='look_property("+key+")'><a href='javascript:void(0)'>"+content[key].equip_id+"</a></td><td>"+content[key].level+"</td><td>"+content[key].ninja_id+"</td><td>"+content[key].color+"</td><td>"+content[key].del_flag+"</td><td>"+content[key].update_time+"</td><td>"+content[key].record_time+"</td></tr>";
						}
					}else{
						str = '<span style="color:red">没有该玩家的装备数据</span>';
					}
					$("#listAll").html(str);
					LAYER.loadClose();
		 		}
			});
	    }
 	 }); 
	
}

function changeType(myitem){
 	if(myitem.checked){
		type = 1;
	}else{
		type = 0;
	 }
}

function look_property(key){
	//alert(getPropertyStr(key));
 	var data = 'r=site/getEquipInfo&eid='+CONTENT[key].equip_id+'&color='+CONTENT[key].color;
	$.ajax({ 
		type: "GET", 
		url: 'index.php', 
		dataType: 'json', 
		data: data, 
		success: function(content){
 			 // alert(content);
 			var msg = '';
 			msg +='<table width="311" height="187" border="1" >';
 			msg +='<tr><td width="151"><img src="'+content.img+'" width="130" height="140"><br/>描述：'+content.desc+'</td><td>名字：'+content.name+'<br/>属性：'+getPropertyStr(key)+'</td></tr>';
  			msg +='</table>';
  			$.layer({
  				offset : ['10%' , '50%'],
  				area : ['420px','auto'],
 			    title : [CONTENT[key].name,true],
 			    dialog:{
 			    	msg	 : msg,
 			    	type : CONTENT[key].del_flag==0?1:3
 			    }
 			});
  		}
	});
	
	//alert(JSON.stringify(CONTENT[key].property));
	//var info = [CONTENT[key].equip_id, CONTENT[key].color, CONTENT[key].property]; 
	
	//var obj=window.showModalDialog("property.php",info);
}
function getPropertyStr(skey){
	var property = CONTENT[skey].property;
	var estr = "<br />";
	var color = '';
	for(var key in property){
		if(property[key].source == 1){
			color = "red";
		}else{
			color = "green";
		}
		estr+="<span style='color:"+color+"'>";
		if(property[key].type == <?=ATTACK?>){
			estr+="攻撃";
		}
		if(property[key].type== <?=DEFENCE?>){
			estr+="防御";
		}
		if(property[key].type== <?=LEADSHIP?>){
			estr+="統率";
		}
		if(property[key].type== <?=CONCEAL?>){
			estr+="生命";
		}
		if(property[key].type== <?=BJ?>){
			estr+="クリティカル";
		}
		if(property[key].type== <?=GD?>){
			estr+="受け流し";
		}
		if(property[key].add_type == <?=1?>){
			estr+="</span>+";
		}else{
			estr+="</span>-";
		}
		if(property.val_type == <?=EPOINT?>){
			estr+=Math.floor(property[key].val);
		}else{
			estr+=property[key].val+"%"; 
		}
		estr += "<br />";
	}
	return estr;
	
}
</script>

<div class="bg_wrap_03 clearfix pb10">

	<div class="clearfix p10">
		<input id="player_name" type="text" class="w180 h30 lh30 border-black-2 fl" value="<?=isset($player_name)?$player_name:""?>" placeholder="输入玩家名。。" />
		<a class="btn_yellow w90 h30 fr" style="line-height:30px;" href="javascript:void(0)" onclick="search_friends()">搜索</a>
	</div>
	<input type="checkbox"  onclick ="changeType(this)" />
	模糊查询,包含输入字符的所有村子
	<br /><br /><br />
</div>
 

<table id='listAll' width="100%" border="0" cellspacing="0" cellpadding="0" id="t3" ></table>
	