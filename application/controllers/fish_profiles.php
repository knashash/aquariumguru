<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fish_Profiles extends MY_Controller {

	/**
     * Controller Constructor
     *
     * @return void
     **/
    public function __construct() 
	{
      parent::__construct();
	  $this->load->model('fish_profiles_model');
    }

	
	public function index($fish_name=NULL)	
	{
		
		$this->load->view('header', array('page_title'=>'Welcome'));
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}

	/*
	public function _remap($method, $params = array())
	{
		$allowed_methods = array('get_profile','update_profile','index');
		
		if (in_array($method, $allowed_methods))
		{
			$this->$method();
		}
		else
		{
			$this->load_profile($method, $params);
		}
	}*/


	/**
     * Returns json encoded fish profile data
     *
     * @return void
     **/
	public function get_profile()	
	{
		
		$profile_id = $this->input->post('profile_id');

		$profile = $this->fish_profiles_model->get_profile($profile_id);

		echo json_encode($profile);
	}

	/**
     * Updates fish profile data
     *
     * @return void
     **/
	public function update_profile()	
	{
		$profile_data = $this->input->post('profile_data');

		//print_r($profile_data);
		$this->fish_profiles_model->update_profile($profile_data);
	}

	/**
     * Loads a fish prfile to view
     *
     * @return void
     **/
	public function load_profile($name_type, $params)	
	{
		$name = $params[0];
		$profile_data = $this->fish_profiles_model->load_profile_by_name($name_type, $name);
		
	}

	/**
     * Gets fish profile data based off the scientific name and displays the view
     *
     * @return void
     **/
	public function scientific_name($name)	
	{
		$data = $this->fish_profiles_model->get_profile_by_scientifc_name($name);

		$this->load->view('header', array('page_title'=>'Welcome'));
		$this->load->view('view_profile', $data);
		$this->load->view('footer');
	}

	/**
     * Cleans up scientifc or common fish name for data retrival
	 *
	 * @param name | scientific or common name of fish
     *
     * @return name
     **/
	private function clean_name($name)
	{
		//$name = 
	}
}