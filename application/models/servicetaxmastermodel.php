<?php

class servicetaxmastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function servicetaxlist()
	{
       $this -> db -> select('id,tax_rate,from_date,to_date,YEAR(from_date) AS yrfrm,YEAR(to_date) AS yrto');
	   $this -> db -> from('service_tax');
           $this->db->where('is_active','Y');
	
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
		$this->db->insert('service_tax', $value);
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
      	$this->db->update('service_tax',$value); 
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
		  $this->db->delete('service_tax'); 
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