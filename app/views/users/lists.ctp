<script type="text/javascript">
	function delete_user(id) {
		var loginUserId="<?php echo $this->Session->read('Auth.User.id'); ?>";
		
		if(id==loginUserId) {
			alert('You are currently logged in so cant delete yourself!');
			return false;
		}

		var status = confirm('Are you sure to delete the user?');
		if(status){
			var url="<?php echo $this->Html->url(array('controller'=>'users','action'=>'delete')); ?>";
			$.ajax({
				type: 'POST',
				url: url,
				data: {id:id},
				dataType: 'json',
				success: function(res) {
					if(res.success=='1') {
						$('#record_'+id).remove();
						if($('tr[id^="record_"]').length == 0) 	$('#listing_table').remove();				
					}
					$('#ajax_msg').html(res.message);
					$('#ajax_msg').show();
				}
			});
		}
	}
</script>

<div id="id_entire_billing_list">
	<div class="listing_header">
		<h3>System Users</h3>
	</div>
	<div class="listing_add_new">
		<?php echo $this->Html->link(
									$this->Html->image('led-ico/add.png',array('border'=>'none')).'Add User',
									'add_new',
									array('escape'=>false,'title'=>'Add')); 
									?>
	</div>
	<div class="clear_div"> </div>
	<div class="listing_div">
			<?php if(isset($records[0])){ ?>
			<table id="listing_table"  width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<th>Full name</th>
						<th>User type</th>
						<th># of Entries</th>
						<th>Last login</th>
						<th colspan="2">Action</th>
					</tr>
					<?php foreach($records as $key => $value) { ?>
					<tr class="first" id="record_<?php echo $value['User']['id']; ?>">
						<td><?php echo $value['User']['first_name'].' '.$value['User']['last_name']; ?></td>
						<td>
							<?php 
								if($value['User']['type']==1) echo 'Admin'; 
								if($value['User']['type']==2) echo 'Therapist'; 
								if($value['User']['type']==3) echo 'Other'; 
								
								?>
						</td>
						<td><?php echo count($value['Billing']); ?></td>
						<td>
						<?php 
							echo ($value['User']['last_login']==NULL)?'Never logged in':$value['User']['last_login']; 
						?>
						</td>
						<td colspan=2">
							<?php 
								echo $this->Html->link(
													$this->Html->image('led-ico/pencil.png',array('border'=>'none')),
													array('controller'=>'users','action'=>'add_new','/id:'.$value['User']['id']),
													array('escape'=>false,'title'=>'edit','class'=>'ico')
													); 

								echo ' | ';
								echo $this->Html->link(
											$this->Html->image('led-ico/delete.png',array('border'=>'none')),
											'javascript:void(0);',
											array(
												'onclick'=>"delete_user(".$value['User']['id'].")",
												'escape'=>false,
												'title'=>'delete',
												'class'=>'ico'
												)
											); 
							?>
						</td>
					</tr>
					<?php } ?>
			</table>
			<?php }else {
				echo 'You are the only 1 user in this system.';
			}?>
	</div>
</div>
