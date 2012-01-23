<?php 
class AppController extends Controller {

var $components = array('Session','Cookie','RequestHandler','Email');
var $helpers = array('Ajax','Javascript','Html','Session');


/**
 * Function executes before executed before 
 * every action in the controller.
 */
	function beforeFilter() {

	}

	
/**
 * Function executes after controller action logic, 
 * but before the view is rendered. 
 */	
	function beforeRender() {
			
		$this->set('browserInfo', $this->getBrowser());	
	}
	
	
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
	
	
/**
 * Function runs and return the info about the browser
 * o/p - userAgent,name,version,platform,pattern of the browser
 */
	function getBrowser() {
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";

		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
	   
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} elseif(preg_match('/Firefox/i',$u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} elseif(preg_match('/Chrome/i',$u_agent)) {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} elseif(preg_match('/Safari/i',$u_agent)) {
			$bname = 'Apple Safari';
			$ub = "Safari";
		} elseif(preg_match('/Opera/i',$u_agent)) {
			$bname = 'Opera';
			$ub = "Opera";
		} elseif(preg_match('/Netscape/i',$u_agent)) {
			$bname = 'Netscape';
			$ub = "Netscape";
		}
	   
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
	   
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			} else {
				$version= $matches['version'][1];
			}
		} else {
			$version= $matches['version'][0];
		}
	   
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
	   
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
	}


	
/**
 * Functions extracts and returns the extension 
 * any file.
 */
	function findExts($filename){ 
		$filename = strtolower($filename) ; 
		$exts = split("[/\\.]", $filename) ; 
		$n = count($exts)-1; 
		$exts = $exts[$n]; 
		return $exts; 
	}
	
	
/**
 * Functions extracts and returns the extension 
 * any file.
 */
	function firstOfMonth() {
		return date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
	}

	
/**
 * Functions extracts and returns the extension 
 * any file.
 */
	function lastOfMonth() {
		return date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
	}
	
	
}
?>