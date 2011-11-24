<script type="text/javascript">
	function assign_users_to_supervisor() {
		
		var url="<?php echo $this->Html->url(array('controller'=>'users','action'=>'update_user_assignment')); ?>";
		$.ajax({
			type: 'POST',
			url: url,
			data: $('#id_form_assign_user').serialize(),
			success: function(res) {
				if(res.success=='1')
					$.fancybox.close();
				else
					alert('Couldnot be saved due to some reason. Please try again');
			},
			dataType:'JSON'
		});
		return true;
	}
</script>
<?php
	$accessToId = array();
	if($supervisorInfo['User']['access_to_ids'] != '') {
		$accessToId = explode(',', $supervisorInfo['User']['access_to_ids']);
	}
?>
<div id="id_div_assign_full">
	<div id="id_div_assign_header">
		<h3>Assign users to <br>"<?php echo $supervisorInfo['User']['full_name']; ?>"</h3>
	</div>
	<div id="id_div_assign_form">
		<div id="id_div_success_msg" style="color:green;"></div>
		<div id="id_div_error_msg" style="color:red;"></div>
		<?php echo $this->Form->create(null, array('onsubmit'=>false, 'id'=>'id_form_assign_user')); ?>
		<?php echo $this->Form->hidden('id', array('value'=>$supervisorInfo['User']['id'])); ?>
		<?php echo $this->Form->input('access_to_ids', array('multiple'=>'checkbox', 'options'=>$systemUserList, 'label'=>false, 'selected'=>$accessToId)); ?>
		<?php echo $this->Form->end(); ?>
	</div>		
	<div id="id_div_assign_button"> 
		<?php echo $this->Form->button('Assign',array('type'=>'button', 'onclick'=>'assign_users_to_supervisor();')); ?>
	</div>
</div>