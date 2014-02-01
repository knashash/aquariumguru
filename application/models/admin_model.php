<?php
  /**
   * Fish profiles Model Class
   *
   * @package
   **/

class Admin_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


	/**
     * Get profile
     *
     * @param string $name The name of the fish
	 *
     * @return error|result set
     **/
	public function get_profile($name) {
	$query = $this->db->get_where('Categories', array('id' => $name));
	if($query->num_rows()) {
        return $query->result();
      }   else {
        return FALSE;
      }
	}
}