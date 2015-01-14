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
					<input type="text" placeholder="Что нужно сделать?">
					<input type="date" placeholder="Когда сделать?">
					<button>Добавить</button>
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
			$.ajax({
				type: "POST",
				url: 'getdata.php',
				data: "act=getGoto",
				dataType : "text",
				success: function (data) {
					$('.to-do').html(data);
				}
			});
			//});
		</script>
	</body>
</html>