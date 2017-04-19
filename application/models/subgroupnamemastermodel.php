<?php

class subgroupnamemastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function subgroupnamelist()
	{
       $this -> db -> select('*');
	   $this -> db -> from('subgroup_name');
	  
	
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
	
	
	
}
?>