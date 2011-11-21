<?php 
class AppController extends Controller {

var $components = array('Session','Cookie','RequestHandler','Email');
var $helpers = array('Ajax','Javascript','Html','Session');


/**
 * Function takes a minutes and convert into hour format
 *	i/p: 130 -> o/p: 2:10
 */
	function convertMinutes2Hours($minutes) {
		if ($minutes < 0) {
			$min = Abs($minutes);
		}else {
			$min = $minutes;
		}
		$iHours = floor($min / 60);
		$minutes = ($min - ($iHours * 60)) / 100;
		$tHours = $iHours + $minutes;
		if ($minutes < 0) {
			$tHours = $tHours * (-1);
		}
		$aHours = explode(".", $tHours);
		$iHours = $aHours[0];
		if (empty($aHours[1])) {
			$aHours[1] = "00";
		}
		$minutes = $aHours[1];
		if (strlen($minutes) < 2) {
			$minutes = $minutes ."0";
		}
		$tHours = $iHours .":". $minutes;
		return $tHours;
	}
}
?>