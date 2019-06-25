<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<link rel=stylesheet type="text/css" href="css/main.css">
	<title>心中流物旭進</title>
	<link rel="shortcut icon" href="favicon.ico">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	<script>
		 $(document).ready(function(){
            //$(".sub").slideUp(1)
            for(i=0;i<$(".menu_main").length;i++){
                $(".menu_main:eq("+i+")").mouseover({id:i},function(e){
                    n=e.data.id
                    $(".menu_sub:eq("+n+")").slideToggle()
                    $(".menu_sub:not(:eq("+n+"))").slideUp()
                })
                $(".menu_main").mouseout({id:i},function(e){
                    n=e.data.id
                   // $(".sub").slideUp(200)
                   
                })
            }
            //$("#menu_content").css("width",$(".main").length*100)
        })
	</script>
</head>
<body>
<table width="100%"><tr><td>
<div id="header" >
<table  width="700px">
<tr>
<td><img height="100px" src="images/market.png"></img></td><td><font size="10">Dswallow Market</font></td>
</tr>
</table>

</div>
<div id="menu">
	<div id="menu">
	<div id="menu_content">
	<table align="left"  Cellspacing="5px" width="100%" ><tr><td>
	<!--選單-->
	<font size="3" color="white" style="font-weight:bold;">
		<!-- 第一組清單   -->
		<div class="item">
			<div class="menu_main"><a href="index.php"><img style="margin:-7px;"width="30px" height="30px" src="images/home.png"></a></div>
			<div class="menu_sub"></div>
		</div>   
		<!-- 第二組清單   -->
		<div class="item">
			<div class="menu_main change"><a class="a_style" href="about.php">關於我們</a></div>		
			<div class="menu_sub">
			</div>
		</div>   
		<!-- 第三組清單   -->
		<div class="item">
			<div class="menu_main change">最新消息</div>		
			<div class="menu_sub">
				<ul>供應商</ul>
				<ul>優惠資訊</ul>
				<ul>活動資訊</ul>
			</div>
		</div>   
		<!-- 第四組清單   -->
		<div class="item">
			<div class="menu_main change">商品瀏覽</div>		
			<div class="menu_sub">
			</div>
		</div>   
		<!-- 第五組清單   -->
		<div class="item">
			<div class="menu_main change">我的訂單</div>		
			<div class="menu_sub">
			</div>
		</div>  
		<!-- 第六組清單   -->
		<div class="item">
			<div class="menu_main change">聯絡我們</div>		
			<div class="menu_sub">
				<ul>意見回饋</ul>
				<ul>線上諮詢</ul>
				<ul>贊助我們</ul>
			</div>
		</div> 
		<!--登入鈕-->
		<div class="item" style="float:right">
			<div class="menu_main change">登入</div>
		</div>
	</font>
	</td></tr></table>
	</div>
</div>
</div>
<div id="main">

</div>
<div id="footer" align="center">
	<div id="footer_menu" width="900px">
	<table align="center"  Cellspacing="15px" width="900px" >
		<tr>
		<td><font size="3" color="black" style="font-weight:;"><a class="a_style2" href="index.php">Home</a><font></td></a>
		<td><font size="3" color="black" style="font-weight:;"><a class="a_style2" href="about.php">About</a></font></td>
		<td><font size="3" color="black" style="font-weight:;">News</font></td>
		<td><font size="3" color="black" style="font-weight:;">Products</font></td>
		<td><font size="3" color="black" style="font-weight:;">Test Report</font></td>
		<td><font size="3" color="black" style="font-weight:;">Performance</font></td>
		<td><font size="3" color="black" style="font-weight:;">聯絡我們</font></td>
		<td><font size="3" color="black" style="font-weight:;">檔案下載</font></td>
		</tr>
	</table>
	</div>
	<div id="footer_text">
	<font size="2">
		<table align="center"  width="870px" Cellspacing="10px">
			<tr>
			<td>客服專線：(0800)-720888</td><td>Email：a0910032381@gmail.com</td>
			<tr>
			<td>電話：(05)3625555</td><td>地址：嘉義縣朴子市吉祥二街21號</td>
			</tr>
			<tr>
			<td>傳真：(05)3620003</td>
			</tr>
		</table>
	</font>
	</div>
</div>


<?php



?>
</td></tr></table>
</body>
</html>
