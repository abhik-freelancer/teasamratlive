<?php

class auctionareamodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    public function aucareaList()
	{
            $this -> db -> select   ('id as aucAreaid,
                                        auctionarea
                                    ');
	   $this -> db -> from('auctionareamaster');
           $this->db->order_by("id","desc");
	   
	  

	
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
			$this->db->insert('auctionareamaster', $value);
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
			$this->db->update('auctionareamaster',$value); 
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
		  $this->db->delete('auctionareamaster'); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
                        return 0;
		}
		else
		{
			$this->db->trans_commit();
                        return 1;
		}
		
		
 	 }
	
}
?>