<?php

$array_pattern = array(
	'login_pattern' => '/.{6,}$/',
	'password_pattern' => '/(?=^.{6,}$)(?=.*\d)(?=.*[а-яА-ЯёЁa-zA-Z])(?!.*\s).*$/',
	'username_pattern' => '/[A-Za-zА-Яа-яЁё]{2}/'
);

?>