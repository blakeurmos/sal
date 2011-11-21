<script type="text/javascript">
	function assign_users_to_supervisor() {
		
		/*$.ajax({
			
		});*/
		
		alert('functionality on progress!!!');
		return true;
	}
</script>
<div id="id_div_assign_full">
	<div id="id_div_assign_header">
		<h3>Assign users to <br>"<?php echo $supervisorInfo['User']['full_name']; ?>"</h3>
	</div>
	<div id="id_div_assign_form">
		<div id="id_div_success_msg" style="color:green;"></div>
		<div id="id_div_error_msg" style="color:red;"></div>
		<?php echo $this->Form->create("", array('onsubmit'=>false, 'id'=>'id_form_')); ?>
		<?php echo $this->Form->hidden('id', array('value'=>$supervisorInfo['User']['id'])); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->input('assign_users', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false)); ?>
		<?php echo $this->Form->end(); ?>
	</div>		
	<div id="id_div_assign_button"> 
		<?php echo $this->Form->button('Assign',array('type'=>'button', 'onclick'=>'assign_users_to_supervisor();')); ?>
	</div>
</div>