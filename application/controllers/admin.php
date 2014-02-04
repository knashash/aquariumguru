<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	/**
     * Controller Constructor
     *
     * @return void
     **/
    public function __construct() {
      parent::__construct();
	  $this->load->model('admin_model');
	  $this->load->model('fish_profiles_model');
	  $this->load->model('general_data_model');
    }

	public function index()
	{	
		if ($this->is_authenticated())  {
			$this->show_admin();
		}
	}

	private function show_admin()
	{	
		$this->load->view('header', array('page_title'=>'Welcome'));
		$this->load->view('admin_main');
		$this->load->view('footer' , array('js_file' => '<script type="text/javascript" src="/js/admin.js"></script>'));
	}

	public function login()
	{	
		$this->load->view('header', array('page_title'=>'Admin'));
		$this->load->view('login');
		$this->load->view('footer' , array('js_file' => '<script type="text/javascript" src="/js/login.js"></script>'));
	}

	/**
     * Check to see if the user is logged in. If they are not, take them to the login page.
     *
     * @return void
     **/
    public function is_authenticated() {
      if(!$this->user_information_set()) {
			$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI']; // Remember where they were going
			header('Location: /admin/login');
      }
	  else return TRUE;
    }

	/**
     * Gets a full list of common names
     *
     * @return void
     **/
    public function get_common_names() {
	  $profile_id = $this->input->post('profile_id');
      $common_names = $this->fish_profiles_model->get_common_names($profile_id);
	  echo json_encode($common_names);
    }

	/**
     * Gets a full list of categories
     *
     * @return void
     **/
    public function get_categories() {
      $categories = $this->general_data_model->get_categories();
	  echo json_encode($categories);
    }

	/**
     * Gets a full list of families
     *
     * @return void
     **/
    public function get_families() {
      $families = $this->general_data_model->get_families();
	  echo json_encode($families);
    }

	/**
     * Gets a full list of eco systems
     *
     * @return void
     **/
    public function get_eco_systems() {
      $eco_systems = $this->general_data_model->get_eco_systems();
	  echo json_encode($eco_systems);
    }

	/**
     * Gets full list of regions
     *
     * @return void
     **/
    public function get_regions() {
      $regions = $this->general_data_model->get_regions();
	  echo json_encode($regions);
    }

	/**
     * Gets full list of countires
     *
     * @return void
     **/
    public function get_countries() {
      $countries = $this->general_data_model->get_countries();
	  echo json_encode($countries);
    }

	/**
     * Gets comments for merging
     *
     * @return void
     **/
    public function get_comments() {
      $profile_id = $this->input->post('profile_id');
	  $comments = $this->fish_profiles_model->get_comments($profile_id);
	  echo json_encode($comments);
    }

	/**
     * Gets a full list of scientific names
     *
     * @return void
     **/
    public function get_scientific_names() {
	  $profile_id = $this->input->post('profile_id');
      $scientific_names = $this->fish_profiles_model->get_scientific_names($profile_id);
	  echo json_encode($scientific_names);
    }

	/**
     * Shortcut to see if the user information is stored in the session
     *
     * @return boolean
     **/
    private function user_information_set() {
      return $this->session->userdata('username');
    }

	/**
     * Check the login, redirect the user as needed
     *
     * @return void
     **/
    public function validate_login() 
	{
	  
	  $password = $this->input->post('password');
	  $username = $this->input->post('username');
	  
      if ($password == "24knashash" && $username=="knashash") 
	  {
		$this->session->set_userdata('username', 'knashash');
		$status['message'] = "Login successful";
		echo json_encode($status);
	  }
	  else $this->_json_error('Invalid email or password');
    }

	/**
     * Edit the comments in a profile image
     *
     * @return void
     **/
	public function edit_image()
	{
		$image_id = $this->input->get('image_id');

		// get profile image data
		$image_details = $this->fish_profiles_model->get_profile_image($image_id);

		$this->load->view('header', array('page_title'=>'Edit Image'));
		$this->load->view('edit_image', array('image_name' => $image_details[0]->image_name, 'image_comments' => $image_details[0]->comments, 'image_id' => $image_id ));
		$this->load->view('footer' , array('js_file' => '<script type="text/javascript" src="/js/edit_image.js"></script>'));
		
	}

	/**
     * Edit the countries of a profile
     *
     * @return void
     **/
	public function edit_countries()
	{
		$profile_id = $this->input->get('profile_id');

		// get a list of all countires
		$countries_list = $this->general_data_model->get_countries();

		// get existing countires listed under the profile id
		$countries_profile = $this->fish_profiles_model->get_countries($profile_id);
		$countries_profile_array = array();
		
		if (!empty($countries_profile))
		{
			foreach ($countries_profile as $key => $value)
			{
				$countries_profile_array[$countries_profile[$key]->country_id] = $countries_profile[$key]->country;
			}
		}

		$this->load->view('edit_countries', array('countries_list' => $countries_list, 'countries_profile_array' => $countries_profile_array, 'profile_id' => $profile_id));
	}

	/**
     * update the countries of a profile
     *
     * @return void
     **/
	public function update_countries()
	{
		$profile_id = $this->input->post('profile_id');
		$countries_arr = $this->input->post('countries_arr');

		// update profile countries
		$this->fish_profiles_model->update_countries($profile_id, $countries_arr);
	}

	/**
     * Edit the regions of a profile
     *
     * @return void
     **/
	public function edit_regions()
	{
		$profile_id = $this->input->get('profile_id');

		// get a list of all regions
		$regions_list = $this->general_data_model->get_regions();

		// get existing regions listed under the profile id
		$regions_profile = $this->fish_profiles_model->get_regions($profile_id);
		$regions_profile_array = array();
		
		if (!empty($regions_profile))
		{
			foreach ($regions_profile as $key => $value)
			{
				$regions_profile_array[$regions_profile[$key]->region_id] = $regions_profile[$key]->region;
			}
		}

		$this->load->view('edit_regions', array('regions_list' => $regions_list, 'regions_profile_array' => $regions_profile_array, 'profile_id' => $profile_id));
	}

	/**
     * update the regions of a profile
     *
     * @return void
     **/
	public function update_regions()
	{
		$profile_id = $this->input->post('profile_id');
		$regions_arr = $this->input->post('regions_arr');

		// update profile countries
		$this->fish_profiles_model->update_regions($profile_id, $regions_arr);
	}

	/**
     * Delete an image profile (actually marks it in active)
     *
     * @return void
     **/
	public function delete_image()
	{
		$image_id = $this->input->post('image_id');

		// delete the profile image
		$this->fish_profiles_model->delete_profile_image($image_id);		
	}

	/**
     * Update the comments in a profile image
     *
     * @return void
     **/
	public function update_image()
	{
		$image_id = $this->input->post('image_id');
		$image_comments = $this->input->post('image_comments');

		// update profile image data
		$image_details = $this->fish_profiles_model->update_profile_image($image_id, $image_comments);		
	}

	/**
     * Load upload form
     *
     * @return void
     **/
	public function upload()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	/**
     * Upload file from upload form with specified config options
     *
     * @return void
     **/
	public function do_upload()
	{
		$profile_id = $this->input->post('profile_id');
		$image_comments = $this->input->post('image_comments');

		// get the scientific name to rename the image. file system automatically increments after the name
		$scientific_names = $this->fish_profiles_model->get_scientific_names($profile_id);
		$file_name = strtolower($scientific_names[0]->scientific_name);
		
		// set image config options
		$config['file_name'] = $file_name;
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '500';
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';

		$this->load->library('upload', $config);

		// display errors if any or success message
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			// add the extension to the renamed file for later retrieval
			$file_name = $file_name.$data['upload_data']['file_ext'];

			// create thumnails
			$this->create_thumbnails($data['upload_data']['raw_name'], $data['upload_data']['file_ext']);

			// on upload success, insert image into db
			$this->fish_profiles_model->add_profile_image($profile_id, $data['upload_data']['file_name'], $image_comments);

			$this->load->view('upload_success', $data);
		}
	}

	/**
     * Creates thumbnails (small and medium) of a given file
	 *
	 * @param string | $filename_raw | the filename without the extenstion
	 * @param string | $file_ext | the filename ext
     *
     * @return void
     **/
	private function create_thumbnails($filename_raw, $file_ext)
	{
		// set small, medium and original filenames
		$filename_small = $filename_raw."_small".$file_ext;
		$filename_medium = $filename_raw."_medium".$file_ext;
		$filename = $filename_raw.$file_ext;
		
		$this->load->library('image_lib'); 
		
		$config['image_library'] = 'gd2';
		$config['source_image']	= FCPATH.'uploads/'.$filename;
		$config['new_image'] = $filename_small;
		$config['maintain_ratio'] = TRUE;
		$config['master_dim'] = 'width';
		$config['width'] = 100;
		$config['height'] = 100;

		$this->image_lib->initialize($config);

		$this->image_lib->resize();

		if ( ! $this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();
		}

		$this->image_lib->clear();

		$config['new_image'] = $filename_medium;
		$config['width'] = 200;
		$config['height'] = 200;

		$this->image_lib->initialize($config);
		
		$this->image_lib->resize();

		if ( ! $this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();
		}
	}

	/**
     * Creates thumbnails (small and medium) of a given file
	 *
	 * @param string | $filename_raw | the filename without the extenstion
	 * @param string | $file_ext | the filename ext
     *
     * @return void
     **/
	public function regenerate_thumbnails()
	{
		// on upload success, insert image into db
		$image_list = $this->admin_model->get_all_profile_images();

		foreach ($image_list as $key => $value)
		{
			$filename_array = explode(".",$image_list[$key]->image_name);
			$filename_raw = $filename_array[0];
			$file_ext = ".".$filename_array[1];

			$this->create_thumbnails($filename_raw, $file_ext);
		}
	}
}