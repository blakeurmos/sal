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

<div>
	<?php echo $this->Html->link(
							$this->Html->image('led-ico/printer.png',array('border'=>'none')).'Print',
							'javascript:window.print();',
							array('escape'=>false,'title'=>'Print')); 
							?>
</div>

<div id="id_printable_div">
	<?php if(isset($records[0])){ ?>
	<table  width="100%" border="2">
			<tr>
				<th>Billed To</th>
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
			</tr>
			<?php 
			$totalDuration = 0;
			foreach($records as $key => $value) { ?>
			<tr class="first" id="record_<?php echo $value['Billing']['id']; ?>">
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
