<?php
  /**
   * Fish profiles Model Class
   *
   * @package
   **/

class Fish_profiles_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	/**
     * Get profile
     *
     * @param int profile_id The Fish ID
	 *
     * @return error|result set
     **/
	public function get_profile($profile_id) 
	{
		$this->db->select('*');
		$this->db->from('profiles_fish');
		$this->db->join('categories', 'profiles_fish.category_id = categories.id', 'inner');
		$this->db->join('family_names', 'profiles_fish.family_id = family_names.id', 'inner');
		$this->db->join('eco_systems', 'profiles_fish.eco_system_id = eco_systems.id', 'inner');
		$this->db->where('profiles_fish.id', $profile_id);
		$this->db->where('deleted', 0);
		$query = $this->db->get();

		if($query->num_rows()) 
		{
			$main_profile['main_profile'] = $query->result();
			$main_profile['countries'] = $this->get_countries($profile_id);
			$main_profile['common_names'] = $this->get_common_names($profile_id);
			$main_profile['regions'] = $this->get_regions($profile_id);
			$main_profile['profile_images'] = $this->get_profile_images($profile_id);

			// set the region string for easy display in view
			$region_string = "";
			foreach ($main_profile['regions'] as $key => $region_array)
			{
				if (empty($region_string)) $region_string = $region_array->region;
				else $region_string .= ", ".$region_array->region;
			}
			$main_profile['region_string'] = $region_string;

			// set the country string for easy display in view
			$country_string = "";
			foreach ($main_profile['countries'] as $key => $country_array)
			{
				if (empty($country_string)) $country_string = $country_array->country;
				else $country_string .= ", ".$country_array->country;
			}
			$main_profile['country_string'] = $country_string;
			
			// determine algae eating ability
			$algae_eating_rank = $main_profile['main_profile'][0]->algae_eating_rank;
			if ($algae_eating_rank >= 1 && $algae_eating_rank < 5) $algae_eater = "yes (ok)";
			else if ($algae_eating_rank >=4 && $algae_eating_rank < 8) $algae_eater = "yes (good)";
			else if ($algae_eating_rank > 7) $algae_eater = "yes (excellent)";
			else $algae_eater = "no";
			$main_profile['algae_eater'] = $algae_eater;

			// set schooler value
			$schooler = "no";
			if ($main_profile['main_profile'][0]->schooler) $schooler = "yes";
			$main_profile['schooler'] = $schooler;

			// set the swim region string
			$swim_region_string = "";
			if ($main_profile['main_profile'][0]->swim_region_bottom) $swim_region_string="bottom";
			if ($main_profile['main_profile'][0]->swim_region_middle)
			{
				if (empty($swim_region_string)) $swim_region_string .= ", middle";
				else $swim_region_string = "middle";
			}
			if ($main_profile['main_profile'][0]->swim_region_top)
			{
				if (empty($swim_region_string)) $swim_region_string .= ", top";
				else $swim_region_string = "top";
			}
			$main_profile['swim_region_string'] = $swim_region_string;


			// set all null or 0 values to "--" - right now this loops through the entire object. I think there is prob a smarter way to do this
			foreach ($main_profile as $data_array_key => $data)
			{
				if (is_array($data))
				{
					foreach ($data as $key => $value)
					{
						foreach ($value as $key2 => $value2)
						{
							if (!$value2)
							{
								$value->$key2 = "--";
							}
						}
					}
					$main_profile[$data_array_key] = $data;
				}
				else
				{
					if (!$data)
					{
						$main_profile[$data_array_key] = "--";
					}
				}
			}

			return $main_profile;
		}   
		else 
		{
			return $this->db->_error_message();
		}
	}

	/**
     * Get a profile by the scientifc name
     *
	 * @param string | name | The scientific name
	 *
     * @return error|result set
     **/
	public function get_profile_by_scientifc_name($name) 
	{		
		$name = str_replace("_", " ", $name);
		
		$this->db->select('id', FALSE);
		$this->db->from('profiles_fish');
		$this->db->where('scientific_name', $name);
		$this->db->where('deleted', 0);
		$query = $this->db->get();

		if($query->num_rows()) 
		{
			$row = $query->row(); 
			$profile_data = $this->get_profile($row->id);

			return $profile_data;
		}   
		else 
		{
			return $this->db->_error_message();
		}
	}


	/**
     * Get common name(s)
	 *
	 * @param int profile_id The Fish ID
	 *
     * @return error|result set
     **/
	public function get_common_names($profile_id=0) {
		if ($profile_id) $this->db->where('profile_id', $profile_id);
		$this->db->where('deleted', 0);
		$this->db->order_by("name", "asc");
		$query = $this->db->get('common_names');
		if($query->num_rows()) {
			return $query->result();
		  }   else {
			return $this->db->_error_message();
		  }
	}

	/**
     * Get profile images
	 *
	 * @param int profile_id The Fish ID
	 *
     * @return error|result set
     **/
	public function get_profile_images($profile_id) {
		$this->db->where('profile_id', $profile_id);
		$this->db->where('deleted', 0);
		$this->db->order_by("image_name", "asc");
		$query = $this->db->get('profile_images');
		if($query->num_rows()) {
			return $query->result();
		  }   else {
			return $this->db->_error_message();
		  }
	}

	/**
     * Get scientific name(s) by profile id. If no profile
	 * id is provided then return all scientific names in the db
	 *
	 * @param int profile_id The Fish ID
	 *
     * @return error|result set
     **/
	public function get_scientific_names($profile_id=0) {
		if ($profile_id) $this->db->where('id', $profile_id);
		$this->db->where('deleted', 0);
		$this->db->order_by("scientific_name", "asc");
		$this->db->select('id, scientific_name');
		$query = $this->db->get('profiles_fish');
		if($query->num_rows()) {
			return $query->result();
		  }   else {
			return FALSE;
		  }
	}

	/**
     * Get countries
	 *
     * @return error|result set
     **/
	public function get_countries($profile_id) {
		$this->db->select('country, country_id');
		$this->db->from('country_list');
		$this->db->join('profile_countries', 'profile_countries.country_id = country_list.id', 'inner');
		$this->db->where('profile_countries.deleted', 0); 
		$this->db->where('profile_countries.profile_id', $profile_id); 
		$query = $this->db->get();
		if($query->num_rows()) {
			return $query->result();
		  }   else {
			return FALSE;
		  }
	}

	/**
     * Update countries
	 *
	 * @param int | profile_id | the profile id
	 * @param array | countries_arr | an array of selected countries
	 *
     * @return error|result set
     **/
	public function update_countries($profile_id, $countries_arr) {

			// delete all related country data first
			$this->db->where('profile_id', $profile_id);
			$this->db->update('profile_countries', array('deleted' => 1));
			
			// loop through countries array and insert them
			foreach ($countries_arr as $key => $value)
			{	
				$this->db->insert('profile_countries', array('profile_id' => $profile_id, 'country_id' => $value));
			}
	}

	/**
     * Update regions
	 *
	 * @param int | profile_id | the profile id
	 * @param array | regions_arr | an array of selected regions
	 *
     * @return error|result set
     **/
	public function update_regions($profile_id, $regions_arr) {

			// delete all related country data first
			$this->db->where('profile_id', $profile_id);
			$this->db->update('profile_regions', array('deleted' => 1));
			
			// loop through countries array and insert them
			foreach ($regions_arr as $key => $value)
			{	
				$this->db->insert('profile_regions', array('profile_id' => $profile_id, 'region_id' => $value));
			}
	}

	/**
     * Get regions
	 *
     * @return error|result set
     **/
	public function get_regions($profile_id) {
		
		$this->db->select('region, region_id');
		$this->db->from('main_regions');
		$this->db->join('profile_regions', 'profile_regions.region_id = main_regions.id', 'inner');
		$this->db->where('profile_regions.profile_id', $profile_id);
		$this->db->where('profile_regions.deleted', 0);
		$query = $this->db->get();
		if($query->num_rows()) {
			return $query->result();
		  }   else {
			return FALSE;
		  }
	}


	/**
     * Get comments
	 *
     * @return error|result set
     **/
	public function get_comments($profile_id) {
		$this->db->select('main_fish.diet_comments, main_fish.activity, main_fish.care_comments, main_fish.colors, main_fish.comments, main_fish.breeding_comments, main_fish.tempermant_comments, main_fish.origin_comments, main_fish.sexing, main_fish.mouth, main_fish.tail, main_fish.markings, main_fish.eco_system_comments, MongaBayMainFish.Description, MongaBayMainFish.Size, MongaBayMainFish.Habitat, MongaBayMainFish.Tank, MongaBayMainFish.SwimRegion, MongaBayMainFish.SocialBehavior, MongaBayMainFish.Food, MongaBayMainFish.Sexing, MongaBayMainFish.BreedingComments, MongaBayMainFish.OtherComments, MongaBayMainFish.OtherComments2');
		$this->db->from('main_fish');
		$this->db->join('MongaBayMainFish', 'main_fish.id = MongaBayMainFish.ID', 'left');
		$this->db->where('main_fish.id', $profile_id);
		$query = $this->db->get();
		if($query->num_rows()) {
			return $query->result();
		  }   else {
			return $this->db->_error_message();
		  }
	}

	/**
     * Updates a fish profile
	 *
	 * @param array profile_data The profile data of the fish
	 *
     * @return error|result set
     **/
	public function update_profile($profile_data) {
		
		$id = $profile_data[0]['value'];
		
		$update_data = array();

		foreach ($profile_data as $key => $value)
		{
			if ($value['name'] == 'category')
			{
				$update_data['category_id'] = $value['value'];
			}
			else if ($value['name'] == 'family')
			{
				$update_data['family_id'] = $value['value'];
			}
			else if ($value['name'] == 'eco_system')
			{
				$update_data['eco_system_id'] = $value['value'];
			}
			else
			{
				if ($value['value'] == 'on') $value['value'] = 1;
				else if ($value['value'] == 'off') $value['value'] = 0;
				$update_data[$value['name']] = $value['value'];
			}
		}

		if (!isset($update_data['swim_region_bottom']))
		{
			$update_data['swim_region_bottom'] = 0;
		}

		if (!isset($update_data['swim_region_middle']))
		{
			$update_data['swim_region_middle'] = 0;
		}

		if (!isset($update_data['swim_region_top']))
		{
			$update_data['swim_region_top'] = 0;
		}

		$this->db->where('id', $id);
		$this->db->update('profiles_fish', $update_data);
	}

	/**
     * Add profile image
	 *
	 * @param int | profile_id | fish profile id
	 * @param string | image_name | name of image being uploaded to profile
	 * @param string | image_comments | image comments
	 *
     * @return error|result set
     **/
	public function add_profile_image($profile_id, $image_name, $image_comments) {

		$data = array(
		   'profile_id' => $profile_id,
		   'image_name' => $image_name,
			'comments' => $image_comments

		);
		
		$this->db->insert('profile_images', $data); 
	}

	/**
     * Update profile image
	 *
	 * @param int | image_id | the profile image id
	 * @param string | image_comment | image comment
	 *
     * @return error|result set
     **/
	public function update_profile_image($image_id, $image_comments) {

			$update_data = array(
				'comments' => $image_comments
			);

			$this->db->where('id', $image_id);
			$this->db->update('profile_images', $update_data);
	}

	/**
     * Delete profile image (set active to 0)
	 *
	 * @param int | image_id | the profile image id
	 *
     * @return error|result set
     **/
	public function delete_profile_image($image_id) {

			$update_data = array(
				'deleted' => 1
			);

			$this->db->where('id', $image_id);
			$this->db->update('profile_images', $update_data);
	}

	/**
     * get profile image details
	 *
	 * @param int | image_id | profile image id
	 *
     * @return error|result set
     **/
	public function get_profile_image($image_id) {

		$this->db->where('id', $image_id);
		$this->db->where('deleted', 0);
		$query = $this->db->get('profile_images');
		if($query->num_rows()) {
			return $query->result();
		  }   else {
			return $this->db->_error_message();
		  }
	}
}