<!--#include file="header.shtml"-->
<script>

function search_friends(){
	var player_name = $("#player_name").val();
	var data = 'r=site/searchFromEquipList&player_name='+player_name;
	$.ajax({ 
		type: "GET", 
		url: 'index.php', 
		dataType: 'html', 
		data: data, 
		success: function(content){
			$("#top_content").html(content);
		},
	});
}


</script>

<div class="bg_wrap_03 clearfix pb10">

	<div class="clearfix p10">
		<input id="player_name" type="text" class="w180 h30 lh30 border-black-2 fl" value="<?=isset($player_name)?$player_name:""?>" placeholder="输入玩家名。。" />
		<a class="btn_yellow w90 h30 fr" style="line-height:30px;" href="javascript:void(0)" onclick="search_friends()">搜索</a>
	</div>
	<ul class="list_14" id="top_content">
		
	</ul>
</div>
	