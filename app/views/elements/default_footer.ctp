<?php 
	if($this->Session->check('Auth.User.id')) {
		echo  'Last login: '.date("F jS, Y, g:i a",strtotime($session->read('Auth.User.last_login')));
	}
?>
