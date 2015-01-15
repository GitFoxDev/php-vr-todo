<?php

?>
<html>
	<head>
		<script src="include/jquery-2.1.3.min.js"></script>
		<script src="include/jquery-ui-1.11.2/jquery-ui.min.js"></script>
		<script src="include/jquery-ui-1.11.2/jquery-ui.rus.js"></script>
		<link rel="stylesheet" href="include/jquery-ui-1.11.2/jquery-ui.css">
		<style>
			.to-mes-error { color: red; }
			.to-mes-success { color: green; }
		</style>
		<script>
			$(function() {
				$( "#add_date" ).datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: 'dd.mm.yy',
					regional: 'ru',
					minDate: '-2Y',
					maxDate: '+10Y'
				});
			});
		</script>
	</head>
	<body>
		<div class="wrapper">
			<div class="to-left">
				<div class="to-header">Список запланированных дел:</div>
				<div class="to-do">Загрузка списка запланированных дел...</div>
				<div class="to-new">
					<input type="text" placeholder="Что нужно сделать?" name="add_txt" id="add_txt" required>
					<input type="date" placeholder="Когда сделать?" name="add_date" id="add_date" required>
					<button onClick="addGoto()">Добавить</button>
				</div>
				<div class="to-error"></div>
			</div>
			<div class="to-right">
				<div class="to-header">Операции</div>
				<div class="to-act">
					<ul>
						<li><button name="b1" class="to-button">Удалить выполненные</button></li>
						<li><button name="b2" class="to-button">Записать в базу</button></li>
						<li><button name="b3" class="to-button" onClick="clearCache()">Очистить кэш</button></li>
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
					data: "r=goto/get", dataType : "text",
					success: function (data) {
						$('.to-do').html(data);
					}
				});
			}
			getGoto();
			function addGoto() 
			{
				if (($('#add_txt').val() !== '') && ($('#add_date').val() !== ''))
				{
					var tquery = 'r=goto/addcache&params=' + $('#add_txt').val() + ';' + $('#add_date').val();
					$.ajax ({
						type: "POST", url: 'getdata.php',
						data: tquery, dataType : "text",
						success: function (data) {
							$('.to-error').html(data);
						}
					});
					setTimeout(getGoto(),10000);
				}
				else {
					$('.to-error').html('<span class="to-mes-error">Заполните все поля!</span>'); }
			}
			function clearCache()
			{
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: "r=goto/clear", dataType : "text",
					/*success: function (data) {
						$('.to-do').html(data);
					}*/
				});
				setTimeout(getGoto(),10000);
			}
			//});
		</script>
	</body>
</html>