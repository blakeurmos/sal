<?php
class User extends AppModel {
	var $name = 'User';
	var $validate = array(
		'username' => array(
			'rule1' => array(
				'rule' => array('notempty'),
				'message' => 'username cannot be left blank.',
			),					
			'rule2' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Usernames must alpha numeric.',
			),					
			'rule3' => array(
				'rule' => array('isUnique'),
				'message' => 'This username has already been taken.',
			)			
		),
		'password' => array(
			'rule1' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your password.',
				'on'=>'create'
			)
		),
		'first_name' => array(
			'rule1' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter first name.',
			)
		),
		'last_name' => array(
			'rule1' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter the last name.',
			)
		),
		'rate' => array(
			'rule1' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter a numeric value',
			)
		),
		'type' => array(
			'rule1' => array(
				'rule' => array('notempty'),
				'message' => 'Please choose user type.',
			)
		)
	);
	
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Billing' => array(
			'className' => 'Billing',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
