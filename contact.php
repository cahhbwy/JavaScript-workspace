<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>假期学生去向登记表</title>
		<style>
			.error {color: #FF0000;}
		</style>
		<script type="text/javascript">
			function show(){
				document.getElementById("leaveSet").style.display = "block";
			}
			function hide(){
				document.getElementById("leaveSet").style.display = "none";
			}
		</script>
	</head>
	<body>
		<?php
			header("Content-Type:text/html;charset=utf-8");
			$name = $stuID = $tel = $email = $leaveSchool = $leaveTime = $leaveReason = $commit = "";
			$nameErr = $stuIDErr = $telErr = $emailErr = $leaveErr = $leaveTimeErr = $leaveReasonErr = "";
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$state = true;
				
				if (empty($_POST["name"])) {
					$state = false;
					$nameErr = "姓名是必填的";
				} else {
					$name = test_input($_POST["name"]);
				}
				
				if (empty($_POST["stuID"])) {
					$state = false;
					$stuIDErr = "学号是必填的";
				} else {
					$stuID = test_input($_POST["stuID"]);
					if (!preg_match("/^[A-Z]{2}[0-9]{8}$/",$stuID)) {
						$state = false;
						$stuIDErr = "无效的学号"; 
					}
				}
				
				if (empty($_POST["tel"])) {
					$telErr = "手机是必填的";
					$state = false;
				} else {
					$tel = test_input($_POST["tel"]);
					if (!preg_match("/^1[0-9]{10}$/",$tel)) {
						$state = false;
						$telErr = "无效的手机号"; 
					}
				}

				if (empty($_POST["email"])) {
					$emailErr = "邮箱是必填的";
					$state = false;
				} else {
					$email = test_input($_POST["email"]);
					if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
						$state = false;
						$emailErr = "无效的邮箱格式"; 
					}
				}
				
				if (empty($_POST["leaveSchool"])) {
					$leaveErr = "请选择是否离校";
					$state = false;
				} else {
					$leaveSchool = test_input($_POST["leaveSchool"]);
				}
				
				if(isset($leaveSchool) && $leaveSchool=="leave"){
					if (!empty($_POST["leaveTime"])) {
						$leaveTime = test_input($_POST["leaveTime"]);
					}else{
						$leaveTimeErr = "输入离校时间";
						$state = false;
					}

					if (!empty($_POST["leaveReason"])) {
						$leaveReason = test_input($_POST["leaveReason"]);
					}else{
						$leaveReasonErr = "输入离校原因和去向";
						$state = false;
					}
				}
				
				if (empty($_POST["comment"])) {
					$comment = "";
				} else {
					$comment = test_input($_POST["comment"]);
				}
				
				fclose($newfilw);
				
				if($state) {
//					save2sql($name,$stuID,$tel,$email,$leaveSchool,$leaveTime,$leaveReason,$comment);
				}
			}
			
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			
			function save2sql($name,$stuID,$tel,$email,$leaveSchool,$leaveTime,$leaveReason,$comment){
				$host = "localhost";
				$user = "user";
				$pass = "password";
				$db = "database";

				$dbc=mysqli_connect($host,$user,$pass,$db);
				if (!$dbc){
					return;
				}
				
				mysqli_query($dbc, "set character set 'utf8'");//读库 
				mysqli_query($dbc, "set names 'utf8'");//写库
				
				$query="insert into contact values('$name','$stuID','$tel','$email','$leaveSchool','$leaveTime','$leaveReason','$comment')";
				$result=mysqli_query($dbc, $query);
				mysqli_close($dbc);
			}
		?>
		<h1 align="center">假期学生去向登记表</h1>
		<div align="center">
			<p><span class="error">* 必需的字段</span></p>
			<p><span class="error">一旦提交无法更改</span></p>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				姓名：<input type="text" name="name" value="<?php echo $name;?>">
				<span class="error">* <?php echo $nameErr;?></span>
				<br><br>
				学号：<input type="text" name="stuID" value="<?php echo $stuID;?>">
				<span class="error">* <?php echo $stuIDErr;?></span>
				<br><br>
				手机：<input type="text" name="tel" value="<?php echo $tel;?>">
				<span class="error">* <?php echo $telErr;?></span>
				<br><br>
				邮箱：<input type="text" name="email" value="<?php echo $email;?>">
				<span class="error">* <?php echo $emailErr;?></span>
				<br><br>
				是否离校：
				<input type="radio" name="leaveSchool" <?php if (isset($leaveSchool) && $leaveSchool=="leave") echo "checked";?> onchange="show()" value="leave">是
				<input type="radio" name="leaveSchool" <?php if (isset($leaveSchool) && $leaveSchool=="stay") echo "checked";?> onchange="hide()" value="stay">否
				<span class="error">* <?php echo $leaveErr;?></span>
				<br><br>
				<div id="leaveSet" <?php if (!(isset($leaveSchool) && $leaveSchool=="leave")) echo "style=\"display:none;\"";?>>
					计划离校起止时间：<textarea name="leaveTime" rows="5" cols="40"><?php echo $leaveTime;?></textarea>
					<span class="error">* <?php echo $leaveTimeErr;?></span>
					<br><br>
					离校事由及去向：<textarea name="leaveReason" rows="5" cols="40"><?php echo $leaveReason;?></textarea>
					<span class="error">* <?php echo $leaveReasonErr;?></span>
					<br><br>
				</div>
				备注：<textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
				<br><br>
				<input type="submit" name="submit" value="提交">
			</form>
			
			<?php
				echo "姓名：" . $name . "<br>";
				echo "学号：" . $stuID . "<br>";
				echo "手机：" . $tel . "<br>";
				echo "邮箱：" . $email . "<br>";
				echo "是否离校：";
				if (isset($leaveSchool) && $leaveSchool=="leave"){
					echo "是<br>";
					echo "计划离校起止时间：" . $leaveTime . "<br>";
					echo "离校事由及去向：" . $leaveReason . "<br>";
				}else if (isset($leaveSchool) && $leaveSchool=="stay"){
					echo "否<br>";
				}
				echo "备注：" . $comment . "<br>";
			?>

		</div>
	</body>
</html>