<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class loginmodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function login($username, $password){
	   
	  
	   $this -> db -> select('users.id, login_id, password,First_Name,Last_Name,IS_ACTIVE,userole.role_id');
	   $this -> db -> from('users');
	   $this -> db -> join('userole', 'users.id = userole.user_id');
	    $this -> db -> where('users.login_id', $username);
	   $this -> db -> where('password', MD5($password));
	   $this -> db -> limit(1);
	  
	 
	   $query = $this -> db -> get();
	 
	   if($query -> num_rows() == 1)
	   {
		
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
    }
}
?>