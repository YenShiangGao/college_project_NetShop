<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<link rel=stylesheet type="text/css" href="css/main.css">
<!--	<title>心中流物旭進</title>-->
	<link rel="shortcut icon" href="favicon.ico">
	<style>
	#order_table{
        margin-left:auto; 
        margin-right:auto; 
        border-collapse: collapse;
        font-family:Microsoft JhengHei;
    }

	#order_table, th, td {
		border: 1px solid black;
		text-align: center;
		font-family:Microsoft JhengHei;
		height:auto;
	}

    .order_title{
        background-color: rgb(200,200,200);
        margin-top : 10px;
    }

    .item_table{
        border-collapse: collapse;
    }
    .click{
        cursor: pointer;
    }

    .hidden_row{
        height:15px;

    }

	</style>
	<script src="js/main.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	<script>
		function calcSum(arr,len){
			len = len||arr.length;
			var sum = 0;
			for(var i=0;i<len;i++){
				sum += arr[i];
			}
			return sum;
		}

        var _info = getLoginInfo();
        /**
         * 每筆訂單的標頭
         */
		var _tableTitle = {
			title : ["訂單編號","會員編號","訂購日期","送貨地址","付款方式","運送方式","運送狀態","備註"],
			width : [100,200,200,300,80,80,80,300]
        };
        /**
         * 訂單中每項的標頭
         */
		var _itemTableTitle = {
			title : ["產品編號","產品名稱","訂購時價格","產品數量","當前價格","當前庫存","產品描述"],
			width : [100,200,80,100,100,150,300]
		}
		
		//保存所有訂單資料
        window._allData = [];
        /**
         * 將標頭插入對應表格，並回傳該列(tr)
         * @return $tr
         */
        function addToHead($table,tableTitle){
			var ths = tableTitle.title;
			var width = tableTitle.width;
            var $tr = $("<tr></tr>");
            for(var i=0;i<ths.length;i++){
                $tr.append($("<th>"+ths[i]+"</th>").css("width",width[i]));
            }
            $table.append($tr);
            return $tr;
        }
        
		function addItem($inner_table,item){
			var tds = [item.pid,item.name,item.price,item.quantity,item.n_price,item.n_quantity,item.description];
			var $tr = $("<tr></tr>");
			var len = tds.length;
            for(var i=0;i<len;i++){
                $tr.append($("<td>"+tds[i]+"</td>"))
			}
            $inner_table.append($tr);
            return $tr;
		}
        //DOM
        function addOrder($table,obj){
            window._allData.push(obj);//額外保存資料
            //外部表格用
            var row = _allData.length;
			obj.row = row;
            var tds = [obj.id,obj.m_id,obj.date,obj.address,obj.payment_method,obj.delivery_method,obj.state,obj.note];
            var $tr = $("<tr></tr>");
            //內部表格用
            var $inner_table = $('<table data-role="order_item" width="100%"></table>');    //內部的表格 用於保存項目
			var $item_tr = $("<tr></tr>");
			var $item_td = $(`<td colspan="${_tableTitle.title.length}"></td>`);
            let toggle = function(){
                $item_tr.toggle(400);
            };
            //插入標題列
            addToHead($table,_tableTitle).click(toggle).attr('class','order_title click');
            //插入資料列
			var len = tds.length;
            for(var i=0;i<tds.length;i++){
                $tr.append($("<td>"+tds[i]+"</td>"))
            }
            $tr.click(toggle).attr('class','click');
            $table.append($tr);
            
            len = obj.item.length; //資料欄數
            
            //插入項目(Item)列
            $item_tr.hide();
			$item_tr.append($item_td);
            $item_td.append($inner_table);
			addToHead($inner_table,_itemTableTitle);
			for(var i=0;i<len;i++){
				addItem($inner_table,obj.item[i]);
            }
            $inner_table.attr('class','item_table');
            $table.append($item_tr);
            $item_tr.after('<tr class="hidden_row"></tr>');
        }
        function queryData(){
			$.get("query/order_search_supply.php",onResponse);
        }
		function onResponse(data){
			try{
			    var json = JSON.parse(data);
			}catch(e){
				console.log(data);
			}
			var $table = $('#order_table');
			if(json.code == 0){
				var arr = json.orders;	//array
				for(var i=0;i<arr.length;i++){
					addOrder($table,arr[i]);
				}
			}else{
				alert(json.msg);
			}
			console.log(json);
		}
        window.onload = function(){
            queryData();
        }
	</script>
</head>
<body>
<iframe width="100%" height="175" src="header.php" style="overflow:hidden;" frameBorder="0" scrolling="no" ></iframe>
<table id="order_table">
</table>
<iframe width="100%" src="footer.php" style="overflow:hidden;" frameBorder="0" scrolling="no"></iframe>
</body>
</html>