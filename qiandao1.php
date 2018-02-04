<html>
<head>
<title>签到
</title>
	<link href="bootstrap/css/domain.css" rel="stylesheet" />
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/jqueryv2.1.js"></script>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>

<div class="container">
<div class="col-md-12">
<form action="qiandao.php" method="post">
<p>
<h1>签到</h1>
<span>请大家花几秒钟签到一下。如果今天你已经签到过了，那直接关闭这个窗口吧。</span>
<p>
<?php
$ip=$_SERVER['REMOTE_ADDR'];
echo "<br>";
echo 当前电脑IP.$ip;
echo "<br>";

$d1=date("Y-m-d H:i:s");//获取当前时间
$d2=date("Y-m-d H:i:s",strtotime("$d1 -9 hours"));//当前时间减去9个小时，显示两个时间差间的签到记录
$db=mysqli_connect('localhost','root','pwd','database');//数据库链接
if(mysqli_connect_errno()){//数据库链接正常与否
	echo "Could Not connect to mysql";
	exit;
}
mysqli_set_charset($db,"utf8");//设置数据库链接字符集
$q="SELECT DISTINCT
id AS `序号`,
name AS `姓名`,
shouhouqq AS `售后QQ`,
yingxiaoqq AS `营销QQ`,
qd_time AS `签到时间`
FROM
qiandao
WHERE
qd_time>='$d2' AND qd_time<'$d1'
ORDER BY
qd_time";//查询语句
$result = mysqli_query($db,$q);//mysqli查询结果
$conn=mysql_connect("localhost","root","pwd");//mysql与mysqli某些参数格式不一样，查询结果也不一。此处为了后面用mysql_field_name函数
mysql_select_db("database",$conn);//选择数据库
$colums=mysqli_num_fields($result);//获取结果的列数
$tmpresult=mysql_query($q,$conn);//mysql查询结果
echo "<br>已签到记录<br />";
echo "<p>";
echo "<table class='table table-striped' style='border-color:#666666;' border='1px' cellpadding='5px' cellspacing='0px'><tr>";
//创建表格
for($i=0; $i < $colums; $i++){//遍历查询结果表头
        $biaotou=mysql_field_name($tmpresult,$i);
        echo "<th>$biaotou</th>";
}
echo "</tr>";
while($row=mysqli_fetch_row($result)){//遍历查询数据
        echo "<tr>";
        for($i=0; $i < $colums; $i++){
                echo "<td>$row[$i]</td>";
        }
        echo "</tr>";
}
echo "</table>";
?>
<p>
<p>
选择你的名字:
<select name="username" class="button bg-red">
	<option value="">请选择</option>
	<option value="张三">张三</option>
  <option value="李四">李四</option>
</select>

选择登陆的售后QQ:
<select name="shouhouqq" class="button bg-red">
	<option value="">请选择</option>
	<option value="售后1号">售后1</option>
	<option value="售后2号">售后2</option>
</select>

选择登陆的营销QQ:
<select name="yingxiaoqq" class="button bg-red">
	<option value="">请选择</option>
	<option value="1001">营销1001</option>
	<option value="1002">营销1002</option>
</select><br><br>

<button name="submit" type="submit" class="button bg-sub">确认签到</button>
<button type="reset" class="button bg-main">重选</button><br>
</div>
</div>
</body>
</html>
