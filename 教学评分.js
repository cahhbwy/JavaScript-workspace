//选择评价的iframe

//进入某个老师或助教的评教页面
for(var i=0;i<document.getElementsByTagName("a").length;++i){
	document.getElementsByTagName("a")[i].click();
	//具体进行评课，在测试中发现连续运行并不可行，所以还是采取手动进入某个评课界面用下面的代码选中并提交
}

//全选第一项
for(var i=1;i<10;++i){
	var ans="answ&"+i+"&1&1";
	if(document.getElementById(ans)!=null){
		document.getElementById(ans).click();
	}
}

//随机选前两项
for(var i=1;i<10;++i){
	var sel=Math.floor(Math.random()*2)+1;
	var ans="answ&"+i+"&1&"+sel;
	if(document.getElementById(ans)!=null){
		document.getElementById(ans).click();
	}
}

//提交结果
document.getElementById("qstj").click();
