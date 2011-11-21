<div id="id_div_success_rate_msg" style="color:green;"></div>
<div id="id_div_error_rate_msg" style="color:red;"></div>
<div id="id_div_rate_form">
	<?php echo $this->Form->create('User',array('id'=>'id_rate_form', 'onsubmit'=>'return false')); ?>
		<table width="150px">
			<tr>
				<td>Rate</td>
				<td>
					<?php echo '$'.$this->Form->input('rate', array('onfocus'=>'remove_disabled_button(\'id_rate_form\');', 'label'=>false, 'div'=> false, 'size'=>6)); ?><br>
				</td>
			</tr>
			<tr>
				<td colspan="2"><label for="UserRate" generated="true" class="error"></label></td>
			</tr>			
			<tr>
				<td>School</td>
				<td>
					<?php echo $this->Form->input('school', array('onfocus'=>'remove_disabled_button(\'id_rate_form\');', 'label'=>false, 'div'=> false, 'size'=>10)); ?><br>
				</td>
			</tr>
			<tr>
				<td colspan="2"><label for="UserSchool" generated="true" class="error"></label></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php echo $this->Form->button('Save', array('onclick'=>'update_user_rate();', 'id'=>'id_rate_button')); ?>
				</td>
			</tr>
		</table>
	<?php echo $this->Form->end(); ?>
	</div>
	<div class="clear_div"> </div>

	<div id="id_div_calculation">
		<table width="150px;">
			<tr>
				<td>My Rate :</td>
				<td id="id_td_my_rate"><?php echo '$'.$this->data['User']['rate'];?></td>
			</tr>	
			<tr>
				<td>Total:</td>
				<td id="id_td_my_due"></td>
			</tr>
		</table>
	</div>