<?php

class bagtypemodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    public function bagList()
	{
            $this -> db -> select   ('id as bagid,
                                        bagtype
                                    ');
		   $this -> db -> from('bagtypemaster');
	       $this->db->order_by("id", "asc");
	  

	
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