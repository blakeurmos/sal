<span class="header_text"><h2>SALARY TRACKING SYSTEM</h2></span>
<span class="login_detail">
	Welcome, 
	<?php 
		if($this->Session->check('Auth.User.id'))
			echo ucfirst($this->Session->read('Auth.User.first_name')); 
		else
			echo 'Guest';
	?><br />			
	<?php 
		if($this->Session->check('Auth.User.id'))
			echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout'),array('title'=>'logout')); 
	?>
	
</span>