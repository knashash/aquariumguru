<?php
  /**
   * General data Model Class
   *
   * @package
   **/

class General_data_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	/**
     * Get categories
     *
	 *
     * @return error|result set
     **/
	public function get_categories() {
		$query = $this->db->get('categories');
		return $query->result();
	}

	/**
     * Get families
     *
	 *
     * @return error|result set
     **/
	public function get_families() {
		$query = $this->db->get('family_names');
		return $query->result();
	}

	/**
     * Get eco systems
     *
	 *
     * @return error|result set
     **/
	public function get_eco_systems() {
		$query = $this->db->get('eco_systems');
		return $query->result();
	}

	/**
     * Get regions
     *
	 *
     * @return error|result set
     **/
	public function get_regions() {
		$query = $this->db->get('main_regions');
		return $query->result();
	}

	/**
     * Get countries
     *
	 *
     * @return error|result set
     **/
	public function get_countries() {
		$query = $this->db->get('country_list');
		return $query->result();
	}
}