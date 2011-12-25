<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://jqueryui.com/ui/jquery.ui.core.js"></script>
<script src="http://jqueryui.com/ui/jquery.ui.datepicker.js"></script>

<script type="text/javascript">

	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			dateFormat : "yy-mm-dd",
			defaultDate: "-1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
				
				// added to check and refresh
				var fromDate = $('#from').val();
				var toDate = $('#to').val();
				if(toDate != '' && fromDate != '') {
					var url='<?php echo $this->Html->url("/users/dashboard/$chartUri"); ?>bill_from_date:'+fromDate+'/bill_to_date:'+toDate;
					window.location.href = url;
				}
			}
		});
	});

	// Load the Visualization API and the controls package.
	// Packages for all the other charts you need will be loaded
	// automatically by the system.
	google.load('visualization', '1.0', {'packages':['controls']});

	// Set a callback to run when the Google Visualization API is loaded.
	<?php if($chartType == 'pie') { ?>
		google.setOnLoadCallback(drawDashboardPie);
	<?php }else if($chartType == 'bar') { ?>
		google.setOnLoadCallback(drawDashboardBar);	
	<?php } ?>

	function drawDashboardPie() {

		// Everything is loaded. Assemble your dashboard...
		
		
        // Create our data table.
        var data = google.visualization.arrayToDataTable([
			<?php echo $chartObjStr; ?>
        ]);

        // Create a dashboard.
        var dashboard = new google.visualization.Dashboard(
          document.getElementById('dashboard_div'));

		// Define a category picker control for the Gender column
		var typePicker = new google.visualization.ControlWrapper({
			'controlType': 'CategoryFilter',
			'containerId': 'filter_div1',
			'options': {
				'filterColumnLabel': 'Type',
				'ui': {
					'labelStacking': 'horizontal',
					'allowTyping': false,
					'allowMultiple': false
				}
			}
		});
		
        // Create a range slider, passing some options
        var totalTimeSlider = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'filter_div2',
          'options': {
            'filterColumnLabel': 'Time'
          }
        });

        // Create a pie chart, passing some options
        var pieChart = new google.visualization.ChartWrapper({
          'chartType': 'PieChart',
          'containerId': 'chart_div',
          'options': {
            'width': 680,
            'height': 340,
            'pieSliceText': 'value',
            'legend': 'right'
          }
        });

        // Establish dependencies, declaring that 'filter' drives 'pieChart',
        // so that the pie chart will only display entries that are let through
        // given the chosen slider range.
        dashboard.bind([totalTimeSlider,typePicker], pieChart);

        // Draw the dashboard.
        dashboard.draw(data);
	}
	

	function drawDashboardBar() {

		// Everything is loaded. Assemble your dashboard...

		// Create our data table.
		var data = google.visualization.arrayToDataTable([
		<?php echo $chartObjStr; ?>
		]);

			
		// Define a category picker control for the Gender column
		var typePicker = new google.visualization.ControlWrapper({
			'controlType': 'CategoryFilter',
			'containerId': 'filter_div1',
			'options': {
				'filterColumnLabel': 'Type',
				'ui': {
					'labelStacking': 'horizontal',
					'allowTyping': false,
					'allowMultiple': false
				}
			}
		});
		
		// Define a NumberRangeFilter slider control for the 'Age' column.
		var totalTimeSlider = new google.visualization.ControlWrapper({
				'controlType': 'NumberRangeFilter',
				'containerId': 'filter_div2',
				'options': {
					'filterColumnLabel': 'Time',
					'minValue': 0,
					'maxValue': <?php echo $maxDuration+100; ?>
				}
			});

		// Define a bar chart
		var barChart = new google.visualization.ChartWrapper({
				'chartType': 'BarChart',
				'containerId': 'chart_div',
				'options': {
					'width': 680,
					'height': 340,
					'hAxis': {'minValue': 0, 'maxValue': 60},
					'chartArea': {top: 50, right: 0, bottom: 0}
				},
				// Configure the barchart to use columns 2 (City) and 3 (Population)
				'view': {'columns': [0, 1]}
			});

		// Create the dashboard.
		var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div')).
		// Configure the slider to affect the bar chart
		bind([totalTimeSlider, typePicker], barChart).
		// Draw the dashboard
		draw(data);

	}
</script>   
<!--<link rel="stylesheet" href="http://jqueryui.com/demos/demos.css">-->
<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css">

<div id="parent_dashboard_div">
	<div id="parent_filter">
		<div id="custom_filter1" class="filter_div">
			<?php
				$toggleTo = ($chartType=='pie')?'bar':'pie';
				echo $this->Html->link("Toggle to ".ucfirst($toggleTo)." Chart", "dashboard/$dateUri/chart_type:$toggleTo"); 
			?>
		</div>
		<div id="custom_filter2" class="filter_div">
			<label for="from">From</label>
			<input type="text" id="from" name="bill_from_date" value="<?php echo $billFromDate; ?>" readonly="readonly"/>
			<label for="to">to</label>
			<input type="text" id="to" name="bill_to_date" value="<?php echo $billToDate; ?>"  readonly="readonly"/>
		</div>
		
		<div id="filter_div1" class="filter_div"></div>
		<div id="filter_div2" class="filter_div"></div>
	</div>
	<!--Div that will hold the dashboard-->
	<div id="dashboard_div">

		<div id="chart_div"></div>
	</div>
</div>
