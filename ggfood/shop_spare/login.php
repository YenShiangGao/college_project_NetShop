<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<link rel=stylesheet type="text/css" href="css/main.css">
	<title>登入</title>
	<link rel="shortcut icon" href="favicon.ico">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="js/main.js"></script>
    <style>
        
        div form input{
            width:150px;
        }
    </style>
</head>
<body>
<iframe width="100%" height="175" src="header.php" style="overflow:hidden; " frameBorder="0" scrolling="no" ></iframe>
<div id="main" style="background-color:rgba(142, 160, 201, 0.63);">
        <br><br><br>
        <form id="loginForm"  style="text-align:center;margin-left:auto;margin-right:auto;font-family:Microsoft JhengHei;">
            <p style="font-size: 30px;">茶思飯饗</p><br>
            <label for="acc">帳號</label>
            <input name="acc" type="text"/><br><br>
            <label for="pas">密碼</label>
            <input name="pas" type="password"/><br><br>
            <input style="background-color: rgba(54, 99, 199, 0.63);font-family:Microsoft JhengHei;font-size:18px;color:#ffffff; border-radius: 25px;-webkit-border-radius: 25px;-moz-border-radius: 25px; " type="submit"/>
            
        </form>
    </div>
<iframe width="100%" src="footer.php" style="overflow:hidden;" frameBorder="0" scrolling="no"></iframe>
    

    
<script>
    var $form = $('#loginForm');
    $form.submit(function(e){
        e.preventDefault();
        $.post("query/login.php", 
            {
                acc: $form[0].acc.value,
                pas: $form[0].pas.value 
            },
            function(data){
                var obj = JSON.parse(data);
                if(obj.code == 0){
                    alert(obj.msg);
                    setCookie("id",obj.info.id);
                    setCookie("nick",obj.info.nick);
                    setCookie("authority",obj.info.authority);
                    window.location.href = "index.php";
                }else{
                    alert("登入失敗\n" + obj.msg);
                }
            }
        );
    });
</script>
</body>
</html>
