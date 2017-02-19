<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ip 访问记录</title>
	</head>
	<body>
		<h1 align="center">xxxx的访客ip记录</h1>
		<table align="center" border="1">
		<?php
			$host = "localhost";
			$user = "user";
			$pass = "password";
			$db = "database";
			$dbc=mysqli_connect($host,$user,$pass,$db);
			if (!$dbc){
				echo "<tr><td>数据获取失败</td></tr>";
			}
			mysqli_query($dbc, "set character set 'utf8'");//读库 
			mysqli_query($dbc, "set names 'utf8'");//写库
			echo "\t<tr><td align=\"center\">ip地址</td><td align=\"center\" width=\"48\">是否允许定位</td><td align=\"center\">经度</td><td align=\"center\">纬度</td><td align=\"center\" width=\"48\">精度</td><td align=\"center\">定位地点</td><td align=\"center\">ip定位地点</td><td align=\"center\">时间</td></tr>\n";
			$result = mysqli_query($dbc, "select * from ipRecord order by time desc limit 20");
			while($row = mysqli_fetch_array($result)) {
				
				if($row['canLocation']=='Y'){
					echo "\t\t\t<tr><td>" . $row['ip'] . "</td><td align=\"center\">" . $row['canLocation'] . "<br><button onclick=\"window.open('/essay/essay010/showPosition.html?" . $row['longitude'] . "," . $row['latitude'] . "," . $row['accuracy'] . "')\">show</button></td><td align=\"right\">" . $row['longitude'] . "</td><td align=\"right\">" . $row['latitude'] . "</td><td align=\"right\">" . $row['accuracy'] . "</td><td width=\"320\">" . $row['locPosition'] . "</td><td width=\"160\">" . $row['ipPositon'] . "</td><td>" . $row['time'] . "</td></tr>\n";
				}else{
					echo "\t\t\t<tr><td>" . $row['ip'] . "</td><td align=\"center\">" . $row['canLocation'] . "</td><td align=\"right\">" . $row['longitude'] . "</td><td align=\"right\">" . $row['latitude'] . "</td><td align=\"right\">" . $row['accuracy'] . "</td><td width=\"320\">" . $row['locPosition'] . "</td><td width=\"160\">" . $row['ipPositon'] . "</td><td>" . $row['time'] . "</td></tr>\n";
				}
			}
			mysqli_close($dbc);
		?>
		</table>
	</body>
</html>