<?php
$config = include_once('config.php');

if ($curl = curl_init())
{
	curl_setopt($curl, CURLOPT_URL, 'http://'.$config['api_url'].'/api.php');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST);
	echo curl_exec($curl);
	curl_close($curl);
}