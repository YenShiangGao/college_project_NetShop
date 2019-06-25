<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<link rel=stylesheet type="text/css" href="css/main.css">
	<title>茶思飯饗 Shop</title>
	<link rel="shortcut icon" href="favicon.ico">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="js/main.js"></script>
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
<iframe width="100%" height="175" src="header.php" style="overflow:hidden;" frameBorder="0" scrolling="no" ></iframe>

<div id="main" style="font-family:Microsoft JhengHei;">
    <!--圖片
    <div class="slider_container">
    <div><img src="images/image1.png" alt="pure css3 slider" height="100%" width="100%"><br>
    <span class="info">Image Description1</span></div>
    <div><img src="images/image2.png" alt="pure css3 slider" height="100%" width="100%"><br>
    <span class="info">Image Description2</span></div>
    <div><img src="images/image3.png" alt="pure css3 slider" height="100%" width="100%"><br>
    <span class="info">Image Description3</span></div>
    <div><img src="images/image4.png" alt="pure css3 slider" height="100%" width="100%"><br>
    <span class="info">Image Description4</span></div>
    </div>-->
    <div><img src="images/image5.png" alt="pure css3 slider" height="100%" width="100%"><br>
    <span class="info">Image Description5</span></div>
</div>
<iframe width="100%" src="footer.php" style="overflow:hidden;" frameBorder="0" scrolling="no"></iframe>

</body>
</html>
