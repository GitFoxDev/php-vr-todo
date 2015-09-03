<?php
class GotoController extends CController
{
	public function actionGet()
	{
		$cache = Yii::app()->cache;
		$array = $cache->get('c1');
		if(is_array($array))
		{
			foreach ($array as $value)
			{
				$newarray[] = ['txt' => $value['txt'], 'date' => $value['date'], 'statusIn' => 'cache', 'com' => 0];
			}
		}
		
		$link = Yii::app()->db;
		$query = $link->createCommand('SELECT * FROM `variant_todo`');
		$rows = $query->query();
		foreach ($rows as $value)
			{
				$newarray[] = ['txt' => $value['name'], 'date' => $value['date'], 'statusIn' => 'db', 'com' => $value['com'], 'did' => $value['id']];
			}
		if (isset($newarray))
		{
			foreach ($newarray as $r)
				$date[] = $r['date'];
			array_multisort($date, SORT_ASC, $newarray);
			$i = 1;
			echo '<form id="formz">';
			foreach ($newarray as $value)
				{
					$this->getGoto($i, $value);
					$i++;
				}
			echo '</form>';
		}
	}
	
	public function actionAddcache()
	{
		$params = $_POST['params'];
		$error = null; $success = null;
		$params = explode(';', $params);
		if (count($params) == 2)
		{
			list($txt, $date) = $params;
			
			if(($txt == null) OR ($date == null))
				$error = 'Заполните все поля!';
			elseif (!$this->isDate($date))
				$error = 'Не верный формат даты!';
			else
				{
				/*МОЖНО ДОБАВЛЯТЬ В КЭШ*/
				$cache = Yii::app()->cache;
				if ($cache->get('c1') != null) 
					$array = $cache->get('c1');
				$array[] = array(
					'txt' => $txt, 
					'date' => $this->getNixdate($date),
					'com' => 0,
				);
				$cache->set('c1', $array);
				$success = 'Успешно! Можно добавить еще дело ;)';
				}
				
			if ($error != null) echo '<span class="to-mes-error">'.$error.'</span>';
			if ($success != null) echo '<span class="to-mes-success">'.$success.'</span>';
		}
	}
	
	public function actionClear()
	{
		$cache = Yii::app()->cache;
		$cache->set('c1', '');
	}
	
	public function actionAdddb()
	{
		foreach ($_POST as $key => $value)
		{
			$id = explode('_', $key);
			if (substr_count($key, 'txt') > 0) 
				$data[$id[1]]['txt'] = $value;
			if (substr_count($key, 'statusIn') > 0) 
				$data[$id[1]]['statusIn'] = $value;
			if (substr_count($key, 'date') > 0) 
				$data[$id[1]]['date'] = $value;
		}
		foreach ($data as $key => $value)
		{
			if ($value['statusIn'] == 'db') unset($data[$key]);
		}

		$link = Yii::app()->db;
		//$query = $link->createCommand("INSERT INTO `variant_todo` (`name`, `date`, `com`) VALUES (:name, :date, :com)");
		foreach ($data as $value)
		{
			$query = $link->createCommand("INSERT INTO `variant_todo` (`name`, `date`, `com`) VALUES ('".$value['txt']."', '".$value['date']."', 0)");
			$query->execute();
			/*$query->bindParam(":name", $value['txt'], PDO::PARAM_STR);
			$query->bindParam(":date", $value['date'], PDO::PARAM_STR);
			$query->bindParam(":com", 0, PDO::PARAM_STR);*/
		}
		$this->actionClear();
		/*foreach ($data as $value)
		{
			$insert = new Todos;
			$insert->name = $value['txt'];
			$insert->date = $value['date'];
			$insert->com = 1;
			$insert->save();
		}*/
		//print_r($data);
	}
	
	public function actionDeleteall()
	{
		$this->actionClear();
		$link = Yii::app()->db;
		$link->createCommand("DELETE FROM `variant_todo`")->execute();
	}
	
	public function actionSetcom()
	{
		$this->updateCom($_POST, 1);
	}
	public function actionSetuncom()
	{
		$this->updateCom($_POST, 0);
	}
	
	public function actionDeletecoms()
	{
		$link = Yii::app()->db;
		$link->createCommand("DELETE FROM `variant_todo` WHERE `com`='1'")->execute();
	}
	
	private function updateCom($dataz, $param)
	{
		foreach ($dataz as $key => $value)
		{
			$id = explode('_', $key);
			if (substr_count($key, 'ck') > 0) 
				$data[$id[1]]['ck'] = 1;
			if (substr_count($key, 'txt') > 0) 
				$data[$id[1]]['txt'] = $value;
			if (substr_count($key, 'statusIn') > 0) 
				$data[$id[1]]['statusIn'] = $value;
			if (substr_count($key, 'date') > 0) 
				$data[$id[1]]['date'] = $value;
			if (substr_count($key, 'did') > 0) 
				$data[$id[1]]['did'] = $value;
		}
		foreach ($data as $key => $value)
		{
			if ($value['ck'] != 1) unset($data[$key]);
		}
		
		$link = Yii::app()->db;
		foreach ($data as $value)
		{
			if ($value['statusIn'] == 'db')
			{
				$query = $link->createCommand("UPDATE `variant_todo` SET `com`='".$param."' WHERE `id`='".$value['did']."'");
				$query->execute();
			}
		}
	}
	
	private function isDate($date)
	{
		$date = explode('.', $date);
		$isDate = (checkdate($date[1], $date[0], $date[2]) ? true : false);
		if (($date[2] > 2025) OR ($date[2] < 2014)) $isDate = false;
		return $isDate;
	}
	private function getNixdate($date)
	{
		$date = explode('.', $date);
		return mktime(0,0,0,$date[1],$date[0],$date[2]);
	}
	private function getGoto($id, array $goto)
	{
		$status = $this->getStatusgoto($goto);
		echo '<input type="checkbox" name="gt_'.$id.'_ck" onClick="f(this)" id="'.$id.'">';
		echo '<input type="hidden"   name="gt_'.$id.'_txt"      value="'.$goto['txt'].'">';
		echo '<input type="hidden"   name="gt_'.$id.'_statusIn" value="'.$goto['statusIn'].'">';
		echo '<input type="hidden"   name="gt_'.$id.'_date"     value="'.$goto['date'].'">';
		if (isset($goto['did']))
			echo '<input type="hidden"   name="gt_'.$id.'_did"     value="'.$goto['did'].'">';
		if ($status['sum'] == 2)
			echo '<issetcom />';
		echo ' <span style="color:'.$status['color'].';">'.$goto['txt'].' | '.date("d.m.Y",$goto['date']).' ('.$status['txt'].')</span><br>';
	}
	private function getStatusgoto(array $goto)
	{
		$currentTime = time();
		
		// 0 - просрочен, 1 - есть еще время
		$statusTime = ($goto['date'] > $currentTime ? 1 : 0);
		
		// 0 - не выполнен, 1 - выполнен
		$statusCom = $goto['com'];
		
		// >0 - кэш, <0 - ДБ
		$statusCache = 0;
		if ($goto['statusIn'] == 'cache')
			$statusCache = 1;
		elseif ($goto['statusIn'] == 'db')
			$statusCache = -1;
		$status['isCache'] = ($statusCache > 0 ? true : false);

		// 0 - не выполнен и не просрочен в кэше
		// 1 - не выполнен и не просрочен в БД
		// 2 - выполнен и в БД
		// 3 - просрочен и в кэше
		// 4 - просрочен и в БД
		if ($statusCom == 1)
		{ 
			$status['sum'] = 2; 
			$status['color'] = 'green'; 
			$status['txt'] = 'этот выполнен и в БД';
		}
		elseif (($statusCom == 0) AND ($statusTime == 1))
		{ 
			$status['sum'] = ($statusCache > 0 ? 0 : 1);
			$status['color'] = ($statusCache > 0 ? 'grey' : 'black');
			$status['txt'] = ($statusCache > 0 ? 'в кэше и не выполнен' : 'в БД и не выполнен');
			
		}
		else
		{
			$status['sum'] = ($statusCache > 0 ? 3 : 4);
			$status['color'] = ($statusCache > 0 ? 'grey' : 'red');
			$status['txt'] = ($statusCache > 0 ? 'в кэше и просрочен' : 'в БД и просрочен');
		}
		
		return $status;
	}
}