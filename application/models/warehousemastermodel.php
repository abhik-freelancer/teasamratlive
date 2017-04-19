<?php

class warehousemastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function warehouselist()
	{
       $this -> db -> select('*');
	   $this -> db -> from('warehouse');
             $this->db->order_by("name","asc");
	
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
	
	function add($value)
	{
		$this->db->trans_begin();
		$this->db->insert('warehouse', $value);
		$insertpatient = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		return  $insertpatient;
	}
	
	function modify($value)
	{
	 if (isset($value['id'])) {
    	$this->db->trans_begin();
		$this->db->where('id', $value['id']);
      	$this->db->update('warehouse',$value); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
   	 }
	}
	
	function delete($value)
 	 {
		$this->db->trans_begin();
		  $this->db->where('id', $value);
		  $this->db->delete('warehouse'); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		
		$errorno = $this->db->_error_number();
		if($errorno > 0)
		{
			return 0;	
		}
		else
		{
			return 1;	
		}
 	 }
	
}
?>