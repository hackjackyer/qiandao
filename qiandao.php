<html>
<head>
<title>签到</title>
	<link href="bootstrap/css/domain.css" rel="stylesheet" />
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/jqueryv2.1.js"></script>
	<style>
	body{text-align: center;}
	.div_content_left{margin: 0 auto;text-align: left;width: 400px}

	</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<br>
<?php
$ip=$_SERVER['REMOTE_ADDR'];
$computername=`nmblookup -A $ip |grep ACTIVE |head -n 1|awk '{print $1}'`;
$username=$_POST['username'];//获取用户名，等其他信息
$yingxiaoqq=$_POST['yingxiaoqq'];
$shouhouqq=$_POST['shouhouqq'];
$qd_time=date("Y-m-d H:i:s");//获取当前日期，时间
$qd_time_b=date("Y-m-d H:i:s",strtotime("$qd_time -3 hours"));
if(!$username){//判断是否输入为空
	echo "必须要选择名字才行";
	echo "<input type='button' name='Submit' onclick='javascript:history.back(-1);' value='返回上一页' class='button bg-red'>";
	exit;
}elseif(!$shouhouqq){
	echo "必须要选择登陆的售后QQ才行<br><p>";
	echo "<input type='button' name='Submit' onclick='javascript:history.back(-1);' value='返回上一页' class='button bg-red'>";
exit;
}elseif(!$yingxiaoqq){
	echo "必须要选择登陆的营销QQ才行<br><p>";
	echo "<input type='button' name='Submit' onclick='javascript:history.back(-1);' value='返回上一页' class='button bg-red'>";
exit;
}


$db=mysqli_connect('localhost','root','pwd','databasename');//链接数据库
if(mysqli_connect_errno()){//链接数据库失败提示
	echo "Could Not connect to mysql";
	exit;
}
mysqli_set_charset($db,"utf8");//链接数据库字符集
//以下内容检测是否恶意提交
$chk_q1="SELECT * FROM `data` WHERE name='$username'";
$chk_q2="SELECT * FROM `data` WHERE yingxiaoqq='$yingxiaoqq'";
$chk_q3="SELECT * FROM `data` WHERE shouhouqq='$shouhouqq'";

$chk1=mysqli_query($db,$chk_q1);
$chk2=mysqli_query($db,$chk_q2);
$chk3=mysqli_query($db,$chk_q3);

$row_chk1=mysqli_num_rows($chk1);
$row_chk2=mysqli_num_rows($chk2);
$row_chk3=mysqli_num_rows($chk3);
if($row_chk1 <= '0'){
	echo "<script type='text/javascript'>alert('非法姓名！！！110已经在路上')</script>";
	mysqli_close($db);
	echo "<input type='button' name='Submit' onclick='javascript:history.back(-1);' class='button bg-red' value='我错了，我重来还不行么。。。'>";
	exit;
}elseif($row_chk2 <= '0'){
	echo "<script type='text/javascript'>alert('非法提交营销QQ信息！！！110已经在路上')</script>";
	mysqli_close($db);
	echo "<input type='button' name='Submit' onclick='javascript:history.back(-1);' class='button bg-red' value='我错了，我重来还不行么。。。'>";
	exit;
}elseif($row_chk3 <= '0'){
	echo "<script type='text/javascript'>alert('非法提交售后QQ信息！！！110已经在路上')</script>";
	mysqli_close($db);
	echo "<input type='button' name='Submit' onclick='javascript:history.back(-1);' class='button bg-red' value='我错了，我重来还不行么。。。'>";
	exit;
}

//检验是否已经签到过
$q="INSERT INTO qiandao(name,yingxiaoqq,shouhouqq,qd_time,computername,ip)
 VALUES ('$username','$yingxiaoqq','$shouhouqq','$qd_time','$computername','$ip')";//写入数据库语句
$q_bidui="SELECT * FROM qiandao WHERE qd_time>='$qd_time_b' AND qd_time<'$qd_time' AND name='$username'";
$result_bidui=mysqli_query($db,$q_bidui);
$row_bidui=mysqli_num_rows($result_bidui);
if($row_bidui > '0' ){
	echo "<div class='div_content_left'>";
	echo "兄弟别闹，你都签到了已经。"; 
	echo "</div>";
	mysqli_close($db);
	exit;
}
if(!mysqli_query($db,$q)){//成功写入数据库与否
		echo "签到失败，请联系管理员。";
		}else{
		echo "<div class='div_content_left'>";
		echo "网维：".$username.">>签到完成<br />";
		echo "售后QQ：".$shouhouqq."<br />";
		echo "营销QQ：".$yingxiaoqq."<br />";
		echo "当前计算机：".$computername."<br />";
		echo "<p>";
		echo "<p>";
		echo "谢谢你的配合。你可以手动关闭这个网页了<br />";
		echo "</div>";
      }
mysqli_close($db);//关闭链接
?>

<script language="javascript">
<!--
function clock(){i=i-1
document.title="本窗口将在"+i+"秒后自动关闭!";
if(i>0)setTimeout("clock();",1000);
else self.close();}
var i=3
clock();
//-->
</script>

</body>
</html>
