<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<link rel=stylesheet type="text/css" href="css/main.css">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
<!--<table width="100%"><tr><td>-->
<div id="header" style="font-family:Microsoft JhengHei;">
<table  width="700px">
<tr>
<td><img height="100px" src="images/market.png"/></td><td><font size="10">奇奇超市</font></td>
</tr>
</table>
<span id="desc">奇奇超市現在有支援"茶思飯饗"APP</span>
</div>
<div id="menu" style="font-family:Microsoft JhengHei;">
	<div id="menu">
	<div id="menu_content">
	<table align="left"  Cellspacing="5px" width="100%" ><tr><td>
	<!--選單-->
	<font size="3" color="white" style="font-weight:bold;">
		<!-- 第一組清單   -->
		<div class="item">
            <a href="index.php">
			<div class="menu_main"><img style="margin:-7px;"width="30px" height="30px" src="images/home.png"></div>
			<div class="menu_sub"></div>
            </a>
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
            <a class="a_style"  href="product_browser.php"><div class="menu_main change">商品瀏覽</div></a>
			<div class="menu_sub">
			</div>
		</div>   
		<!-- 第五組清單   -->
		<div class="item">
            <a class="a_style" id="link_order" href="order.php"><div class="menu_main change">我的訂單</div>	</a>	
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
		<div id="bt_login" class="item" style="float:right">
            <a class="a_style"  href="login.php">
                <div class="menu_main change">登入
                </div>
            </a>
		</div>
		<div id="bt_logout" class="item" style="float:right">
                <div class="menu_main change">登出
                </div>
		</div>
		<div class="item" style="float:right">
            <div class="menu_main change" style="" id="nick">
            </div>
		</div>
        <!--搜尋框-->
        <div id="search" class="item" style="float:right;">
            <div class="menu_main change">搜尋</div>
		</div>
        <div class="item" style="float:right;margin:10px;" >
			<input type="text" placeholder="請輸入產品名稱" id="product_s"> 
		</div>
	</font>
	</td></tr>
    </table>
	</div>
</div>
</div>
	<!--通知提醒-->
    <a href="order.php" target="_top">
		<span id="sign" >新的訂單出現囉！</span>
		
	<img id="sign" src="images/notice.jpg" height="10%" width="15%">
    </a>
	<audio id="tone" src="tone.mp3"/>
    <!--登入登出-->
    <script>
        function jump(url){
                var a = document.createElement('a');
                a.href=url;
                a.target = '_parent';
                document.body.appendChild(a);
                a.click();
        }
        
        $("a").attr("target","_parent");
        var nick;
        $('#bt_logout').click(function(){
            deleteCookie("nick");
            $.get('query/logout.php',function(d){
                jump("index.php");
            });
            
        });
        var info = getLoginInfo();
        if(info.nick !== ""){
            //已登入
            $('#nick').text(nick);//顯示暱稱
            $('#bt_login').hide();
            $('#bt_logout').show();

            if(info.authority != 2){
                $link_order = $('#link_order>div');
                $link_order.text('客戶訂單');
            }
        }else{
            //未登入
            $('#bt_logout').hide();
            $('#bt_login').show();
        }
//    <!--產品搜尋-->>
        $('#search').click(function(){
            var s = $('#product_s').val();
            if(s != ""){
                jump("product_browser.php?" + $.param({q : s}));
            }
            else{
                alert('請輸入欲查詢的產品!!');
            }
        });
        $('#product_s').keydown(function(e){
            if(e.which == 13){
                var s = $('#product_s').val();
                if(s != ""){
                    jump("product_browser.php?" + $.param({q : s}));
                }
                else{
                    alert('請輸入欲查詢的產品!!');
                }
            }
        });
		getNotification();
        
        function getNotification(){
			$.get('query/notification.php',function(data){
				var result = JSON.parse(data);
				if(result.count == 1)
					$('#tone')[0].play();
				if(result.count>0){
					$('#sign').show(700);
				}else{
					setTimeout(getNotification,3000);
				}
			});
		}
        /*
        $('#sign').click(function(){
            
            var ele = $("<a></a>").
                attr("href","order.php").
                attr("target","_top");
                console.log(ele);
            ele.click();
        });
        */
    </script>
        
<!--</td></tr></table>-->
</body>
</html>
