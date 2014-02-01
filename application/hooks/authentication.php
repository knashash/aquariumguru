<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


  /**
   * Authentication Hook
   *
   * @package CodeRobot
   **/
  class Authentication {


    /** @var object The CodeIgniter super global **/
    private $CI;


    /** @var array The URI's that are public **/
    private $public = array(
      //'login',
      //'users/:any',
	  //'signup',
	  //'nnack/:any',
	  //'/'
    );


    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
      $this->CI =& get_instance();
	  $this->CI->load->model('users');
    }


    /**
     * Check to see if the user is logged in. If they are not, take them to the login page.
     *
     * @return void
     **/
    public function is_authenticated() {
      if(!$this->user_information_set()) {
        if(!$this->is_uri_public()) {
          if (!$this->check_api()) {
			$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI']; // Remember where they were going
			header('Location: /');
		  }
        }
      }
    }


    /**
     * Find out if the current URI is public
     *
     * @return boolean
     */
    function is_uri_public() {
      // Turn the segment array into a URI string
      $uri = trim(substr($_SERVER['REQUEST_URI'], -(strlen($_SERVER['REQUEST_URI']) - 1)));

      // Is there a literal match?  If so we're done
      if(in_array($uri, $this->public)) {
        return TRUE; 
      }

      // Loop through the public array looking for wild-cards
      foreach($this->public as $entry) {
        // Convert wild-cards to RegEx
        $entry = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $entry));

        // Does the RegEx match?
        if(preg_match('#^' . $entry . '$#', $uri)) {
          return TRUE;
        }
      }

      // If we got this far it means we didn't encounter a
      // matching rule
      return FALSE;
    }


    /**
     * Shortcut to see if the user information is stored in the session
     *
     * @return boolean
     **/
    private function user_information_set() {
      return isset($_SESSION['username']);
    }
	
	/**
     * Check URL string for valid API Key, Hash and User
     *
     * @return boolean
     **/
    private function check_api() {
      $uri_array = explode("/",uri_string());
	  if (count($uri_array) == 4) {
		 if (API_KEY == $uri_array[3]) return true;
		 $user_id = (int)$uri_array[2];
		 $api_key = $this->CI->users->get_api_key($user_id);
		 if (!$api_key) $this->_json_error("Invalid API Call");
		 if ($api_key == $uri_array[3]) return true;
		 else {
			$this->_json_error("Invalid user or API key");
		 }
	  }
	  else return false;
    }

	private function _json_error($message) {
		$this->CI->output->set_status_header('400');
		$error['error'] = $message;
		echo $message;
		exit;
    }

  }