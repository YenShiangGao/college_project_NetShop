<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<link rel=stylesheet type="text/css" href="css/main.css">
	<title >茶思飯饗－商品瀏覽</title>
	<link rel="shortcut icon" href="favicon.ico">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	<script src="js/main.js"></script>
    <style >
        #product_table{
            margin-left:auto; 
            margin-right:auto; 
            border-collapse: collapse;
            font-family:Microsoft JhengHei;
        }

        #product_table, th, td {
            border: 1px solid black;
            text-align: center;
            font-family:Microsoft JhengHei;
			height:auto;
        }
		
		#product_preview{
			box-sizing: border-box;
			position: fixed;
			z-index: 999;
/*			top:calc(50% - 100px);*/
			left:calc(50% - 200px);
			background-image:url(images/AFU_background.png);
			background-position: center;
			background-size: cover;
			width:400px;
/*			height:200px;*/
			padding-left: 50px;
			padding-top: 50px;
			border-radius: 10px;
			font-family: Microsoft JhengHei;
			color: #4c5481;
			
		}
		#product_preview>span{
			margin-bottom: 10px;
			
		}
		#product_preview>button{
			border-radius: 4px;
			width:60px;
			height:40px;
			border:2px #FFFFFF double;
			background: #bdc8d3;
			font-family: Microsoft JhengHei;
			
		}
		#product_preview_background{
			box-sizing: border-box;
			position: fixed;
			z-index: 500;
			background-color: rgba(0,0,0,0.7);
			top:0px;
			left:0px;
			width:100%;
			height:100%;
		}
    </style>
	<script>
        window._info = {
            id : getCookie('id'),
            nick : getCookie('nick'),
            authority : getCookie('authority')
        };
        
        window._allData = [];
        function addData(obj,canEdit){
            window._allData.push(obj);
            var row = _allData.length;
			obj.row = row;
			
            var $table = $('#product_table');
            var tds = [obj.id,obj.name,obj.description,obj.price,obj.quantity,obj.uploader_id,obj.date];
            var $tr = $("<tr></tr>");
            for(var i=0;i<tds.length;i++){
                $tr.append($("<td>"+tds[i]+"</td>"))
            }
			$button = $('<button>購買</button>');
			$button.attr('onclick','onSelectClick(this,'+row+')');
			$td = $('<td></td>').append($button);
			$tr.append($td);
			
			if(parseInt(_info.authority)<2){
				if(canEdit){
					$button = $('<button>編輯</button>');
					$button.attr('onclick','onEditClick(this,'+row+')');
					$td = $('<td></td>').append($button);
					$tr.append($td);
				}
			}
            $table.append($tr);
        }
        function initTable(){
            
            var $table = $('#product_table');
            var ths = ["編號","商品名稱","商品描述","價格","數量","供應商","上傳日期","購買"];
			if(_info.authority != "" && parseInt(_info.authority) != 2)
				ths.push("編輯");
			console.log(_info.authority);
            var width = [100,200,200,100,100,150,100,100,100];
            var $tr = $("<tr></tr>");
            for(var i=0;i<ths.length;i++){
				$tr.append($("<th>"+ths[i]+"</th>").css("width",width[i]));
            }
            $table.append($tr);
        }
        function queryData(){
            var str = getParameterByName("q");
            if(str == null){
                $.get("query/product_browser.php",onResponse);
            }else{
                $.post("query/product_search.php",{name : str},onResponse);
            }
        }
		function onResponse(data){
			var json = JSON.parse(data);
			if(json.code == 0){
				var arr = json.results;
				for(var i=0;i<arr.length;i++){
					addData(json.results[i],true);
				}
			}
			console.log(json);
		}
		
		function onSelectClick(button,row){
			console.log("選擇 : " + row);
			var $tr = $('#product_table tr').eq(row);
			var $tds = $('td',$tr);
			$td = $tds.eq(0);
			var pro_id = $td.text();//取得產品編號
			console.log("編號  : " + pro_id);
			$td = $tds.eq(1);
			var pro_name = $td.text();//取得產品名稱
			$td = $tds.eq(3);
			var pro_price = $td.text();//取得價格
			$td = $tds.eq(5);
			var pro_supplier = $td.text();//取得供應商
			showPreview(pro_name,pro_price,pro_supplier);
		}
		
		function onEditClick(button,row){
			console.log("開始編輯 : " + row);
		   //TODO 點擊後開始編輯 
			var $tr = $('#product_table tr').eq(row);
			var $tds = $('td',$tr);
			
			for(var i=1;i<5;i++){
				$td = $tds.eq(i);
				var text = $td.text();//取得當前文字
				$td.text("");//清除文字
				$td.append(
					$('<input type="text"/>').
						val(text).
						css({
							'text-align':'center',
							'border-width':'0px',
							height:'calc(100% - 5px)',
							width:'calc(100% - 10px)'
						})
				);
			}
			$(button).attr('onclick','onSubmitClick(this,'+row+')');
			$(button).text("送出")
		}
		function onSubmitClick(button,row){
			var $tr = $('#product_table tr').eq(row);
			var $tds = $('td',$tr);
			var $inputs = $('input',$tds);
			console.log($inputs);
			$.post('query/product_update.php',
			{	p_id : $tds.eq(0).text(),
				name : $inputs.eq(0).val(),
				description : $inputs.eq(1).val(),
				price : $inputs.eq(2).val(),
				quantity : $inputs.eq(3).val()
			},function(data){
				console.log(data);
				var obj = JSON.parse(data);
				if(obj.code == 0){
					var $tr = $('#product_table tr').eq(row);
					var $tds = $('td',$tr);
					for(var i=1;i<5;i++){
						var $td = $tds.eq(i);
						var text = $('input',$td).val();
						console.log($td);
						$td.empty();
						$td.text(text);
					}
					$(button).attr('onclick','onEditClick(this,'+row+')');
					$(button).text("編輯");
				}
			});
		}
		
		function showPreview(name,price,supplier){
			var $preview_bg = $('#product_preview_background');
			var $preview = $('#product_preview');
			
			$('#pro_name',$preview).text(name);
			$('#pro_price',$preview).text(price);
			$('#pro_supplier',$preview).text(supplier);
			
			$preview_bg.fadeIn(800);
			$preview.fadeIn(800);
			window.onresize();
		}
		function hidePreview(){
			$('#product_preview_background').hide();
			$('#product_preview').hide();
		}
		function submitProducts(){
			
			$('#product_preview_background').hide();
			$('#product_preview').hide();
		}
		
		window.onresize = function(){
			var $preview = $("#product_preview");
			$preview.css('top','calc(50% - '+$preview[0].offsetHeight/2 + 'px)');
		}
		
        window.onload = function(){
			
            initTable();
            queryData();
			$("#product_preview *:last").css("margin-bottom","45px");
        }
		
	</script>
</head>
<body>
<iframe width="100%" height="175" src="header.php" style="overflow:hidden;" frameBorder="0" scrolling="no" ></iframe>
<div id="main">
<table id="product_table">
</table>
</div>
<div id="product_preview" style="display:none;">
	<div>產品名稱：<span id="pro_name"></span></div><br>
	<div>價格：<span id="pro_price"></span></div><br>
	<div>供應商：<span id="pro_supplier"></span></div><br>
	<div>請輸入購買數量：</div>
	<input id="pro_quantity" type="number"/><br><br>
	<button onClick="submitProducts()">確定</button>
	&nbsp&nbsp
	<button onClick="hidePreview()">取消</button>
</div>

<div id="product_preview_background" style="display:none;" onClick="hidePreview()">
</div>
<iframe width="100%" src="footer.php" style="overflow:hidden;float:bottom;" frameBorder="0" scrolling="no"></iframe>
</body>
</html>
