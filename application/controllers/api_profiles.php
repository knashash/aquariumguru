<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_Profiles extends MY_Controller {

	/**
     * Controller Constructor
     *
     * @return void
     **/
    public function __construct() {
      parent::__construct();
	  $this->load->model('fish_profiles_model');
    }

	
	public function get_profile()	{
		
		$profile_details = $this->fish_profiles_model->get_profile($fish_name);

		$data_array = array();
		
		foreach ($profile_details as $profile_details_row) {
			$data_array['id'] = $profile_details_row->id
		}
		
		echo json_encode($data_array);
	}
}