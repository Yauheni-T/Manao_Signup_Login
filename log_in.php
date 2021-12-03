<?php

include 'cls/global_check.php';
include 'cls/global_db.php';

include 'txt/error_list.php';
include 'txt/pattern_list.php';

if(isset($_POST['submit'])) {

	$user_login = new Check;
	$user_login->data_post = $_POST['user_login'];
	$user_login->err_null = $array_err['err_login_null'];
	$user_login->err_pattern = $array_err['err_login_pattern'];
	$user_login->check_pattern = $array_pattern['login_pattern'];
	$user_login->check_post();

	$login_error = $user_login->err;

	$user_password = new Check;
	$user_password->data_post = $_POST['user_password'];
	$user_password->err_null = $array_err['err_password_null'];
	$user_password->err_pattern = $array_err['err_password_pattern'];
	$user_password->check_pattern = $array_pattern['password_pattern'];
	$user_password->check_post();

	$password_error = $user_password->err;

	$log_in = new BD_login;
	$log_in->array_object_err = array(
	$user_login->err, 
	$user_password->err, 
	);
	$log_in->filename = 'db/db.json';
	$log_in->err_login_pass = $array_err['err_login_pass'];
	$log_in->err_login_bd = $array_err['err_login_bd'];
	$log_in->err_signup = $array_err['err_signup'];
	$log_in->log_in_json();

	if (empty($login_error)) {
		$login_error = $log_in->err;
	}
}

?>


<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <title>Авторизация посетителя на сайте</title>

</head>

<body>
	<div>
		<form name="form" method="post" action="">
			<table class="">
				<thead>
					<tr>
						<td colspan="2"><b>Авторизация</b></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Логин (мин. 6 символов):</td>
						<td><input type="text" name="user_login" maxlength="50" value="" class="" />
							<span><?php echo $login_error; ?></span>
						</td> 
					</tr>
					<tr>
						<td>Пароль (мин. 6 символов):</td>
						<td><input type="password" name="user_password"  maxlength="50" value="" class="" />
							<span><?php echo $password_error; ?></span>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td><input id="submit" type="submit" name="submit" value="Авторизация" /></td>
					</tr>
					<tr>
						<td></td>
						<td><span><?php echo $log_in_err; ?></span></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</body>

</html>
