<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class usermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function userlist($role)
	{
       $this -> db -> select('users.id, login_id, password,First_Name,Last_Name,Address,Email,Contact_Number,IS_ACTIVE');
	   $this -> db -> from('users');
	   $this -> db -> join('userole', 'users.id = userole.user_id');
	   
	   if($role != 2)
	   {
		   $whereCondition['userole.role_id'] = $role;
		   $this -> db -> where($whereCondition);
	   }
	
	   $query = $this -> db -> get();
	
	   if($query -> num_rows() > 0)
	   {
		
		 foreach($query->result() as $rows){
			$data[] = $rows;
		 }
			return $data;
	   }
	   else
	   {
		 return false;
	   }
    }
	
    public function getCompanyName($compnyid){
        
        $sql = "SELECT `company`.company_name FROM company WHERE company.id =".$compnyid;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $rows = $query->row();
            $data['company'] = $rows->company_name;
        }
        return $data;
        
    }
	
}
?>