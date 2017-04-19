<?php

class locationmastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    public function loactionmasterlist()
	{
            $this -> db -> select   ('location.id as lid,
				location.location as location,
                                warehouse.id as whid,
				warehouse.name as warehousename');
	   $this -> db -> from('location');
	   $this->db->join('warehouse', 'location.warehouseid = warehouse.id','INNER');
	  

	
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

	
	public function add($value)
	{
			
			$this->db->trans_begin();
			$this->db->insert('location', $value);
			$insertid = $this->db->insert_id();
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
                                return false;
			}
			else
			{
				$this->db->trans_commit();
                                return $insertid;
			}
			
		
	}
	
	public function modify($value)
	{
	 if (isset($value['id'])) {
		 
		 
		
			$this->db->trans_begin();
			$this->db->where('id', $value['id']);
			$this->db->update('location',$value); 
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
			}
			return 0;
		
   	 }
	}
	
	public function delete($value)
 	 {
		$this->db->trans_begin();
		  $this->db->where('id', $value);
		  $this->db->delete('location'); 
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