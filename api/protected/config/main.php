<?php

return array(
	'name'=>'Yii like Todo',
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=api.variant-todo.loc;dbname=variant_todo',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'cache'=>array(
			'class'=>'CRedisCache',
			'hostname'=>'api.variant-todo.loc',
			'port'=>6379,
			'database'=>0,
		),
	),
);
