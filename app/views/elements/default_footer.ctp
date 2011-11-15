<?php 
	if($this->Session->check('Auth.User.id')) {
		if($session->read('Auth.User.last_login') !== NULL) {
			echo  'Last login: '.date("F jS, Y, g:i a",strtotime($session->read('Auth.User.last_login')));
		}else {
			echo 'Last login: This is your first time login to this system. ';
		}
	}
?>
