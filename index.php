<?php

?>
<html>
	<head>
		<script src="jquery-2.1.3.min.js"></script>
	</head>
	<body>
		<div class="wrapper">
			<div class="to-left">
				<div class="to-header">Список запланированных дел:</div>
				<div class="to-do">Загрузка списка запланированных дел...</div>
				<div class="to-new">
					<input type="text" placeholder="Что нужно сделать?" name="add_txt" id="add_txt">
					<input type="date" placeholder="Когда сделать?" name="add_date" id="add_date">
					<button onClick="addGoto()">Добавить</button>
				</div>
			</div>
			<div class="to-right">
				<div class="to-header">Операции</div>
				<div class="to-act">
					<ul>
						<li><button name="b1" class="to-button">Удалить выполненные</button></li>
						<li><button name="b2" class="to-button">Записать в базу</button></li>
						<li><button name="b3" class="to-button">Очистить кэш</button></li>
						<li><button name="b4" class="to-button">Удалить всё!</button></li>
					</ul>
				</div>
			</div>
		</div>
		<script language="javascript" type="text/javascript">
			//$('.b1').click( function() {
			function getGoto() {
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: "act=getGoto", dataType : "text",
					success: function (data) {
						$('.to-do').html(data);
					}
				});
			}
			getGoto();
			function addGoto() {
				var tquery = 'act=addGoto&params=' + $('#add_txt').val() + ';' + $('#add_date').val();
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: tquery, dataType : "text",
					success: function (data) {
						$('.to-do').html(data);
					}
				});
				getGoto();
			}
			
			//});
		</script>
	</body>
</html>