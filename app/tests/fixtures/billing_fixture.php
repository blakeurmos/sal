<?php
/* Billing Fixture generated on: 2011-10-29 08:31:08 : 1319877068 */
class BillingFixture extends CakeTestFixture {
	var $name = 'Billing';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'bill_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'client_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'case_no' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'appointment_time' => array('type' => 'time', 'null' => false, 'default' => NULL),
		'duration' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'diag' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'bill_date' => '2011-10-29',
			'client_name' => 'Lorem ipsum dolor sit amet',
			'case_no' => 1,
			'appointment_time' => '08:31:08',
			'duration' => 1,
			'diag' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-10-29 08:31:08',
			'modified' => '2011-10-29 08:31:08',
			'status' => 1
		),
	);
}
