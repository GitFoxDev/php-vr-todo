<?php

$yii = dirname(__FILE__).'/yii/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii); //путь к фреймворку
Yii::createWebApplication($config)->run();
