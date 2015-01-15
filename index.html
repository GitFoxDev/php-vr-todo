<html>
	<head>
		<script src="include/jquery-2.1.3.min.js"></script>
		<script src="include/jquery-ui-1.11.2/jquery-ui.min.js"></script>
		<script src="include/jquery-ui-1.11.2/jquery-ui.rus.js"></script>
		<link rel="stylesheet" href="include/jquery-ui-1.11.2/jquery-ui.css">
		<style>
			html {height: 100%;}
			.to-mes-error { color: red; }
			.to-mes-success { color: green; }
			.wrapper {
				width: 900px;
				margin: 0 auto;
			}
			.to-left, .to-right, .to-footer { float: left; padding: 15px; }
			.to-left { 
				width: 551px; 
				border: 2px solid black; 
				margin-right: 15px;
			}
			.to-right { 
				width: 264px; 
				border: 3px solid black; 
				background:#eee;
			}
			.to-header {
				font-size: 26px;
				margin-bottom: 15px;
			}
			.to-right .to-header {
				text-align: center;
			}
			.to-right button {
				width: 250px;
				margin-bottom: 5px;
			}
			.to-footer {
				width: 866px;
				text-align: center;
				border: 2px solid #b6b6b6; 
				color: #838383;
				margin-top: 20px;
			}
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
			<div class="to-columns">
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
						<button id="b1" class="to-button" onClick="setCom()">Выполнить</button>
						<button id="b2" class="to-button" onClick="setUncom()" style="margin-bottom: 20px;">Вернуть в работу</button>
						<button id="b4" class="to-button" onClick="addDb()">Записать в базу</button>
						<button id="b5" class="to-button" onClick="clearCache()"style="margin-bottom: 20px;">Очистить кэш</button>
						<button id="b3" class="to-button-delcoms" onClick="deleteComs()" style="display: none;">Удалить выполненные</button>
						<button id="b6" class="to-button" onClick="deleteAll()">Удалить всё!</button>
					</div>
				</div>
			</div>
			<div class="to-footer">ToDo © FoxDev</div>
		</div>

		<script language="javascript" type="text/javascript">
			/*function f(el) 
			{
				//$('#add_date').val()
				if ($("#" + el.id).prop("checked")) {
					$('#b1').removeAttr('style');
					//alert(el.id);
				}
				else {
					$('#b1').attr('style', 'display: none;');
				}
			}*/
			/*$(".stcheck").click(function(){
				var id_click = ($this).attr("n");
				$('.to-error').html(id_click);
				alert( '#' + id_click );
			});
			function statusCheckbox() {
				//if ($("#myCheckbox").prop("checked"))
				//$('.to-error').html($(this).className);
				var id_click = ($this).attr("name");
				$('.to-error').html(id_click);
				alert( '#' + id_click );
			}*/
			function getGoto() 
			{
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: "r=goto/get", dataType : "text",
					success: function (data) {
						$('.to-do').html(data);
						$('#b3').attr('style', 'display: none;');
						if(data.indexOf('issetcom') + 1) 
						{ 
							$('#b3').removeAttr('style'); 
							setEqualHeight();
						}
					}
				});
			}
			getGoto();
			
			//setInterval(getGoto,5000);
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
					setTimeout(getGoto,3000);
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
				setTimeout(getGoto,3000);
			}
			function addDb()
			{
				var tquery = 'r=goto/adddb&' + $("#formz").serialize();
				$.ajax ({
						type: "POST", url: 'getdata.php',
						data: tquery, dataType : "text",
						success: function (data) {
							$('.to-error').html(data);
						}
					});
				setTimeout(getGoto,3000);
			}
			function deleteAll()
			{
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: "r=goto/deleteall", dataType : "text",
					/*success: function (data) {
						$('.to-do').html(data);
					}*/
				});
				setTimeout(getGoto,3000);
			}
			function setCom()
			{
				var tquery = 'r=goto/setcom&' + $("#formz").serialize();
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: tquery, dataType : "text",
					success: function (data) {
							$('.to-error').html(data);
					}
				});
				setTimeout(getGoto,3000);
			}
			function setUncom()
			{
				var tquery = 'r=goto/setuncom&' + $("#formz").serialize();
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: tquery, dataType : "text",
					/*success: function (data) {
						$('.to-do').html(data);
					}*/
				});
				setTimeout(getGoto,3000);
			}
			function deleteComs()
			{
				$.ajax ({
					type: "POST", url: 'getdata.php',
					data: "r=goto/deletecoms", dataType : "text",
					/*success: function (data) {
						$('.to-do').html(data);
					}*/
				});
				setTimeout(getGoto,3000);
			}
		</script>
	</body>
</html>