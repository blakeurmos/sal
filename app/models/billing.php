<?php
class Billing extends AppModel {
	var $name = 'Billing';

	var $validate = array(
		'user_id' => array(
			'rule1' => array(
				'rule' => array('numeric'),
				'message' => 'Your custom message here'
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'bill_to' => array(
			'rule1' => array(
				'rule' => array('inList', array('M','I','SF','NB','DA')),
				'message' => 'Please enter the billed to field.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),		
		'bill_date' => array(
			'rule1' => array(
				'rule' => array('date'),
				'message' => 'Please enter your date',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'client_name' => array(
			'rule1' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter the client name',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'case_no' => array(
			'rule1' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter a numeric value',
				'allowEmpty' => true,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'appointment_time' => array(
			'rule1' => array(
				'rule' => array('time'),
				'message' => 'Please enter appointment time.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'duration' => array(
			'rule1' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter the duration.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'type' => array(
			'rule1' => array(
				'rule' => array('inList', array(null,'CPST','THER-M','THER-I','THER-SF')),
				'message' => 'Please select the type.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),	
		'cpt' => array(
			'rule1' => array(
				'rule' => array('inList', array(null,'90801','90804','90806','90808','90857','90899')),
				'message' => 'Please choose the cpt code.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),		
		'diag' => array(
			//'rule1' => array(
				//'rule' => array('notEmpty'),
				//'message' => 'Please enter the diagnosis.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//)
		),
		'gr_c_so' => array(
			'rule1' => array(
				'rule' => array('inList', array(null,'GR','C','SO')),
				'message' => 'Please choose a value.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'sch_off_hv' => array(
			'rule1' => array(
				'rule' => array('inList', array(null,'SCH','OFF','HV')),
				'message' => 'Please choose a value.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'status' => array(
			'rule1' => array(
				'rule' => array('boolean')
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	
	
/**
 * Function reads the uploaded csv file and 
 * inserts into billing tb.
 */ 
	function db_insert_from_csv($filename, $userId) {
	
		$fieldNames = array_keys($this->getColumnTypes());
		$handle = fopen($filename, "r");
 		$xtraFieldNames = fgetcsv($handle);	
 		$header = fgetcsv($handle);

		
		ini_set('memory_limit','128M');
		ini_set('max_execution_time',900);
		
		mysql_query('SET AUTOCOMMIT=0;');
		mysql_query('START TRANSACTION;');
			
		$lineNo = 1;
 		while (($row = fgetcsv($handle)) !== FALSE) {/* loops through each rows in the csv file and inserts it into database */
 			$lineNo++;
 			$data = array();
			$data['user_id'] 		= $userId;
			$data['bill_to'] 		= strtoupper($row[0]);
			$data['bill_date'] 		= date('Y-m-d',strtotime($row[1].' '.$row[2].' '.$row[3]));
			$data['client_name']	= $row[4];
			$data['case_no']		= $row[5];
			$data['appointment_time']= date('H:i:s',strtotime($row[6]));
			$data['duration'] 		= $row[7];
			$data['type'] 			= str_replace('/', '-', strtoupper($row[8]));
			$data['cpt'] 			= $row[9];
			$data['diag'] 			= $row[10];
			$data['gr_c_so'] 		= strtoupper($row[11]);
			$data['sch_off_hv'] 	= strtoupper($row[12]);
			$this->create();
			if(!$this->save($data)) {
			 	fclose($handle);
				mysql_query('ROLLBACK;');
				return array('status'=>0, 'msg'=>'Error: Please check line no '.$lineNo.' for error.');
			}
 		}
 		fclose($handle);
		mysql_query('COMMIT;');
		return array('status'=>1, 'msg'=>'Success: '.($lineNo-1).' number of bills inserted'); 	
	}
	
}