<?php

class BD_work {	// класс, для проверки на уникальность полей по базе и внесении пользователя в базу данных при отсутсвии ошибок регистрации
	public $err;	// переменная, через которую будем выводить соответствующее сообщение об ошибке напротив поля, где ошибка была совершена
	public $filename;	// переменная, хранящая расположение базы данных
	public $check_key;	// ключ по которому в базе данных будет проиходить поиск значения
	public $check_value;	// значение ключа с которым будет сверяться на уникальность поле
	public function check_bdata() {	// функция для проверки на уникальность при регистрации
		if (is_null($this->err)) {	// выполнение функции производим, только после правильного заполнения поля, т.е. при отсутствии ошибки
			if (file_exists($this->filename)) {	// проверяем на наличи базы данных, ведь если базы нет, то и проверять нечего
				$this->file = file_get_contents($this->filename);
				$this->BDarray = json_decode($this->file,TRUE);
				foreach ($this->BDarray as $this->BDdata => $this->BDarea) {	// база данных представляет трехмерный массив, поэтому первым foreach выделаем из нее двухмерные массивы
					foreach ($this->BDarea as $this->BDkey => $this->BDvalue) {	// выделяем из двумерного массива ключ и значение хранящееся в ключе
						if (strcasecmp($this->BDkey, $this->check_key) == 0 && strcasecmp($this->BDvalue, $this->check_value) == 0) {	// проверяем на совпадение
							$this->err = $this->err_copy;
							break;
						}
					}
				}
			} 
		}
	}

	public $array_object_err = array();	// массив, который будет хранить все ошибки при регистраци
	public function bd_read_write() {	// функция для внесения пользователя в базу данных, если отсутствуют ошибки при регистрации
		foreach ($this->array_object_err as $key => $value) {	// массив с ошибками может содержать пустые значения, поэтому на всякий случай очишаем его от пустых значений
			if (empty($value)) {
				unset($this->array_object_err[$key]);
			}
		}
		if (empty($this->array_object_err)) {	// если ошибок при регистрации нет
			if (file_exists($this->filename)){	// исчем базу данных, чтобы считать из нее значения перед перезаписью, если ее нет, тогда и считывать нечего
				$file = file_get_contents($this->filename);
				$BDarray = json_decode($file,TRUE);
			}
			$hash_password = md5($_POST['user_password'] . $_POST['user_login']);	// хэшируем пароль алгоритмом MD5, для соли используем логин пользователя
			$BDarray[$_POST['user_login']] = array(	// заносим пользователя в трехмерный массив, ключ к массиву будет логин пользователя, чтобы было проще его искать при авторизации
			'user_login'	=> $_POST['user_login'],
			'user_password'	=> $hash_password,
			'user_email'	=> $_POST['user_email'],
			'user_name'	=> $_POST['user_name']
			);
			file_put_contents($this->filename, json_encode($BDarray));
			$this->err = $this->yes_signup;
		}
	}
}

class BD_login {	// класс для авторизации пользователя на сайте
	public $filename;
	public $array_object_err = array();
	public function log_in_json() {	// функция для авторизаци пользователя
		foreach ($this->array_object_err as $key => $value) {	// как и при регистраци, ошибки пишем в массив, который очищаем от пустых значений
			if (empty($value)) {
				unset($this->array_object_err[$key]);
			}
		}
		if (empty($this->array_object_err)) {	// если ошибок нет
			if (file_exists($this->filename)) {	// ищем файл базы данных, ведь если ее нет, то нет и пользователя в ней)
				$file = file_get_contents($this->filename);
				$BDarray = json_decode($file,TRUE);
				if ($BDarray[$_POST['user_login']]) {	// для поиска в базе данных используем ключ (имя пользователя)
					$hash_password = md5($_POST['user_password'] . $_POST['user_login']);	// перед проверкой по базе данных хешуем пароль MD5 + соль (логин пользователя), т.к. в базе пароли хранятся в хешированном виде для безопасности
					if (strcasecmp($_POST['user_login'], $BDarray[$_POST['user_login']]['user_login']) == 0 && strcasecmp($hash_password, $BDarray[$_POST['user_password']]['user_password']) == 0){	// если пользователь найден, пишем в cookie его логин, пароль и имя пользователя и отправляем на главную страницу
						$name_user = $BDarray[$_POST['user_password']]['user_name'];
						setcookie ("login", $_POST['user_login'], time() + 50000);
						setcookie ("password", $hash_password, time() + 50000);
						setcookie ("name", $name_user, time() + 50000);
						header("Location: index.php");
					}
					else {
						$this->err = $this->err_login_pass;	// ошибка если логин и пароль не совпадают со значением в базе данных
					}
				}
				else {
					$this->err = $this->err_login_bd;	// ошибка если пользователь не найден в базе данных
				}
			}
			else{
				$this->err = $this->err_signup;
			}
		}
	}
}

?>