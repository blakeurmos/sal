<span class="menu_header"><h4>Menu</h4></span>
<span class="menu_items">
<ul class="side_menu">
<?php 
	echo '<li>'.$this->Html->link('Home',array('controller'=>'billings','action'=>'index'),array('title'=>'home')).'</li>'; 
	echo '<li>'.$this->Html->link('Dashboard',array('controller'=>'users','action'=>'dashboard'),array('title'=>'dashboard')).'</li>'; 

	if($this->Session->read('Auth.User.type')=='1') {
		echo '<li>'.$this->Html->link('Manage Users',array('controller'=>'users','action'=>'lists'),array('title'=>'home')).'</li>'; 
	} 
	echo '<li>'.$this->Html->link('Manage Billings',array('controller'=>'billings','action'=>'lists'),array('title'=>'billings list')).'</li>'; 
?>
</ul>
</span>	