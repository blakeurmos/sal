<script type='text/javascript'>
function form_validate(){
	validator=$("#billing_form_id").validate({	
	rules: {
			'data[Billing][bill_to]':{
				required: true
			},		  
			'data[Billing][bill_date]':{
				required: true
			},
			'data[Billing][client_name]':{
				required: true
			},
			'data[Billing][case_no]':{
				required: true
			},
			'data[Billing][appointment_time]':{
				required: true
			},
			'data[Billing][type]':{
				required: true
			},
			'data[Billing][cpt]':{
				required: true
			},
			'data[Billing][diag]':{
				required: true
			},
			'data[Billing][gr_c_so]':{
				required: true
			},
			'data[Billing][sch_off_hv]':{
				required: true
			}
		},
	messages: {
		'data[Billing][bill_to]':{
			required:"Please choose a value from the dropdown."
			},	
		'data[Billing][bill_date]':{
			required:"This field cannot be left blank"
			},	
		'data[Billing][client_name]':{
			required:"This field cannot be left blank"
			},	
		'data[Billing][case_no]':{
			required:"This field cannot be left blank"
			},	
		'data[Billing][appointment_time]':{
			required:"This field cannot be left blank"
			},				
		'data[Billing][type]':{
			required:"Please choose a value from the dropdown."
			},
		'data[Billing][cpt]':{
			required:"Please choose a value from the dropdown."
			},
		'data[Billing][diag]':{
			required:"This field cannot be left blank"
			},
		'data[Billing][gr_c_so]':{
			required:"Please choose a value from the dropdown."
			},
		  'data[Billing][sch_off_hv]':{
		  	required: "Please choose a value from the dropdown."
		  	}
		}
	});
	x=validator.form();
	return x;
}

function auto_populate() {
	var billId = $('#id_client_list').val();
	if(billId != '') {
		var url="<?php echo $this->Html->url(array('controller'=>'billings','action'=>'get_bill_detail')); ?>";
		$.ajax({
			type: 'POST',
			url: url,
			data: {billId:billId},
			dataType: 'json',
			success: function(res) {
				if(res.success=='1') {
					$('#BillingClientName').val(res.client_name);
					$('#BillingBillTo').val(res.bill_to);
					$('#BillingCaseNo').val(res.case_no);
					$('#BillingType').val(res.type);
					$('#BillingDiag').val(res.diag);
					$('#BillingGrCSo').val(res.gr_c_so);
					$('#BillingSchOffHv').val(res.sch_off_hv);
					$('#BillingCpt').val(res.cpt);
				}else {
					$('#ajax_msg').html(res.message).show();
				}
			}
		});
	}
}
</script>

<?php
	if(isset($this->data['Billing']['id']) && $this->data['Billing']['id']!=='')
		$varText = 'Update';
	else
		$varText = 'Add';
?>
<div class="form_header">
	<h4><?php echo $varText; ?> Billing Details</h4>
</div>
<?php 
	echo $this->Form->create('Billing',array('url'=>'add_new', 'id'=>'billing_form_id', 'onsubmit'=>'return form_validate();')); 
	echo $this->Form->hidden('id');	
?>
<table>
	<tr>
		<td align="right">Bill To:</td>
		<td align="left">
		<?php 
			$options = array('M'=>'M','I'=>'I','SF'=>'SF','NB'=>'NB');
			echo $this->Form->input('bill_to',array('div'=>false, 'label'=>false, 'options'=>$options, 'empty'=>'Select')); 
		?>
		<br />
		<label class="error" for="BillingBillTo" generated="true" style="display:none;"></label>
		</td>
	</tr>
	<tr>
		<td align="right">Bill Date:</td>
		<td align="left"><?php echo $this->Form->input('bill_date',array('div'=>false, 'label'=>false, 'dateFormat'=>'MDY', 'minYear'=>2011, 'maxYear'=>2012)); ?></td>
	</tr>	
	<tr>
		<td align="right">Client Name:</td>
		<td align="left">
			<?php echo $this->Form->input('client_name',array('div'=>false, 'label'=>false)); ?>
			<?php 
				$options['id'] = 'id_client_list';
				$options['options'] = $this->requestAction('/billings/get_client_list');
				$options['default'] = '';
				$options['empty'] = 'Others';
				$options['div'] = false;
				$options['label'] = false;
				$options['onchange'] = 'return auto_populate();';
				echo $this->Form->input('client_list',$options); 
			?>
			<br />
			<label for="BillingClientName" generated="true" class="error" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td align="right">Case No:</td>
		<td align="left">
			<?php echo $this->Form->input('case_no',array('div'=>false, 'label'=>false)); ?>
			<br />
			<label class="error" for="BillingCaseNo" generated="true" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td align="right">Appointment Time:</td>
		<td align="left"><?php echo $this->Form->input('appointment_time',array('div'=>false, 'label'=>false)); ?></td>
	</tr>	
	<tr>
		<td align="right">Time:</td>
		<td align="left"><?php echo $this->Form->input('duration',array('div'=>false, 'label'=>false)); ?></td>
	</tr>
	<tr>
		<td align="right">Type:</td>
		<td align="left">
		<?php 
			$options = array('CPST'=>'CPST','THER-M'=>'THER/M','THER-I'=>'THER/I','THER-SF'=>'THER/SF');
			echo $this->Form->input('type',array('div'=>false, 'label'=>false, 'options'=>$options, 'empty'=>'Select')); 
		?>
		<br />
		<label class="error" for="BillingType" generated="true" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td align="right">Cpt Code:</td>
		<td align="left">
		<?php 
			$options = array('90801'=>'90801','90804'=>'90804','90806'=>'90806','90808'=>'90808','90857'=>'90857','90899'=>'90899');
			echo $this->Form->input('cpt',array('div'=>false, 'label'=>false, 'options'=>$options, 'empty'=>'Select')); 
		?>
		<br />
		<label class="error" for="BillingCpt" generated="true" style="display: none;"></label>
		</td>
	</tr> 
	<tr>
		<td align="right">Diagnosis</td>
		<td align="left">
			<?php echo $this->Form->input('diag',array('div'=>false, 'label'=>false)); ?>
		<br />
		<label class="error" for="BillingDiag" generated="true" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td align="right">GR/C/SO:</td>
		<td align="left">
		<?php 
			$options = array('GR'=>'GR','C'=>'C','SO'=>'SO');
			echo $this->Form->input('gr_c_so',array('div'=>false, 'label'=>false, 'options'=>$options, 'empty'=>'Select')); 
		?>
		<br />
		<label class="error" for="BillingGrCSo" generated="true" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td align="right">SCH/OFF/HV:</td>
		<td align="left">
		<?php 
			$options = array('SCH'=>'SCH','OFF'=>'OFF','HV'=>'HV');
			echo $this->Form->input('sch_off_hv',array('div'=>false, 'label'=>false, 'options'=>$options, 'empty'=>'Select')); 
		?>
		<br />		
		<label class="error" for="BillingSchOffHv" generated="true" style="display: none;"></label>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $this->Form->end($varText); ?></td>
	</tr>
</table>