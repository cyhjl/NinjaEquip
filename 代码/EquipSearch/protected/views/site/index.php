<script>
var type;
var CONTENT;
function search_friends(){
	$("#listAll").html("正在查询，稍等。。。");
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
					str = '<tr><td>玩家名字</td><td>玩家id</td><td>装备id</td><td>装备等级</td><td>持有忍着id</td><td>color</td><td>是否删除</td><td>update_time</td><td>record_time</td></tr>';			
					for(var key in content){
	 					str+="<tr><td>"+content[key].name+"</td><td>"+content[key].player_id+"</td><td onclick='look_property("+key+")'>"+content[key].equip_id+"</td><td>"+content[key].level+"</td><td>"+content[key].ninja_id+"</td><td>"+content[key].color+"</td><td>"+content[key].del_flag+"</td><td>"+content[key].update_time+"</td><td>"+content[key].record_time+"</td></tr>";
					}
				}else{
					str = "没有该玩家的装备数据";
				}
				$("#listAll").html(str);
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
	var info = [CONTENT[key].equip_id, CONTENT[key].color, CONTENT[key].property]; 
	var obj=window.showModalDialog("property.php",info);
}
</script>

<div class="bg_wrap_03 clearfix pb10">

	<div class="clearfix p10">
		<input id="player_name" type="text" class="w180 h30 lh30 border-black-2 fl" value="<?=isset($player_name)?$player_name:""?>" placeholder="输入玩家名。。" />
		<a class="btn_yellow w90 h30 fr" style="line-height:30px;" href="javascript:void(0)" onclick="search_friends()">搜索</a>
	</div>
	<input type="checkbox"  onclick ="changeType(this)" />
	模糊查询,包含输入字符的所有村子
</div>
 

<table id='listAll' width="100%" border="0" cellspacing="0" cellpadding="0" id="t3" ></table>
	