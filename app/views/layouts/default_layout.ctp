<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/led-ico/money_dollar.png'); ?>" >
<title>Salary Tracking System</title>

<?php
echo $this->Html->script(array(
					'jquery',
					'jquery.validate',
					'fancybox/jquery.fancybox-1.3.4.pack',
					'fancybox/jquery.mousewheel-3.0.4.pack',
					'datepicker/jquery.ui.core.js',
					'datepicker/jquery.ui.datepicker.js'));
?>
<?php

// cross browser compatibility codes
$default = 'default'; 
if($browserInfo['name']=='Internet Explorer') {
	$default = 'ie_default';
}

echo $this->Html->css(array(
					$default,
					'fancybox/jquery.fancybox-1.3.4'
					));	 
?>
<script type="text/javascript">

	$(document).ready(function() {
		$("#listing_table").find('tr:odd').addClass("odd");
		$("#listing_table").find('tr:even').addClass("even");
		$("#listing_table").find('tr').hover(
			function () {
				$(this).addClass('hover_tr');
				$(this).css('color','white');	
			  }, 
			  function () {
				$(this).removeClass("hover_tr");
				$(this).css('color','black');	
			  }
		);		
		$("ul").find('.side_menu li').hover(
			function () {
				$(this).addClass('hover_tr');
			  }, 
			  function () {
				$(this).removeClass("hover_tr");
			  }
		);
		
		
	});
	function url_redirect(url){		
		window.location.href = url;
	}
	function redirects(link){	
		window.location.href = link;				
	}
	
	// gets numeric part of the currency from str i.e. for $6.00 -> 6.00
	function get_currency(str) {
		str = $.trim(str);
		if(str != '' && str != null)
			str = parseFloat(str.replace(/\$/g, ""));
			
		return str;
	}

	// sets currency str to table in formatted way i.e 6 -> $6.00
	function set_currency(str) { 

		if(str != '' || str == 0)
			str = '$'+round_number(str, 2);
			
		return str;
	}

	// rounds a number and returns.
	// @params:- num:number, dec:precesion
	function round_number(num, dec) {

		var result = String(Math.round(num*Math.pow(10,dec))/Math.pow(10,dec));
		if(result.indexOf('.')<0) {
			result+= '.';
		}
		while(result.length- result.indexOf('.')<=dec) {
			result+= '0';
		}
		
		return result;
	}
	
	// removes disabled button inside a form 
	// params:- form Id of the form inside which the button is located
	function remove_disabled_button(idForm) {
		$('#'+idForm).find('button').removeAttr('disabled');
	}
	
	// disables a button 
	// params:- form Id of the form inside which the button is located
	function add_disabled_button(idForm) {
		$('#'+idForm).find('button').attr("disabled","disabled");
	}
</script>
<body>
<div class="outline_div">
	<div class="main_div">
		<div class="header_div">
			<?php echo $this->element('default_header'); ?>
		</div>
		<div class="leftmenu_div">
			<?php echo $this->element('default_left_menu'); ?>
		</div>
		<div class="content_div">
			<div class="error" align="center" style="color: rgb(255, 0, 0);">		
				  <div id="ajax_msg"><?php echo  $session->flash(); ?> </div>
			</div>
			<?php  echo $content_for_layout; ?>
			<?php  echo $this->element('sql_dump'); ?>
		</div>
		<div class="clear_div"> </div>
		<div class="footer_div"> 
			<?php echo $this->element('default_footer'); ?>
		</div>  
	</div>
</div>
</body>
</html>