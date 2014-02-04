<?php
  /**
   * Main Controller Class
   *
   * @package project_name
   **/
  class MY_Controller extends CI_Controller {

    /**
     * Controller Constructor
     *
     * @return void
     **/
    public function __construct() {
      parent::__construct();
	  $this->output->enable_profiler(FALSE);
      $this->load->helper(array('form', 'url'));
    }

	/** @var array The URI's that are public **/
    private $private_uris = array(
      'admin/:any',
      'users/:any',
	  'signup',
	  'nnack/:any',
	  '/'
    );

    protected function _json_error($message) {
		$this->output->set_status_header('400');
		$error['error'] = $message;
		echo $message;
		exit;
    }

	/**
     * Find out if the current URI is public
     *
     * @return boolean
     */
    private function is_uri_private() {
      // Turn the segment array into a URI string
      $uri = trim(substr($_SERVER['REQUEST_URI'], -(strlen($_SERVER['REQUEST_URI']) - 1)));

      // Is there a literal match?  If so we're done
      if(in_array($uri, $this->private_uris)) {
        return TRUE; 
      }

      // Loop through the public array looking for wild-cards
      foreach($this->private_uris as $entry) {
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
	
}
