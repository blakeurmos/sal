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
		var due = (rate*time/60);
		$('#id_td_my_due').html(set_currency(due));
	}
	
	function form_validate(){
		validator=$("#id_rate_form").validate({	
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
		x=validator.form();
		return x;
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
		window.open(document.URL+'/print_preview:1', "Print Preview", "location=1,status=1,scrollbars=1,  width=850,height=500");
	
	}
	
	
</script>
<div id="id_entire_search_form">
	<div class="search_header">
		<h3>Search</h3>
	</div>
	<div class="search_form">
		<?php echo $this->Form->create('Billing',array('url'=>'searchRedirect')); ?>
		<table border="0" width="326px" height="120px">
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
				<td align="left" colspan="2"><?php echo $this->Form->input('client_name', array('div'=>false));?></td>						
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
					<?php if($this->Session->read('Auth.User.type')=='1') { ?>
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
					foreach($records as $key => $value) { ?>
					<tr class="first" id="record_<?php echo $value['Billing']['id']; ?>">
					<?php if($this->Session->read('Auth.User.type')=='1') { ?>
						<td><?php echo $value['User']['username']; ?></td>
					<?php } ?>
						<td><?php echo $value['Billing']['bill_to']; ?></td>
						<td><?php echo $value['Billing']['bill_date']; ?></td>
						<td><?php echo $value['Billing']['client_name']; ?></td>
						<td><?php echo $value['Billing']['case_no']; ?></td>
						<td><?php echo $value['Billing']['appointment_time']; ?></td>
						<td>
							<?php 
							echo $value['Billing']['duration']; 
							$totalDuration += $value['Billing']['duration'];
							?>
						</td>
						<td><?php echo $value['Billing']['type']; ?></td>
						<td><?php echo $value['Billing']['cpt']; ?></td>
						<td><?php echo $value['Billing']['diag']; ?></td>
						<td><?php echo $value['Billing']['gr_c_so']; ?></td>
						<td><?php echo $value['Billing']['sch_off_hv']; ?></td>
						<td>
							<?php 
								echo $this->Html->link(
													$this->Html->image('led-ico/pencil.png',array('border'=>'none')),
													array('controller'=>'billings','action'=>'add_new','/id:'.$value['Billing']['id']),
													array('escape'=>false,'title'=>'edit','class'=>'ico')
													); 
								echo ' | ';
								echo $this->Html->link(
											$this->Html->image('led-ico/delete.png',array('border'=>'none')),
											'javascript:void(0);',
											array(
												'onclick'=>"delete_billing(".$value['Billing']['id'].")",
												'escape'=>false,
												'title'=>'delete',
												'class'=>'ico'
												)
											); 
							?>
						</td>
					</tr>
					<?php } ?>
					<tr id="">
						<td colspan="5" align="right">Total Time: </td>
						<td colspan="8" align="left" id="id_td_total_duration">
							<span  id="id_span_total_duration"><?php echo $totalDuration; ?></span>
							<span> minutes</span>
						</td>
					</tr>					
			</table>
			<?php }else {
				echo 'No Other Billing added yet';
			}?>
	</div>
</div>
