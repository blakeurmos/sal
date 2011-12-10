<?php
class BillingsController extends AppController {
	var $name = 'Billings';
	var $uses = array('Billing');
	var $components = array('Auth');
	
	
/**
 * Function executes before executed before 
 * every action in the controller.
 */
	function beforeFilter() {
	
		$userinfo=$this->Session->read('Auth');
		$this->disableCache();
		$this->layout='default_layout';
		parent::beforeFilter();
	}
	
	
/**
 * Function executes after controller action logic, 
 * but before the view is rendered. 
 */	
	function beforeRender() {
	
		parent::beforeRender();
	}
	
	
/**
 * Function is made just for the landing page 
 * after user logins successfully.
 */
	function index() {
		
	}
	
	
/**
 * Functiion handle reading the posted variables, 
 * and redirecting back to the list url.
 */
	function searchRedirect() {
	
		$str = '';
		foreach($this->data['Billing'] as $key=>$value){
			if($key == 'bill_date') {
				if($value['month']!=='' && $value['day']!=='' && $value['year']!=='')
					$this->data['Billing'][$key] = $value['year'].'-'.$value['month'].'-'.$value['day'];
				else
					continue;
			}

			if($this->data['Billing'][$key]){
				$str .= $key.':'.$this->data['Billing'][$key].'/';
			}
		}
		$this->redirect(array('controller'=>'billings', 'action'=>'lists',$str));       
	}
	
	
/**
 * Function applies the search conditions and
 * shows list of all billings for the 
 * user logged in.
 */
	function lists() {

		//pr($this->passedArgs);
		$billDate   = isset($this->passedArgs['bill_date'])?$this->passedArgs['bill_date']:'';
		$clientName = isset($this->passedArgs['client_name'])?$this->passedArgs['client_name']:'';
		$billTo     = isset($this->passedArgs['bill_to'])?$this->passedArgs['bill_to']:'';
		$type 		= isset($this->passedArgs['type'])?$this->passedArgs['type']:'';	
		
		$caseNo 	= isset($this->passedArgs['case_no'])?$this->passedArgs['case_no']:'';	
		$apptTime 	= isset($this->passedArgs['appointment_time'])?$this->passedArgs['appointment_time']:'';	
		$duration 	= isset($this->passedArgs['duration'])?$this->passedArgs['duration']:'';	
		$cpt 		= isset($this->passedArgs['cpt'])?$this->passedArgs['cpt']:'';	
		$diag 		= isset($this->passedArgs['diag'])?$this->passedArgs['diag']:'';	
		$gr_c_so 	= isset($this->passedArgs['gr_c_so'])?$this->passedArgs['gr_c_so']:'';	
		$sch_off_hv = isset($this->passedArgs['sch_off_hv'])?$this->passedArgs['sch_off_hv']:'';	
		
		$username = isset($this->passedArgs['username'])?$this->passedArgs['username']:'';	
		
		$printView  = isset($this->passedArgs['print_preview'])?$this->passedArgs['print_preview']:'';

		$this->data['Billing']= $this->passedArgs;
		
		$userinfo 	 = $this->Session->read('Auth.User');	
		$conditions  = array();
		
		// if log'd in user is not admin user
		if($userinfo['type']!='1') {
			
			// user is supervisor then
			if($userinfo['type']=='4' && $userinfo['access_to_ids']!='') {
			
				$ids = explode(',', $userinfo['access_to_ids'].', '.$userinfo['id']);
				$conditions += array('Billing.user_id'=>$ids);
			}else {
				// any other user
				$conditions += array('Billing.user_id'=>$userinfo['id']);
			}
		}
		$conditions += array('Billing.is_deleted'=>0);

		if($billDate){
			$conditions += array('Billing.bill_date'=>$billDate);
		}	
		if($clientName){
			$conditions += array('Billing.client_name LIKE'=>'%'.$clientName.'%');
		}		
		if($billTo){
			$conditions += array('Billing.bill_to'=>$billTo);
		}		
		if($type){         
			$conditions += array('Billing.type'=>$type);
		}		           
		if($caseNo){         
			$conditions += array('Billing.case_no'=>$caseNo);
		}                  
		if($apptTime){         
			$conditions += array('Billing.appointment_time'=>$apptTime);
		}                  
		if($duration){         
			$conditions += array('Billing.duration'=>$duration);
		}                  
		if($cpt){         
			$conditions += array('Billing.cpt'=>$cpt);
		}                  
		if($diag){         
			$conditions += array('Billing.diag'=>$diag);
		}
		if($gr_c_so){         
			$conditions += array('Billing.gr_c_so'=>$gr_c_so);
		}
		if($sch_off_hv){         
			$conditions += array('Billing.sch_off_hv'=>$sch_off_hv);
		}
		if($username){         
			$conditions += array('User.username'=>$username);
		}
		$params = array(
					'conditions'=>$conditions,
					'order'=>'Billing.created DESC'
					);
		$records = $this->Billing->find('all',$params);
		$this->set('records',$records);
		if($printView==1) {
			$this->layout = 'ajax';
			$this->render('lists_print_preview');
		}

	}
	
	
/**
 * Function used to add/edit billing by the
 * authenticated user.	
 */
	function add_new() {
	
		if(isset($this->params['named']['id'])){ 
				$this->data = $this->Billing->findById($this->params['named']['id']);
		}else{
			if(isset($this->data)){
			
				if(empty($this->data['Billing']['id']))
					$this->data['Billing']['user_id'] = $this->Session->read('Auth.User.id');
					
				if($this->Billing->save($this->data)){
					if(empty($this->data['Billing']['id']))
						$this->Session->setFlash('Billing record added successfully');
					else 
						$this->Session->setFlash('Billing record updated successfully');
					$this->redirect(array('controller'=>'billings','action'=>'lists'));	
				}	
				//debug($this->data);
			}
		}
	}	
	
	
/**
 * Function removes an billing entry(set is_deleted=1)
 * via ajax.
 */
	function delete() { 
	
		$this->layout='ajax';
		$this->Billing->id = $this->params['form']['id'] ;
		$statusArr = array('success'=>0, 'message'=>'');
		if($this->Billing->saveField('is_deleted',1)){
			$statusArr['success']=1;
			$statusArr['message']='Record removed successfully.';
		}else{
			$statusArr['message']='Error Occured, operation unsuccessful.';
		}
		echo json_encode($statusArr);
		exit;
	}
	
	
/**
 *
 */
	function get_bill_detail() {
	
		$statusArr = array('success'=>0, 'message'=>'');
		if(isset($this->params['form']['billId']) && ($this->params['form']['billId']!='')) {
			$this->Billing->id = $this->params['form']['billId'] ;
			$this->Billing->recursive = -1 ;
			$record = $this->Billing->read();
			$billRecord = $record['Billing'];
			$billRecord['success'] = 1;
		}else {
			$billRecord['success'] = 0;
			$billRecord['message'] = 'Record now found in db';
		}
		echo json_encode($billRecord);
		exit;
	}
	
	
/**
 * Function pulls  the client list of the logged in
 * user and sends to view in key=>val array
 */
	function get_client_list() {
	
		$userId = $this->Session->read('Auth.User.id');
		
		$options = array();
		$options['fields'] = array('last_id', 'client_name');
		$options['conditions'] = array('Billing.user_id'=>$userId);
		$options['order'] = 'Billing.client_name ASC';
		$options['group'] = 'Billing.client_name';
		
		$this->Billing->virtualFields = array('last_id' => 'MAX(Billing.id)');
		
		return $this->Billing->find('list', $options);
	}
	
	
/**
 * Function pulls all unique client names of the logd in user
 * Its is used to generate client name drop down
 */
	function get_client_name() {
	
		$loginUserInfo = $this->Session->read('Auth.User');
	
		$conditions = array();
		//if log'd in user is not admin user
		if($loginUserInfo['type']!='1') {
			
			//user is supervisor then
			if($loginUserInfo['type']=='4' && $loginUserInfo['access_to_ids']!='') {
			
				$ids = explode(',', $loginUserInfo['access_to_ids'].', '.$loginUserInfo['id']);
				$conditions += array('Billing.user_id'=>$ids);
			}else {
				//any other user
				$conditions += array('Billing.user_id'=>$loginUserInfo['id']);
			}
		}
		$options = array();
		$options['fields'] = array('client_name', 'client_name');
		$options['conditions'] = $conditions;
		$options['order'] = 'Billing.client_name ASC';
		$options['group'] = 'Billing.client_name';
				
		return $this->Billing->find('list', $options);
	}
	
}