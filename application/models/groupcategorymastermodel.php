<?php

class groupcategorymastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function groupcategorylist()
	{
       $this -> db -> select('group_category.id, group_name.id as gid, group_name.name as gname, subgroup_name.id as sgid, subgroup_name.name as sgname');
	   $this -> db -> from('group_category');
	   $this->db->join('group_name', 'group_category.group_name_id = group_name.id','INNER');
	   $this->db->join('subgroup_name', 'group_category.sub_group_name_id = subgroup_name.id','INNER');
	
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
	
	function checkExistance($value)
	{
		
		 $this -> db -> select('*');
	   	 $this -> db -> from('group_category');
		 $this -> db -> where('group_name_id', $value['group_name_id']);
	   	 $this -> db -> where('sub_group_name_id', $value['sub_group_name_id']);
		 
		 $count =  $this->db->count_all_results();	
		 return $count;
	}
	
	function add($value)
	{
		$count = $this->checkExistance($value); 
		if($count == 0)
		{
			$this->db->trans_begin();
			$this->db->insert('group_category', $value);
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
		else
		{
			return 'err';
		}
	}
	
	function modify($value)
	{
	 if (isset($value['id'])) {
		 
		 
		$count = $this->checkExistance($value); 
    	if($count == 0)
		{
			$this->db->trans_begin();
			$this->db->where('id', $value['id']);
			$this->db->update('group_category',$value); 
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
		else
		{
			return 'err';
		}
   	 }
	}
	
	function delete($value)
 	 {
		$this->db->trans_begin();
		  $this->db->where('id', $value);
		  $this->db->delete('group_category'); 
		  
		
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