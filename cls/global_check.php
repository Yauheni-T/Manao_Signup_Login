<?php

class Check {		// создаем класс Check для проверки значений, которые вводи пользователь
	public $err;	// переменная, через которую будем выводить соответствующее сообщение об ошибке напротив поля, где ошибка была совершена
	public $data_post;	// переменная, которая будет хранить значение поля $_POST['name']
	public $err_null;	// переменная, которая будет содержать соответствующую ошибку при пустом поле $_POST['name']
	public $err_pattern;	// переменная, которое будет хранить соответствующую ошибку, согласно которому необходимо заполнить поле
	public $check_pattern;	// переменная, которое будет хранить условие, согласно которому необходимо заполнить поле

	public function check_post() {	// создаем функцию, которая будет проверять правильность заполнения поля
		if (empty($this->data_post))	// проверка на пустое значение поля
		{
			$this->err = $this->err_null;
		}
		elseif (!preg_match($this->check_pattern, $this->data_post))	// проверка на правильность заполнения поля
		{
			$this->err = $this->err_pattern;
		}
	}

	public $err_confirm_post;
	public $data_conf_post;
	public function check_confirm_post() {	// функция, которая проверяет совпадают ли два разных поля, при непустом значении
		if (empty($this->data_conf_post)) {
			$this->err = $this->err_null;
		}
		elseif ($this->data_post != $this->data_conf_post) {
			$this->err = $this->err_confirm_post;
		}
	}

	public $data_email;
	public function check_email() {	// функция для проверки поля email (при необходимости можно объединить с функцией check_post())
		if (empty($this->data_email))
		{
			$this->err = $this->err_null;
		}
		elseif (!filter_var($this->data_email, FILTER_VALIDATE_EMAIL)) {	// проверка email с помощью фильтра
			$this->err = $this->err_pattern;
		}
	}
}

?>