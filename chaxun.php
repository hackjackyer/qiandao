<html>
<head>
<title>签到查询</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="bootstrap/css/domain.css" rel="stylesheet" />
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/jqueryv2.1.js"></script>
	<style>
	body{text-align: center;}
	.div_content_center{margin: 0 auto;text-align: center;}
	.talbe{
		width: 50%;
	}
	</style>
</head>
<body>
<script>
function is_remove(id)
{
if(confirm("确定要删除这条记录吗？"))
{
window.location.href = "delete.php?delid=" + id;
}
}
</script>

<div class="container">
<div class="col-md-12">
<br>
<?php

$chaxun_time=$_POST['chaxun_time'];

echo $chaxun_time."<br />";
$d=date("Y-m-d",strtotime("$chaxun_time +1 day"));

$db=mysqli_connect('localhost','root','pwd','databasename');
mysqli_set_charset($db,"utf8");
if(mysqli_connect_errno()){
	echo "Could Not connect to mysql";
	exit;
}

$q="SELECT DISTINCT
id AS `序号`,
name AS `姓名`,
shouhouqq AS `售后QQ`,
yingxiaoqq AS `营销QQ`,
qd_time AS `签到时间`,
computername AS `签到计算机名`,
ip AS `签到计算机IP`
FROM
qiandao
WHERE
qd_time>='$chaxun_time' AND qd_time<'$d'
ORDER BY
qd_time";

$result = mysqli_query($db,$q);
$rownum = mysqli_num_rows($result);

$conn=mysql_connect("localhost","root","ruixunww");
mysql_select_db("xiaoyu",$conn);
$rows=mysqli_affected_rows($db);
$colums=mysqli_num_fields($result);
$tmpresult=mysql_query($q,$conn);


echo "数据库查询数据如下<br />";
echo "<div class='div_content_center'>";
echo "<table class='table table-striped' width='800px'style='border-color:#666666;' border='1px' cellpadding='5px' cellspacing='0px'><tr>";
for($i=0; $i < $colums; $i++){
	$biaotou=mysql_field_name($tmpresult,$i);
	echo "<th>$biaotou</th>";
}
echo "<th>删除</th>";
echo "</tr>";
while($row=mysqli_fetch_row($result)){
	echo "<tr>";
	for($i=0; $i < $colums; $i++){
		echo "<td>$row[$i]</td>";
	}
	echo "<td><button onclick='is_remove({$row[0]});' class='button bg-sub'>删除</button></td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";
echo "<br><p>";
echo "<p>";
echo "<input type='button' name='Submit' class='button bg-sub' onclick='javascript:history.back(-1);' value='返回上一页'>";
?>


<br>
<br>
</div>
</div>
</body>
</html>
