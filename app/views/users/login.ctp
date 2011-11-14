<h4>Login</h4>
<span style="color:#FF0000;"><?php echo $session->flash('auth'); ?></span>
<?php  echo $form->create('User',array('url'=>array('controller'=>'users','action'=>'login'))); ?>
<table>
	<tr>
		<td align='right'>Username: </td>
		<td align='left'><?php echo $form->input('username',array('type'=>'text', 'class'=>'input_username','label'=>false,'div'=>false)); ?></td>
	</tr>
	<tr>
		<td align='right'>Password: </td>
		<td align='left'><?php echo $form->input('password',array('type'=>'password', 'class'=>'input_username','label'=>false,'div'=>false)); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left"><?php  echo $form->end(array('label'=>'Log in','div'=>false));?></td>
	</tr>
	<tr>
		<td colspan="2" align='left'>
			&nbsp;&nbsp;&nbsp;<?php  echo $html->link('Forgot Password ?','javascript:void(0);',array('onclick'=>'alert("this functionality is not in present scope of the project.");return false;'));?>
		</td>
	</tr>
</table>