<html>
<head>
<title>删除签到记录</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="2;URL=http://www.baidu.com;">
	<link href="bootstrap/css/domain.css" rel="stylesheet" />
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/jqueryv2.1.js"></script>
</head>
<body>

<br>
<?php
$db=mysqli_connect('localhost','root','pwd','databasaname');
$delid=$_GET['delid'];
mysqli_set_charset($db,"utf8");
if(mysqli_connect_errno()){
	echo "Could Not connect to mysql";
	exit;
}
$q_del="DELETE FROM qiandao WHERE id='$delid'";
if(mysqli_query($db,$q_del)){
	echo "成功删除ID:".$delid."的签到记录<br>";
}
mysqli_close($db);
echo "<p>";
echo "<input type='button' name='Submit' onclick='javascript:history.back(-1);' value='返回上一页'  class='button bg-sub'>";
?>
</body>
</html>
