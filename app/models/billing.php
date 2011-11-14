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
				'rule' => array('inList', array('M','I','SF','NB')),
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
				'message' => 'Please enter case no.',
				//'allowEmpty' => false,
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
				'rule' => array('inList', array('CPST','THER-M','THER-I','THER-SF')),
				'message' => 'Please select the type.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),	
		'cpt' => array(
			'rule1' => array(
				'rule' => array('inList', array('90801','90804','90806','90808','90857','90899')),
				'message' => 'Please choose the cpt code.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),		
		'diag' => array(
			'rule1' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter the diagnosis.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'gr_c_so' => array(
			'rule1' => array(
				'rule' => array('inList', array('GR','C','SO')),
				'message' => 'Please choose a value.',
				//'allowEmpty' => false,
				//'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'sch_off_hv' => array(
			'rule1' => array(
				'rule' => array('inList', array('SCH','OFF','HV')),
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
}
