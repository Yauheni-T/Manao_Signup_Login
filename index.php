<?php

	session_start();

 	include 'txt/form_list.php';
	
	if(isset($_COOKIE['login']) && isset($_COOKIE['password']))	{ //если cookie есть, то просто обновим время их жизни
		setcookie("login", "", time() - 1, '/');
		setcookie("password","", time() - 1, '/');
		setcookie("name","", time() - 1, '/');
	
		setcookie("login", $_COOKIE['login'], time() + 50000, '/');
		setcookie("password", $_COOKIE['password'], time() + 50000, '/');
		setcookie ("name", $_COOKIE['name'], time() + 50000);
		
		$logout = $array_post['form_logout'];

		if(isset($_POST['logout'])) {	//если нажат кнопка "Выход", «разавторизируем» пользователя
				
			setcookie("login", "");	//удаляем cookie с логином 	
			setcookie("password", "");	//удаляем cookie с паролем
			setcookie("name", "");	//удаляем cookie с именем
			header("Location: index.php");
		}
	}


	
	else { 	// если cookie нет, тогда выведем две кнопки, для перехода к регистрации и авторизации
		$form_submit = $array_post['form_sugnin_login'];
		if(isset($_POST['signup'])) {
			header("Location: sign_up.php");
		}
		if(isset($_POST['login'])) {
			header("Location: log_in.php");
		}
	}
		
	
?>

<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <title>Главная страница</title>
</head>

<body>
	<div><?php echo $logout; ?></div>
	<div><?php echo $form_submit; ?></div>
</body>

</html>
