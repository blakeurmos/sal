<script type="text/javascript">
	$(document).ready(function() {
		set_rate();
		set_total();
	}); 

	function set_rate() {
		var inputRate = get_currency($('#UserRate').val());
		$('#id_td_my_rate').html(set_currency(inputRate));
	}
	
	function set_total() {
		var time  = 0;
		if($('#id_span_total_duration').length > 0)	
			time = parseInt($('#id_span_total_duration').html());
		var rate = get_currency($('#id_td_my_rate').html());
		var total = (rate*time/60);
		var totalNB = get_currency($('#id_total_NB').html());
		$('#id_td_my_due').html(set_currency(total + (totalNB*20)));
	}
	
	function form_validate(){
		var validator=$("#id_rate_form").validate({	
		rules: {
			  'data[User][rate]':{
					required: true,
					number: true
				},
			  'data[User][school]':{
					required: true
				}
			},
		messages: {
			'data[User][rate]':{
					required: "This field cannot be left blank",
					number: "Please enter a numeric value"
				},
			'data[User][school]':{
					required: "This field cannot be left blank"
				}
			}
		});
		return validator.form();
	}

	function delete_billing(id) {
		var status = confirm('Are you sure to delete? ');
		if(status){
			var url="<?php echo $this->Html->url(array('controller'=>'billings','action'=>'delete')); ?>";
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
	
	
	function update_user_rate() {
		var url="<?php echo $this->Html->url(array('controller'=>'users','action'=>'update_user_rate')); ?>";
		if(!form_validate()) return false;
		
		add_disabled_button('id_rate_form');
		$.ajax({
			type: 'POST',
			url: url,
			data: $('#id_rate_form').serialize(),
			dataType: 'json',
			success: function(res) {
				if(res.success=='0'){
					remove_disabled_button('id_rate_form');
					$('#id_div_success_rate_msg').html('');
					$('#id_div_error_rate_msg').html(res.message).show();
				}else {
					set_rate();
					set_total();
					$('#id_div_error_rate_msg').html('');
					$('#id_div_success_rate_msg').html(res.message).show();
				}
			}
		});		
	}
	
	function show_print_preview() { 
		window.open(document.URL+'/print_preview:1', "PrintPreview", "location=1,status=1,scrollbars=1,width=850,height=500");
	
	}
	
	
</script>
<div id="id_entire_search_form">
	<div class="search_header">
		<h3>Search</h3>
	</div>
	<div class="search_form">
		<?php echo $this->Form->create('Billing',array('url'=>'searchRedirect')); ?>
		<table border="0" width="326px" height="120px">
		<?php if($this->Session->read('Auth.User.type')=='1') { ?>
			<tr>
				<td align="left" colspan="2">
				<?php 	
					$options = $this->requestAction('/users/get_username_list');
					echo $this->Form->input('username', array('div'=>false, 'options'=>$options, 'empty'=>'All'));
				?>
				</td>						
			</tr>
		<?php } ?>
			<tr>
				<td align="left" colspan="2"><?php echo $this->Form->input('bill_date', array('div'=>false, 'empty'=>'All', 'separator'=>'/'));?></td>		
			</tr>
			<tr>
				<td align="left">
				<?php 
					$options = array('M'=>'M','I'=>'I','SF'=>'SF','NB'=>'NB');
					echo $this->Form->input('bill_to', array('div'=>false, 'options'=>$options, 'empty'=>'All'));
				?>
				</td>		
				<td align="left">
				<?php 
					$options = array('CPST'=>'CPST','THER-M'=>'THER/M','THER-I'=>'THER/I','THER-SF'=>'THER/SF');
					echo $this->Form->input('type', array('div'=>false, 'options'=>$options, 'empty'=>'All'));
				?>
				</td>					
			</tr>
			<tr>
				<td align="left" colspan="2">
					<?php 
						$options = $this->requestAction('/billings/get_client_name');
						echo $this->Form->input('client_name', array('div'=>false, 'options'=>$options, 'empty'=>'All'));
					?>
				</td>						
			</tr>
			<tr>
				<td colspan="3">
				<?php echo $this->Form->end('Filter');?>
				</td>
			</tr>
		</table>
	</div>
</div>
<div id="id_div_entire_rate">	
	<?php echo $this->requestAction('/users/my_rate'); ?>
</div>
<div class="clear_div"> </div>
<div id="id_entire_billing_list">
	<div class="listing_header">
		<h3>Billings List</h3>
	</div>
	<div class="listing_add_new">
		<?php echo $this->Html->link(
									$this->Html->image('led-ico/add.png',array('border'=>'none')).'Add New',
									'add_new',
									array('escape'=>false,'title'=>'Add')); 
									?>
	</div>
	<div class="listing_printer">
		<?php echo $this->Html->link(
									$this->Html->image('led-ico/printer.png',array('border'=>'none')).'Print Preview',
									'javascript:void(0);',
									array('escape'=>false,'title'=>'Print', 'onclick'=>'show_print_preview();')); 
									?>
	</div>
	<div class="clear_div"> </div>
	<div class="listing_div">
			<?php if(isset($records[0])){ ?>
			<table id="listing_table"  width="100%" cellpadding="0" cellspacing="0">
					<tr>
					<?php if($this->Session->read('Auth.User.type')=='1' || $this->Session->read('Auth.User.type')=='4' ) { ?>
						<th>Added <br/>By</th>
					<?php } ?>
						<th>Billed <br/>To</th>
						<th>Date</th>
						<th>Client Name</th>
						<th>Case #</th>
						<th>Appt.</th>
						<th>Time</th>
						<th>Type</th>
						<th>CPT</th>
						<th>Diag.</th>
						<th>Gr/<br>C/<br>SO</th>
						<th>Sch/<br>Off/<br>HV</th>
						<th>Actions</th>
					</tr>
					<?php 
					$totalDuration = 0;
					$totalNB = 0;
					foreach($records as $key => $value) { 
						extract($value['Billing']);
					?>
					<tr class="first" id="record_<?php echo $id; ?>">
					<?php if($this->Session->read('Auth.User.type')=='1' || $this->Session->read('Auth.User.type')=='4' ) { ?>
						<td><?php echo $this->Html->link($value['User']['username'], 'lists/username:'.$value['User']['username'] , array('title'=>'username')); ?></td>
					<?php } ?>
						<td><?php echo $this->Html->link($bill_to, 'lists/bill_to:'.$bill_to, array('title'=>'bill_to')); ?></td>
						<td><?php echo $this->Html->link($bill_date, 'lists/bill_date:'.$bill_date, array('title'=>'bill_date')); ?></td>
						<td><?php echo $this->Html->link($client_name, 'lists/client_name:'.$client_name, array('title'=>'client_name')); ?></td>
						<td><?php echo $this->Html->link($case_no, 'lists/case_no:'.$case_no, array('title'=>'case_no')); ?></td>
						<td>
							<?php echo $this->Html->link($appointment_time, 
														'lists/appointment_time:'.$appointment_time,
  														 array('title'=>'appointment_time'));
							 ?>
						</td>
						<td>
							<?php 
								if($bill_to=='NB')
									$totalNB++;
								else
									$totalDuration += $duration;
								echo $this->Html->link($duration, 'lists/duration:'.$duration, array('title'=>'duration')); 
							?>
						</td>
						<td><?php echo $this->Html->link($type, 'lists/type:'.$type, array('title'=>'type')); ?></td>
						<td><?php echo $this->Html->link($cpt, 'lists/cpt:'.$cpt, array('title'=>'cpt')); ?></td>
						<td><?php echo $this->Html->link($diag, 'lists/diag:'.$diag, array('title'=>'diag')); ?></td>
						<td><?php echo $this->Html->link($gr_c_so, 'lists/gr_c_so:'.$gr_c_so, array('title'=>'gr_c_so')); ?></td>
						<td><?php echo $this->Html->link($sch_off_hv, 'lists/sch_off_hv:'.$sch_off_hv, array('title'=>'sch_off_hv')); ?></td>
						<td>
							<?php 
								echo $this->Html->link($this->Html->image('led-ico/pencil.png',array('border'=>'none')),
														array('controller'=>'billings','action'=>'add_new','/id:'.$value['Billing']['id']),
														array('escape'=>false,'title'=>'edit','class'=>'ico')); 
								echo ' | ';
								echo $this->Html->link($this->Html->image('led-ico/delete.png',array('border'=>'none')),
														'javascript:void(0);',
														array(
															'onclick'=>"delete_billing(".$value['Billing']['id'].")",
															'escape'=>false,
															'title'=>'delete',
															'class'=>'ico'
															)); 
							?>
						</td>
					</tr>
					<?php } ?>
					<tr id="">
						<td colspan="5" align="right">Total Time: </td>
						<td colspan="8" align="left" id="id_td_total_duration">
							<span  id="id_span_total_duration"><?php echo $totalDuration; ?></span>
							<span> minutes</span>
							<span id="id_total_NB" style="display:none"><?php echo $totalNB; ?></span>
						</td>
					</tr>					
			</table>
			<?php }else {
				echo 'No Other Billing added yet';
			}?>
	</div>
</div>