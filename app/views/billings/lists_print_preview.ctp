<?php echo $this->Html->css(array('print_preview'),'stylesheet',array('media'=>'all'));	  ?>

<script type="text/javascript">
	function printDiv(divId)
	{
		var divToPrint=document.getElementById(divId);
		var newWin=window.open('','Print-Window','width=500,height=350');
		newWin.document.open();
		newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
		newWin.document.close();
		setTimeout(function(){newWin.close();},10);
	}
</script>
<?php 
	$totalTime = 0;
	$rate = $this->Session->read('Auth.User.rate');
	foreach($records as $key => $value) {
		$totalTime += $value['Billing']['duration'];
	}
	$totalSum = $totalTime*$rate/60;
?>
<span class="print_button">
	<?php echo $this->Html->link(
							$this->Html->image('led-ico/printer.png',array('border'=>'none')).'Print',
							'javascript:window.print();',
							array('escape'=>false,'title'=>'Print')); 
							?>
</span>
<div id="id_div_service_log">
<h3>
SERVICE ACTIVITY LOG
</h3>
<table id="id_table_service_log"  cellpadding="5px;">
	<tr>
		<td align="left">
			<span class="leftpad40px rightpad40px"><b>Provider:</b></span>
			<span class=""><?php echo $this->Session->read('Auth.User.first_name').' '.$this->Session->read('Auth.User.last_name'); ?></span>
		</td>
		<td align="right">
			<span class="leftpad40px rightpad40px"><b>&nbsp;Rate:</b></span>
			<span class="rightpad40px">$<?php echo $rate;?></span>	
		</td>
	</tr>	
	<tr>
		<td align="left">
			<span class="leftpad40px rightpad40px"><b>&nbsp;&nbsp;School:</b></span>
			<span class=""><?php echo $this->Session->read('Auth.User.school');?></span>
		</td>
		<td align="right">
			<span class="leftpad40px rightpad40px"><b>Total:</b></span>
			<span class="rightpad40px"><?php echo '$'.$totalSum; ?></span>
		</td>
	</tr>
</table>
</div>

<div id="id_div_printable">
	<?php if(isset($records[0])){ ?>
	<table  id="id_table_print" cellpadding="5px;">
			<tr>
				<th>Billed To</th>
				<th>Mo.</th>
				<th>Day</th>
				<th>Year</th>
				<th>Client Name</th>
				<th>Case #</th>
				<th>Appt.</th>
				<th>Time</th>
				<th>Type</th>
				<th>CPT</th>
				<th>Diag.</th>
				<th>Gr/<br>C/<br>SO</th>
				<th>Sch/<br>Off/<br>HV</th>
			</tr>
			<?php 
			$totalDuration = 0;
			foreach($records as $key => $value) { 
				 $class=($key%2==0)?'even':'odd';
			?>
			<tr class="<?php echo $class; ?>" id="record_<?php echo $value['Billing']['id']; ?>">
				<td><?php echo $value['Billing']['bill_to']; ?></td>
				<td><?php echo date('M',strtotime($value['Billing']['bill_date'])); ?></td>
				<td><?php echo date('j',strtotime($value['Billing']['bill_date'])); ?></td>
				<td><?php echo date('Y',strtotime($value['Billing']['bill_date'])); ?></td>
				<td><?php echo $value['Billing']['client_name']; ?></td>
				<td><?php echo $value['Billing']['case_no']; ?></td>
				<td><?php echo date('g:i a',strtotime($value['Billing']['appointment_time'])); ?></td>
				<td><?php echo $value['Billing']['duration']; ?></td>
				<td><?php echo $value['Billing']['type']; ?></td>
				<td><?php echo $value['Billing']['cpt']; ?></td>
				<td><?php echo $value['Billing']['diag']; ?></td>
				<td><?php echo $value['Billing']['gr_c_so']; ?></td>
				<td><?php echo $value['Billing']['sch_off_hv']; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="4" class="last" >Total</td> 
				<td colspan="3" align="center" class="last">Total Time(Minutes): </td>
				<td align="left" class="last">
					<span  id="id_span_total_duration_min"><?php echo $totalTime; ?></span>
				</td>				
				<td align="center" class="last">
					Hours:
				</td>
				<td colspan="4" align="left" class="last">
					<?php echo $this->requestAction("billings/convertMinutes2Hours/$totalTime"); ?>
				</td>
			</tr>					
	</table>
	<?php }else {
		echo 'No Other Billing added yet';
	}?>
</div>
