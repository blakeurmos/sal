<script type='text/javascript'>
function form_validate(){
	var validator=$("#user_form_id").validate({	
	rules: {
		  'data[User][first_name]':{
			required: true
			},		  
			'data[User][last_name]':{
			required: true
			},
		  'data[User][username]':{
			required: true
			},
		  'data[User][confirm_pwd]':{
		  	equalTo: '#id_password'
		  	},
		  'data[User][type]':{
		  	required: true
		  	}
		},
	messages: {
		'data[User][first_name]':{
			required:"This field cannot be left blank"
			},		
		'data[User][last_name]':{
			required:"This field cannot be left blank"
			},
		'data[User][username]':{
			required:"This field cannot be left blank"
			},
		'data[User][confirm_pwd]':{
			equalTo:"Confirm password must be equal to password"
			},
		  'data[User][type]':{
		  	required: "Please select the type of user."
		  	}
		}
	});

	return 	validator.form();
}
</script>

<?php
	if(isset($this->data['User']['id']) && $this->data['User']['id']!=='')
		$varText = 'Update';
	else
		$varText = 'Add';
?>
<div class="form_header">
	<h4><?php echo $varText; ?> User Form</h4>
</div>
<?php 
	echo $this->Form->create('User',array('url'=>'add_new', 'id'=>'user_form_id', 'onsubmit'=>'return form_validate();')); 
	echo $this->Form->hidden('id');	
?>
<table>
	<tr>
		<td align="right">User Name:</td>
		<td align="left">
			<?php echo $this->Form->input('username',array('div'=>false, 'label'=>false)); ?>
			<br />
			<label class="error" for="UserUsername" generated="true" style="display: none;"></label>
		</td>
	</tr>		
	<tr>
		<td align="right">Password:</td>
		<td align="left">
			<?php echo $this->Form->input('password',array('div'=>false, 'label'=>false, 'id'=>'id_password')); ?>
			<br />
			<label class="error" for="id_password" generated="true" style="display: none;"></label>
		</td>
	</tr>		
	<tr>
		<td align="right">Confirm Password:</td>
		<td align="left">
			<?php echo $this->Form->input('confirm_pwd',array('div'=>false, 'label'=>false, 'type'=>'password')); ?>
			<br />
			<label class="error" for="UserConfirmPwd" generated="true" style="display: none;"></label>
		</td>
	</tr>	
	<tr>
		<td align="right">First Name:</td>
		<td align="left">
			<?php echo $this->Form->input('first_name',array('div'=>false, 'label'=>false)); ?>
			<br />
			<label class="error" for="UserFirstName" generated="true" style="display: none;"></label>
		</td>
	</tr>	
	<tr>
		<td align="right">Last Name:</td>
		<td align="left">
			<?php echo $this->Form->input('last_name',array('div'=>false, 'label'=>false)); ?>
			<br />
			<label class="error" for="UserLastName" generated="true" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td align="right">Type:</td>
		<td align="left">
		<?php 
			$options = array('1'=>'Admin','2'=>'Therapist','3'=>'CPST','4'=>'Supervisor');
			echo $this->Form->input('type',array('div'=>false, 'label'=>false, 'options'=>$options, 'empty'=>'Select')); 
		?>
			<br />
			<label class="error" for="UserType" generated="true" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $this->Form->end($varText); ?></td>
	</tr>
</table>