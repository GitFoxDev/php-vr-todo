<?php

return array(
	'name' => 'Yii like Todo',
	'components' => array(
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=variant_todo',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'cache' => array(
			'class' => 'CRedisCache',
			'hostname' => 'variant-todo.dev',
			'port' => 6379,
			'database' => 0,
		),
	),
);
