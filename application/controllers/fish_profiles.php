<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fish_Profiles extends MY_Controller {

	/**
     * Controller Constructor
     *
     * @return void
     **/
    public function __construct() {
      parent::__construct();
	  $this->load->model('fish_profiles_model');
    }

	
	public function index($fish_name=NULL)	{
		
		$this->load->view('header', array('page_title'=>'Welcome'));
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}


	/**
     * Returns json encoded fish profile data
     *
     * @return void
     **/
	public function get_profile()	{
		
		$profile_id = $this->input->post('profile_id');

		$profile = $this->fish_profiles_model->get_profile($profile_id);

		echo json_encode($profile);
	}

	/**
     * Updates fish profile data
     *
     * @return void
     **/
	public function update_profile()	{
		
		$profile_data = $this->input->post('profile_data');

		//print_r($profile_data);
		$this->fish_profiles_model->update_profile($profile_data);
	}
}