

//先登陆，打开选课界面，选择课程类型后查询，设定课程代号
//运行一下代码进行刷课
var kechengdaihao=new Array("103X3101");
function buxuan(){
	for (lesson in kechengdaihao){
		document.getElementById("frmright").contentDocument.getElementById("dxkciframe").contentDocument.getElementById(kechengdaihao[lesson]).click();
	}
	return;
}
for (lesson in kechengdaihao){
	document.getElementById("frmright").contentDocument.getElementById("dxkciframe").contentDocument.getElementById(kechengdaihao[lesson]).disabled=false;
}
bx=self.setInterval("buxuan()",1000);	//时间暂定一秒
//运行此代码终止刷课
window.clearInterval(bx);


//研究生选课 gradGetDxkc.do
var lessons=['CS0514801'];
var run_id=self.setInterval(function(){
    for (lesson in lessons){
        xk(lessons);
    }
},1000);
window.clearInterval(run_id);
