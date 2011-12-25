<?php
class UsersController extends AppController {
	var $name = 'Users';
	var $uses = array('User');
	var $components = array('Auth');
	
	
	
/**
 * Function executes before another function
 * in the controller.
 */
	function beforeFilter() {
	
		$this->disableCache();
		$this->Auth->fields = array('username'=>'username','password'=>'password');
		$this->Auth->loginRedirect = array('controller' => 'billings', 'action' => 'index');
		$this->Auth->autoRedirect = false;
		$this->Auth->userScope = array('User.is_deleted' => 0);
		$this->Auth->allow('login');
		Security::setHash('SHA1');//debug($this->Auth->password($this->data['User']['password']));exit;
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
 * Function authenticates and logins user
 * into the system using Auth component.
 */
	function login() {
	
		$this->layout='login_layout';
		if( !(empty($this->data)) && $this->Auth->user() ){	

			$this->User->id = $this->Auth->user('id');
			$this->User->saveField('last_login', date('Y-m-d H:i:s') );
			$this->Session->setFlash('Login successful');
			$this->redirect($this->Auth->redirect());
		}
		
		if($this->Auth->user()) 
			$this->redirect($this->Auth->redirect());
	}
	
	
	
/**
 * Functions logs the user out
 * It destrys all sessions and cookies automagically.
 */
	function logout() {
	
		$this->Auth->logout();
		$this->redirect('/users/login');
	}

	
	
/**
 * Function shows list of all users 
 * in the system
 */
	function lists() {
	
		$this->layout='default_layout';
		$userInfo 	 = $this->Session->read('Auth.User');	
		
		if($userInfo['type'] != '1') {
			$this->Session->setFlash('You are not authorized to access this feature');
			$this->redirect('/billings/index');
		}

		$conditions  = array();
		$conditions += array('User.is_deleted'=>0);	
		$params = array(
					'conditions'=>$conditions,
					'order'=>'User.created DESC'
					);
		$records = $this->User->find('all',$params);
		$this->set('records',$records);
	}

	
	
/**
 * Function used to add/edit users by the
 * admin authorized user.	
 */
	function add_new() {
	
		$this->layout='default_layout';

		if(isset($this->params['named']['id'])){ 
				$this->data = $this->User->findById($this->params['named']['id']);
				$this->data['User']['password']='';
		}else{
			if(isset($this->data)){
			
				//if password is blank then unset it during update
				if(($this->data['User']['id']!='') && 
					$this->data['User']['password']=='77dab907730fceed27ce6f43e727e822e7caf436') {

					unset($this->data['User']['password']);
				}
					
				if($this->User->save($this->data)){
					if(empty($this->data['User']['id']))
						$this->Session->setFlash('User record added successfully');
					else 
						$this->Session->setFlash('User record updated successfully');
					$this->redirect(array('controller'=>'users','action'=>'lists'));	
				}else {	
					//always remove the value these fields if validation errors!
					$this->data['User']['password']='';
					$this->data['User']['confirm_pwd']='';
				}
			}
		}
	}
	
	
	
/**
 * Function removes an billing entry(set is_deleted=1)
 * via ajax.
 */
	function delete() {
	
		$this->layout='ajax';
		$this->User->id = $this->params['form']['id'] ;
		$statusArr = array('success'=>0, 'message'=>'');
		if($this->User->saveField('is_deleted',1)){
			$statusArr['success']=1;
			$statusArr['message']='Record removed successfully.';
		}else{
			$statusArr['message']='Error Occured, operation unsuccessful.';
		}
		echo json_encode($statusArr);
		exit;
	}

	
	
/**
 * Function pulls the rate from db for the logged
 * in user via requestAction.
 */
	function my_rate() {
	
		$this->User->id = $this->Session->read('Auth.User.id');
		$this->data = $this->User->read('rate, school');
		$this->render('my_rate');
	}

	
	
/**
 * Function just updates 'rate' field of user tb
 * on ajax request
 */
	function update_user_rate() {
	
		$this->layout= 'ajax';
		$statusArr = array('success'=>0, 'message'=>'');
		$this->User->id = $this->Session->read('Auth.User.id');
		if($this->User->save($this->data, true)) {
			$this->Session->write('Auth.User.rate', $this->data['User']['rate']);
			$this->Session->write('Auth.User.school', $this->data['User']['school']);
			$statusArr['success']=1;
			$statusArr['message']='Updated successfully';		
		}else{
			$statusArr['message']='Error Occured, operation unsuccessful.';		
		}
		echo json_encode($statusArr);
		exit;
	}
	
	
	
/**
 * Functions get the list of all users except admin
 *
 */
	function get_username_list() {
	
		$this->layout= 'ajax';

		$loginUserInfo = $this->Session->read('Auth.User');

		if($loginUserInfo['type']=='1') {
			$options = array(
					'fields'=>'User.username, User.username',
					'conditions'=>array('User.is_deleted'=>'0'),
					'order' => 'User.username ASC'
				);
			$this->User->recursive = -1 ;
			//$this->User->virtualFields = array('full_name' => 'CONCAT(User.first_name, " " , User.last_name)');

			$systemUsernameList = $this->User->find('list',$options);
			return $systemUsernameList;
			
		}else {
			return array();
		}
	}

	
/**
 * Functions get the list of all users except admin
 *
 */
	function get_user_list() {
	
		$this->layout= 'ajax';

		$statusArr = array('success'=>0, 'message'=>'', 'content'=>'');
		$userInfo = $this->Session->read('Auth.User');
		$supervisorId = $this->params['form']['id'];
		if($userInfo['type']=='1') {
			$options = array(
					'fields'=>'User.id, User.full_name',
					'conditions'=>array('User.type !='=>'1', 'User.is_deleted'=>'0', 'User.id !='=>$supervisorId),
					'order' => 'User.full_name ASC'
				);
			$this->User->recursive = -1 ;
			$this->User->virtualFields = array('full_name' => 'CONCAT(User.first_name, " " , User.last_name)');

			$systemUserList = $this->User->find('list',$options);
			
			$this->set('systemUserList',$systemUserList);
			$this->set('supervisorInfo', $this->User->read('id, full_name, access_to_ids', $supervisorId));
		}
	}	

	
/**
 * Functions re-assign users for supervisor.
 * 
 */
	function update_user_assignment() {
		
		$this->layout = 'ajax';
		$userInfo = $this->Session->read('Auth.User');
		$statusArr = array('success'=>0, 'message'=>'', 'content'=>'');

		if($userInfo['type']!='1') {
		
			echo json_encode($statusArr);
			exit;
		}
		
		if(empty($this->data['User']['id'])) {
		
			echo json_encode($statusArr);
			exit;
		}
		
		if(isset($this->data['User']['access_to_ids'])) {
		
			$this->data['User']['access_to_ids'] = implode(',', $this->data['User']['access_to_ids']);	
			$statusArr['success'] = ($this->User->save($this->data, true))?1:0;
		}
		
		echo json_encode($statusArr);
		exit;
	}
	
	
	
/**
 * Function gets the upload form for csv file.
 *
 */
	function get_csv_upload_form() {
	
		$this->layout= 'ajax';
		$statusArr = array('success'=>0, 'message'=>'', 'content'=>'');
		$loginUserInfo = $this->Session->read('Auth.User');
		$userId = $this->params['form']['id'];
		
		if($userId == '') {
			
			$statusArr['message'] = 'Error:';
			echo json_encode($statusArr);
			exit;
		}
		
		if($loginUserInfo['type']!='1') {
			
			$statusArr['message'] = 'Error:';
			echo json_encode($statusArr);
			exit;
		}	
		
		$this->User->recursive = -1 ;
		$this->User->virtualFields = array('full_name' => 'CONCAT(User.first_name, " " , User.last_name)');		
		$this->set('userInfo', $this->User->read('id, full_name', $userId));
	}
	
/**
 * Function uploads the csv file and inserts records into db
 *
 */
	function upload_csv() {
	
		$this->layout= 'ajax';
		$fileInfo = $this->data['User'];
		$status = 0;
		$userId =  $this->data['User']['user_id'];

		// check if the form has been submitted blank.
		if(empty($fileInfo['bill_csv']['name'])){
			$msg = 'Please select a file to upload';
			echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload('.$status.',"'.$msg.'",'.$userId.');</script> ';
			exit;
		}
		
		// check whether the correct file has been uploaded
		$fileExt = $this->findExts($fileInfo['bill_csv']['name']);
		if($fileExt != 'csv') {
			$msg = 'Please upload a CSV file to import';
			echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload('.$status.',"'.$msg.'",'.$userId.');</script> ';
			exit;		
		}
		
		$tmpName = $fileInfo['bill_csv']['tmp_name'];
		$destFileName = 'csv_uploads/'.rand().'_'.$fileInfo['bill_csv']['name'];
		if(!copy($tmpName,$destFileName)){
			$msg = 'File couldnot be uploaded due to some error';
			echo '<script language="javascript" type="text/javascript">window.top.window.stopUpload('.$status.',"'.$msg.'",'.$userId.');</script> ';
			exit;	
		}

		// insert queries and commit if success
		$statusArr = $this->User->Billing->db_insert_from_csv($destFileName, $userId);
		sleep(3);

		echo '<script language="javascript" type="text/javascript">
			 window.top.window.stopUpload('.$statusArr['status'].',"'.$statusArr['msg'].'",'.$userId.');
			 </script> ';
		exit;
	}
	
	
/**
 * function is used to show google charts.
 *
 */
	function dashboard() {
		$this->layout='default_layout';
		
		$chartType    = isset($this->passedArgs['chart_type'])?$this->passedArgs['chart_type']:'bar';
		$billFromDate = isset($this->passedArgs['bill_from_date'])?$this->passedArgs['bill_from_date']:'';
		$billToDate   = isset($this->passedArgs['bill_to_date'])?$this->passedArgs['bill_to_date']:'';
		
		$dateUri = '';
		$chartUri = '';
		if($billFromDate && $billToDate)
			$dateUri = "bill_from_date:$billFromDate/bill_to_date:$billToDate/";
		if($chartType != '')
			$chartUri .= "chart_type:$chartType/";

		
		$userinfo 	 = $this->Session->read('Auth.User');	
		$conditions  = array();
		
		// if log'd in user is not admin user
		if($userinfo['type'] != '1') {
			
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
		
		if($billFromDate && $billToDate){
			$conditions += array('Billing.bill_date BETWEEN ? AND ?'=>array($billFromDate, $billToDate));
		}	
		$params = array(
					'recursive' => -1, //int
					'fields' => array(
									'Billing.client_name', 
									'Billing.type', 
									'Billing.duration', 
									'Billing.case_no', 
									'SUM(Billing.duration) as totalDuration',
									'Billing.bill_date'), //array of field names
					'conditions'=>$conditions,
					'order'=>'Billing.created DESC',
					'group'=>'Billing.case_no'
					);
					
		// load Model and fits it into controller 
		Controller::loadModel('Billing');
		$records = $this->Billing->find('all',$params);
		
		// var used to draw google map
		$chartObjStr = "['ClientName', 'Time', 'Type']";
		$maxDuration = 0;
		foreach($records as $key=>$val) {
	
			$records[$key]['Billing']['totalDuration'] = $val[0]['totalDuration'];
			unset($records[$key][0]);
			extract($records[$key]['Billing']);
			$chartObjStr .= ",['".$client_name."', ".$totalDuration.", '".$type."']";
			$maxDuration = ($totalDuration > $maxDuration)?$totalDuration:$maxDuration;
		}
		

		$this->set(compact('chartObjStr', 'records', 'chartType', 'dateUri', 'chartUri', 'billFromDate', 'billToDate', 'maxDuration'));
	
	}
}