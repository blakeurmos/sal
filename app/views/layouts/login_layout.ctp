<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Salary Tracking System</title>
<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/led-ico/money_dollar.png'); ?>" >

<?php
echo $html->script(array());


// cross browser compatibility codes
$default = 'default'; 
$login = 'login';
if($browserInfo['name']=='Internet Explorer') {
	$default = 'ie_default';
	$login = 'ie_login';
}


echo $html->css(array($default,$login));	 
?>
</head>

<body>
<div class="outline_div">
	<div class="main_div">
		<div class="header_div">
			<?php echo $this->element('default_header'); ?>
		</div>
		<div class="leftmenu_div">
			<?php  echo $content_for_layout; ?>
		</div>
		<div class="content_div">
			Please put the general information about this site.
			Please put the general information about this site.
			Please put the general information about this site.
			Please put the general information about this site.
			Please put the general information about this site.
			Please put the general information about this site.
			Please put the general information about this site.
			<?php //echo $this->element('sql_dump'); ?>
		</div>
		<div class="clear_div"> </div>
		<div class="footer_div"> 
			<?php echo $this->element('default_footer'); ?>
		</div>  
	</div>
</div>
</body>
</html>
