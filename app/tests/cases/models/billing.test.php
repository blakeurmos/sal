<?php
/* Billing Test cases generated on: 2011-10-29 08:31:08 : 1319877068*/
App::import('Model', 'Billing');

class BillingTestCase extends CakeTestCase {
	var $fixtures = array('app.billing', 'app.user');

	function startTest() {
		$this->Billing =& ClassRegistry::init('Billing');
	}

	function endTest() {
		unset($this->Billing);
		ClassRegistry::flush();
	}

}
