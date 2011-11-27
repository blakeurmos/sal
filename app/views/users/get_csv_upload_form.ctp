<script type="text/javascript">
	function startUpload() {
		document.getElementById('id_p_upload_process').style.display = 'block';
		document.getElementById('id_div_csv_upload_form').style.display = 'none';
		return true;
	}

	function stopUpload(status, msg, userId) {
		var result = '';
		if (status == '1'){
			result = '<span  style="color:green;">'+msg+'<\/span><br/><br/>';
		}else {
			result = '<span style="color:red;">'+msg+'<\/span><br/><br/>';
		}
		document.getElementById('id_p_upload_process').style.display = 'none';
		document.getElementById('id_div_csv_upload_form').innerHTML = result + '<form action="/sal/users/upload_csv" target="upload_target" id="UserUploadCsvForm" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="startUpload();"><div style="display: none;"><input name="_method" value="POST" type="hidden"></div><input type="hidden" id="UserUserId" value="'+userId+'" name="data[User][user_id]"><input name="data[User][bill_csv]" id="UserBillCsv" type="file"><div class="submit"><input value="Upload" type="submit"></div></form>';
		document.getElementById('id_div_csv_upload_form').style.display = 'block';      
		return true;   
	}	
</script>
<div id="id_div_main_form">
	<p id="id_p_upload_process">Loading...<br/>
	<?php echo $this->Html->image('other_images/loader.gif',array('border'=>'none'));?>
	<br/>
	</p>
	<div id="id_div_csv_upload_form">
		<?php 
			echo $this->Form->create('', array('action'=>'upload_csv','type'=>'file' ,'target'=>'upload_target', 'onsubmit'=>'startUpload();'));
			echo $this->Form->hidden('user_id',array('value'=>$userId));
			echo $this->Form->file('bill_csv');
			echo $this->Form->end('Upload');
		?>
	</div>
	<div>
		<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
	</div>
<div>
