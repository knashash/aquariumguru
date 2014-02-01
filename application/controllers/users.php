<?php
  /**
   * Media Controller Class
   *
   * @package keepsayk
   **/
  class Users extends MY_Controller {

    /**
     * Controller Constructor
     *
     * @return void
     **/
    public function __construct() {
      parent::__construct();
	  //$this->load->model('users');
    }

	/**New user sign up
     * 
     *
     *
     * @return void
     **/
    public function sign_up() {
		
		if (!$this->input->post('first_name')) $this->_json_error("Missing first name");
		if (!$this->input->post('last_name')) $this->_json_error("Missing last name");
		if (!$this->input->post('email')) $this->_json_error("Missing email");
		if (!$this->input->post('password')) $this->_json_error("Missing password");

		if (!$this->validEmail($this->input->post('email'))) $this->_json_error("Please enter a valid email address");

		$email_registered = $this->users->email_registered($this->input->post('email'));
		if ($email_registered) $this->_json_error("This email is already registered with Keepsayk");
		
		$salt = $this->users->generate_salt();
		$password = sha1($salt.$this->input->post('password'));
		
		$data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name'  => $this->input->post('last_name'),
			'email'  => $this->input->post('email'),
			'password'  => $password,
			'salt'  => $salt,
			'created_on'  => time()
        );

		$user_id = $this->users->add_user($data);
		$this->send_activation_link($user_id);
		$status['message'] = 'User added. Activation link sent.';
		$status['id'] = $user_id;
		echo json_encode($status);
    }


	/**
     * Send the user an activation link
     *
     * @return void
     **/
    private function send_activation_link($user_id) {
        $this->load->library('email');
		$config['mailtype'] = 'html';
		
		$user = $this->users->get_user($user_id);
		$this->email->initialize($config);

        $this->email->from(EMAIL_NO_REPLY, EMAIL_NO_REPLY_SENDER);
        $this->email->to($user->email);
        $this->email->subject('Activate your account');
		$msg = $this->load->view('layouts/email', array('view' => 'emails/activation_link','user' => $user), TRUE);
		$this->email->message($msg);
		
		#$this->email->message();
		
		
        $this->email->send();
		#echo $site_url;
        #redirect('login/check_your_email');
    }
	
	
	/**Activate the user account
     * 
     *
     * @param int $user_id The user id
	 * @param string $key The salt key
     *
     * @return void
     **/
	public function activate($user_id, $key) {
		
		$user = $this->users->get_user($user_id);
		
		$data = array(
               'active' => 'Y',
			   'last_login' => time()
            );

		$result = $this->users->activate($user_id, $key, $data);
		$success="no";
		if ($result['error']) $status['message'] = $result['message'];
		else {
			//create user upload and thumbs dir
			
			$upload_dir = FCPATH."/user_uploads/".$user_id;
			$oldumask = umask(0);
			mkdir($upload_dir, 02775);
			umask($oldumask);
			//chmod($upload_dir, 02775);
			$thumbs_dir = $upload_dir.'/thumbs';
			$oldumask = umask(0);
			mkdir($thumbs_dir, 02775);
			umask($oldumask);
			//chmod($thumbs_dir, 2775);
		
			$this->users->create_circle($user_id);
			
			$status['message'] = "SUCCESS! Your account is now active. Please sign in below.";
			$status['id'] = $user_id;
			$success="yes";
			//echo json_encode($status);
		}

		$this->load->view('header', array(
        'title' => 'Keepsayk: Account Activated',
        'desc'  => 'Meta tag descriptions',
        'meta'  => 'Meta tag stuff'
      ));

	  $msg = $status['message'];
      $this->load->view('market_nav');
      $this->load->view('confirmation',array('message' => $msg, 'success' => $success));
      $this->load->view('footer', array('js_file' => '<script type="text/javascript" src="/js/confirmation.js"></script>'));
    }


	/**
     * Check the login, redirect the user as needed
     *
     * @return void
     **/
    public function login() {
	  
	  $pword = $this->input->post('password');
	  if (!$pword) $pword = $this->input->post('pword');
	  $username = $this->input->post('username');
	  
	  if (!$username || !$pword) $this->_json_error('Invalid email or password');
	  
      $user = $this->users->is_active_user($username, $pword);
	  if($user) {
		$_SESSION['user_id'] = $user->ID;
        $_SESSION['username'] = $username;
		
		$username_arr = explode("@",$username);
		$_SESSION['username_abbr'] = $username_arr[0];
		$_SESSION['user_fname'] = $user->first_name;

        $status['message'] = "Login successful";
		$status['id'] = $user->ID;

		$key = $this->users->set_api_key($user->ID);
		
		$status['api_key'] = $key;
		/*
		if(isset($_SESSION['redirect_to'])) {
          if(strpos($_SESSION['redirect_to'], 'login') !== FALSE) {
            redirect('/');
          }
          $to = $_SESSION['redirect_to'];
          unset($_SESSION['redirect_to']);
          redirect($to);
        } else {
          redirect('/');
        }
		*/
		echo json_encode($status);
      } 
	  else $this->_json_error('Invalid email or password');
    }


	/**
     * Check the login, redirect the user as needed
     *
     * @return void
     **/
    public function display_login() {
	  
	  $pword = $this->input->post('password');
	  if (!$pword) $pword = $this->input->post('pword');
	  $username = $this->input->post('username');
	  
	  if (!$username || !$pword) $this->_json_error('Invalid email or password');
	  
      $user = $this->users->is_active_user($username, $pword);
	  if($user) {
		$_SESSION['user_id'] = $user->ID;
        $_SESSION['username'] = $username;
		
		$username_arr = explode("@",$username);
		$_SESSION['username_abbr'] = $username_arr[0];
		$_SESSION['user_fname'] = $user->first_name;

        $status['message'] = "Login successful";
		$status['id'] = $user->ID;

		$key = $this->users->set_api_key($user->ID);
		
		$status['api_key'] = $key;
		/*
		if(isset($_SESSION['redirect_to'])) {
          if(strpos($_SESSION['redirect_to'], 'login') !== FALSE) {
            redirect('/');
          }
          $to = $_SESSION['redirect_to'];
          unset($_SESSION['redirect_to']);
          redirect($to);
        } else {
          redirect('/');
        }
		*/
		echo json_encode($status);
      } 
	  else $this->_json_error('Invalid email or password');
    }


    /**
     * Display the reset password page
     *
     * @return void
     **/
    public function forgot() {
      $this->load->view('authentication/reset_password');
    }


    /**
     * Display the check your email page
     *
     * @return void
     **/
    public function check_your_email() {
      $this->load->view('authentication/reset_sent');
    }


    /**
     * Display the actual reset passsword form
     *
     * @param string $key The key that gets emailed to the user
     *
     * @return void
     **/
    public function reset_password($key = NULL) {
	  if($key === NULL) {
        redirect('/');
      } else {
        $user = $this->users->get_by_reset_key($key);
        if($user === FALSE) {
          redirect('/');
        } else {
          //$reset_form = $this->load->view('authentication/reset_form', array('user' => $user), TRUE);
		  //$status['form_string'] = $reset_form;
		  //echo json_encode($status);

		  $code = $user->forgotten_password_code;
		  
		  $this->load->view('header', array(
			'title' => 'Keepsayk: Reset Your Password',
			'desc'  => 'Meta tag descriptions',
			'meta'  => 'Meta tag stuff'
		  ));
		  $this->load->view('market_nav');
		  $this->load->view('reset_password', array('code' => $code));
		  $this->load->view('footer', array('js_file' => '<script type="text/javascript" src="/js/pword_reset.js"></script>'));
        }
      }
    }


    /**
     * Do the actual password reset
     *
     * @param string $key The key that gets emailed to the user
     *
     * @return void
     **/
    public function process_password_reset() {
	  $key = $this->input->post('key');
	  if (!$this->input->post('password') || !$this->input->post('confirm')) $this->_json_error("Password and confirm password cannot be blank");
	  if ($this->input->post('password') != $this->input->post('confirm')) $this->_json_error("Passwords do not match");
      if($key === NULL || !$key) {
        //redirect('/');
		$this->_json_error("This reset link is no longer valid.");
      } else {
        $user = $this->users->get_by_reset_key($key);
        if($user === FALSE) {
          $this->_json_error("Unable to locate user");
        } else {
          $this->users->set_password($user->ID, $this->input->post('password'));
          //redirect('login');
        }
      }
    }


	/**
     * Password reset confirmation
     *
     *
     * @return void
     **/
    public function confirmation() {
		  $this->load->view('header', array(
        'title' => 'Keepsayk: Account Activated',
        'desc'  => 'Meta tag descriptions',
        'meta'  => 'Meta tag stuff'
		));
		  $msg = "Your password has been successfully reset. Please login below.";
		  $this->load->view('market_nav');
          $this->load->view('confirmation',array('message' => $msg, 'success' => 'yes'));
          $this->load->view('footer', array('js_file' => '<script type="text/javascript" src="/js/confirmation.js"></script>'));
    }


    /**
     * Log the user out and destroy the session
     *
	 * @param int $user_id The user id
	 * @param string $api_key The API Key
	 *
     * @return void
     **/
    public function logout($user_id=0,$api_key=0) {
      $_SESSION = array(); // Unset all of the session variables.
      session_destroy();
	  if ($api_key && $user_id) $this->users->destroy_key($user_id, $api_key);
       $status['message'] = "Logout successful";
	   echo json_encode($status);
    }


    /**
     * Lookup the user and email them a password reset link
     *
     * @return void
     **/
    public function send_password_reset_link() {
	  if (!$this->input->post('username')) $this->_json_error("Invalid email");
      $user = $this->users->get_user($this->input->post('username'));
	  #$site_url = $config['base_url'];
      if($user === FALSE) {
        $this->_json_error("Unable to find a user with that email.");
      } else {
       
		$key = $this->users->set_new_reset_key($user->ID);
		
		//echo $this->db->last_query();
		//die();


        $this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);

        $this->email->from(EMAIL_NO_REPLY, EMAIL_NO_REPLY_SENDER);
        $this->email->to($user->email);
        $this->email->subject('Reset Your Password');
		$msg = $this->load->view('layouts/email', array('view' => 'emails/reset_password','user' => $user,'key'  => $key), TRUE);
		$this->email->message($msg);
		
		#$this->email->message();
		
		
        $this->email->send();
		
		#echo $site_url;
        #redirect('login/check_your_email');
		$status['test'] = 'test message';
		echo json_encode($status);
      }
    } 

}
