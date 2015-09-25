<?php
class GotoController extends CController
{
	public function actionGet()
	{
		$array = Yii::app()->cache->get('c1');
		if (is_array($array)) {
			foreach ($array as $value) {
				$newarray[] = ['txt' => $value['txt'], 'date' => $value['date'], 'statusIn' => 'cache', 'com' => 0];
			}
		}
		
		$rows = Yii::app()->db->createCommand()
				->select('*')
				->from('variant_todo')
				->queryAll();
		foreach ($rows as $value) {
			$newarray[] = ['txt' => $value['name'], 'date' => $value['date'], 'statusIn' => 'db', 'com' => $value['com'], 'did' => $value['id']];
		}

		if (isset($newarray)) {
			foreach ($newarray as $r)
				$date[] = $r['date'];

			array_multisort($date, SORT_ASC, $newarray);
			$i = 1;
			echo '<form id="formz">';
			foreach ($newarray as $value) {
                $this->getGoto($i, $value);
                $i++;
            }
			echo '</form>';
		}
	}
	
	public function actionAddCache()
	{
		$params = $_POST['params'];
		$error = null; $success = null;
		$params = explode(';', $params);
		if (count($params) == 2) {
			list($txt, $date) = $params;
			
			if (($txt == null) OR ($date == null))
				$error = 'Заполните все поля!';
			elseif (!$this->isDate($date))
				$error = 'Не верный формат даты!';
			else {
                /*МОЖНО ДОБАВЛЯТЬ В КЭШ*/
                if (Yii::app()->cache->get('c1') != null)
                    $array = Yii::app()->cache->get('c1');
                $array[] = array(
                    'txt' => $txt,
                    'date' => $this->getNixdate($date),
                    'com' => 0,
                );
                    Yii::app()->cache->set('c1', $array);
                $success = 'Успешно! Можно добавить еще дело ;)';
            }
				
			if ($error != null) echo '<span class="to-mes-error">'.$error.'</span>';
			if ($success != null) echo '<span class="to-mes-success">'.$success.'</span>';
		}
	}
	
	public function actionClear()
	{
        Yii::app()->cache->set('c1', '');
	}
	
	public function actionAddDB()
	{
        $data = array();

		foreach ($_POST as $key => $value) {
            $id = explode('_', $key);
            if (substr_count($key, 'txt') > 0)
                $data[$id[1]]['txt'] = $value;
            if (substr_count($key, 'statusIn') > 0)
                $data[$id[1]]['statusIn'] = $value;
            if (substr_count($key, 'date') > 0)
                $data[$id[1]]['date'] = $value;
		}

		foreach ($data as $key => $value) {
            if ($value['statusIn'] == 'db')
                unset($data[$key]);
        }

		foreach ($data as $value) {
            Yii::app()->db->createCommand()->insert('variant_todo', array(
                'name' => $value['txt'],
                'date' => $value['date'],
                'com' => 0
            ));
		}
		$this->actionClear();
    }
	
	public function actionDeleteAll()
	{
		$this->actionClear();
        Yii::app()->db->createCommand()->delete('variant_todo');
	}
	
	public function actionSetCom()
	{
		$this->updateCom($_POST, 1);
	}

	public function actionUnsetCom()
	{
		$this->updateCom($_POST, 0);
	}
	
	public function actionDeleteComs()
	{
        Yii::app()->db->createCommand()->delete('variant_todo', 'com=1');
	}
	
	private function updateCom($dataz, $param)
	{
        $data = array();

		foreach ($dataz as $key => $value) {
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

		foreach ($data as $key => $value) {
			if ($value['ck'] != 1) unset($data[$key]);
		}

		foreach ($data as $value) {
			if ($value['statusIn'] == 'db') {
                Yii::app()->db->createCommand()->update('variant_todo', array(
                    'com' => $param,
                ), 'id=:id', array(':id' => $value['did']));
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
		if ($statusCom == 1) {
			$status['sum'] = 2; 
			$status['color'] = 'green'; 
			$status['txt'] = 'этот выполнен и в БД';
		} elseif (($statusCom == 0) AND ($statusTime == 1)) {
			$status['sum'] = ($statusCache > 0 ? 0 : 1);
			$status['color'] = ($statusCache > 0 ? 'grey' : 'black');
			$status['txt'] = ($statusCache > 0 ? 'в кэше и не выполнен' : 'в БД и не выполнен');
			
		} else {
			$status['sum'] = ($statusCache > 0 ? 3 : 4);
			$status['color'] = ($statusCache > 0 ? 'grey' : 'red');
			$status['txt'] = ($statusCache > 0 ? 'в кэше и просрочен' : 'в БД и просрочен');
		}
		
		return $status;
	}
}