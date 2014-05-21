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
		
		$this->load->view('header', array('page_title'=>'Fish Profiles', 'current_nav_page' => 'fish-profiles'));
		$this->load->view('profiles_search');
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
		$data['main_profile'][0]->searched_name = urldecode($name);
		$data['main_profile'][0]->searched_name_type = "scientific";
		$this->scrub_profile_data($data);
		$this->load->view('header', array('page_title'=>'Fish Profiles - Scientific Name Profile', 'current_nav_page' => 'fish-profiles'));
		$this->load->view('view_profile', $data);
		$this->load->view('footer', array('js_file'=>'<script src=\'/js/swipebox-master/src/js/jquery.swipebox.js\'></script><script src=\'/js/view_profile.js\'></script>'));
	}

	/**
     * Gets fish profile data based off the common name and displays the view
     *
     * @return void
     **/
	public function common_name($name)	
	{
		$name = urldecode($name);
		$name = str_replace("_","-",$name);
		
		$data = $this->fish_profiles_model->get_profile_by_common_name($name);
		$this->scrub_profile_data($data);
		$data['main_profile'][0]->searched_name = $name;
		$data['main_profile'][0]->searched_name_type = "common";
		$this->load->view('header', array('page_title'=>'Fish Profiles - Common Name Profile', 'current_nav_page' => 'fish-profiles'));
		$this->load->view('view_profile', $data);
		$this->load->view('footer', array('js_file'=>'<script src=\'/js/swipebox-master/src/js/jquery.swipebox.js\'></script><script src=\'/js/view_profile.js\'></script>'));
	}

	/**
     * Get full list of scientific names and display the view
     *
     * @return void
     **/
	public function scientific_names_list()	
	{
		$data['scientific_names'] = $this->fish_profiles_model->get_scientific_names();

		$this->load->view('header', array('page_title'=>'Fish Profiles - Scientific Names List', 'current_nav_page' => 'fish-profiles'));
		$this->load->view('scientific_names_list', $data);
		$this->load->view('footer');
	}

	/**
     * Get full list of common names and display the view
     *
     * @return void
     **/
	public function common_names_list()	
	{
		$data['common_names'] = $this->fish_profiles_model->get_common_names();

		$this->load->view('header', array('page_title'=>'Fish Profiles - Common Names List', 'current_nav_page' => 'fish-profiles'));
		$this->load->view('common_names_list', $data);
		$this->load->view('footer');
	}

	/**
     * Takes in the result data set and subs out any 0s or empty strings for "--"
	 * this helps with the display of the profile data for incomplete
	 * profiles. The data set is passed in by reference.
	 *
	 * @param data | profile data set
     *
     * @return void
     **/
	private function scrub_profile_data(&$data)
	{
		// list of fields we want to set to "--" for display of incomplete profiles
		$fields_to_scrub = array();
		$fields_to_scrub[] = "system";
		$fields_to_scrub[] = "category";
		$fields_to_scrub[] = "family_name";
		$fields_to_scrub[] = "diet";
		$fields_to_scrub[] = "activity";
		$fields_to_scrub[] = "colors";
		$fields_to_scrub[] = "markings";
		$fields_to_scrub[] = "lifespan";
		$fields_to_scrub[] = "min_tank_size";
		$fields_to_scrub[] = "max_size";
		$fields_to_scrub[] = "max_size_female";
		$fields_to_scrub[] = "max_size_male";
		
		if (empty($data['region_string'])) $data['region_string'] = "--";
		if (empty($data['country_string'])) $data['country_string'] = "--";
		if (empty($data['swim_region_string'])) $data['swim_region_string'] = "--";
		if (empty($data['ph_range_string'])) $data['ph_range_string'] = "--";
		if (empty($data['dh_range_string'])) $data['dh_range_string'] = "--";
		if (empty($data['temp_range_string'])) $data['temp_range_string'] = "--";

		foreach ($data['main_profile'] as $data_array_key => $profile_data)
		{
			if (is_object($profile_data))
			{
				foreach ($profile_data as $profile_arr_key => $profile_arr_value)
				{
					if (empty($profile_arr_value))
					{
						if (in_array($profile_arr_key, $fields_to_scrub)) $profile_data->$profile_arr_key = "--";
					}
				}
			}
		}

	}
}