<?php

include 'cls/global_check.php';
include 'cls/global_db.php';

include 'txt/error_list.php';
include 'txt/pattern_list.php';

if(isset($_POST['submit'])) {	// Проверка нажатия кнопки "Регистрация", если она нажата, происходит создание объекта класса Check и обращение к функции check_post
	

	$user_login = new Check;
	$user_login->data_post = $_POST['user_login'];
	$user_login->err_null = $array_err['err_login_null'];
	$user_login->err_pattern = $array_err['err_login_pattern'];
	$user_login->check_pattern = $array_pattern['login_pattern'];
	$user_login->check_post();

	$check_login = new BD_work;
	$check_login->err = $user_login->err;
	$check_login->filename = 'db\db.json';
	$check_login->check_key = 'user_login';
	$check_login->check_value = $user_login->data_post;
	$check_login->err_copy = $array_err['err_login_copy'];
	$check_login->check_bdata();

	$user_password = new Check;
	$user_password->data_post = $_POST['user_password'];
	$user_password->err_null = $array_err['err_password_null'];
	$user_password->err_pattern = $array_err['err_password_pattern'];
	$user_password->check_pattern = $array_pattern['password_pattern'];
	$user_password->check_post();

	$user_confirm_password = new Check;
	$user_confirm_password->data_post = $_POST['user_password'];
	$user_confirm_password->data_conf_post = $_POST['user_confirm_password'];
	$user_confirm_password->err_null = $array_err['err_conf_pass_null'];
	$user_confirm_password->err_confirm_post = $array_err['err_confirm_password'];
	$user_confirm_password->check_confirm_post();

	$user_email = new Check;
	$user_email->data_email = $_POST['user_email'];
	$user_email->err_null = $array_err['err_email_null'];
	$user_email->err_pattern = $array_err['err_email_pattern'];
	$user_email->check_email();

	$check_email = new BD_work;
	$check_email->err = $user_email->err;
	$check_email->filename = 'db\db.json';
	$check_email->check_key = 'user_email';
	$check_email->check_value = $user_email->data_email;
	$check_email->err_copy = $array_err['err_email_copy'];
	$check_email->check_bdata();


	$user_name = new Check;
	$user_name->data_post = $_POST['user_name'];
	$user_name->err_null = $array_err['err_username_null'];
	$user_name->err_pattern = $array_err['err_username_pattern'];
	$user_name->check_pattern = $array_pattern['username_pattern'];
	$user_name->check_post();

	$bd_json_rw = new BD_work;
	$bd_json_rw->array_object_err = array(
		$check_login->err, 
		$user_password->err, 
		$user_confirm_password->err, 
		$check_email->err, 
		$user_name->err
	);
	$bd_json_rw->filename = 'db/db.json';
	$bd_json_rw->yes_signup = $array_err['yes_signup'];
	$bd_json_rw->bd_read_write();
	$user_name->err = $bd_json_rw->yes_signup;

}

?>


<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <title>Регистрация посетителя сайта</title>
</head>

<body>
	<div>
		<form name="form" method="post" action="">
			<table class="">
				<thead>
					<tr>
						<td colspan="2"><b>Регистрация</b></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Логин (мин. 6 символов):</td>
						<td><input type="text" name="user_login" maxlength="50" value="<?php echo $user_login->data_post; ?>" class="" />
							<span><?php echo $check_login->err; ?></span>
						</td> 
					</tr>
					<tr>
						<td>Пароль (мин. 6 символов):</td>
						<td><input type="password" name="user_password"  maxlength="50" value="<?php echo $user_password->data_post; ?>" class="" />
							<span><?php echo $user_password->err; ?></span>
						</td>
					</tr>
					<tr>
						<td>Повторите пароль:</td>
						<td><input type="password" name="user_confirm_password" maxlength="50" value="<?php echo $user_confirm_password->data_conf_pass; ?>" class="" />
							<span><?php echo $user_confirm_password->err; ?></span>
						</td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><input type="text" name="user_email" maxlength="255" value="<?php echo $user_email->data_email; ?>" class="" />
							<span><?php echo $check_email->err; ?></span>
						</td>
					</tr>
					<tr>
						<td>Имя (2 буквы):</td>
						<td><input type="text" name="user_name" maxlength="2" value="<?php echo $user_name->data_post; ?>" class="" />
							<span><?php echo $user_name->err; ?></span>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td><input id="submit" type="submit" name="submit" value="Регистрация" /></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</body>

</html>
