<?php
class accountmastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function accountlist($session_data)
	{
        
        
       $this -> db -> select('	account_master.id AS amid,
								account_master.group_master_id,
								account_master.account_name,
								account_master.is_special,
								account_opening_master.id AS aomid,
								account_opening_master.opening_balance,
								group_master.group_name');
	   $this -> db -> from('account_master');
	   $this->db->join('account_opening_master', 'account_opening_master.account_master_id = account_master.id','LEFT');
	   $this->db->join('group_master', 'account_master.group_master_id = group_master.id','LEFT');
           $this->db->where('account_master.company_id', $session_data['company']);

         //  exit;
          // $this->db->where('company_id',$session_data['company']);
          //  echo  $this->db->last_query();
	  // $this->db->where('company_id',$session_data['company']);
	  // $this->db->where('financialyear_id',$session_data['yearid']);
	
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
		
		$datamaster = array('account_name' =>$value['account_name'],'group_master_id' =>$value['group_master_id'],'is_special' =>$value['is_special'],'company_id'=>$value['company_id']);
		$this->db->insert('account_master', $datamaster); 
	 	$insertmaster = $this->db->insert_id();
		
			if($value['opening_balance'] != '')
			{
				$datadetail = array('account_master_id' =>$insertmaster,'opening_balance' =>$value['opening_balance'],'company_id' =>$value['company_id'],'financialyear_id' =>$value['financialyear_id']);
				$this->db->insert('account_opening_master', $datadetail); 
				$insertdetail = $this->db->insert_id();
			}
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		return  $insertdetail;
	}
	
	function modify($value)
	{
		
		if (isset($value['id'])) {
    	$this->db->trans_begin();
		
		$datamaster = array('account_name' =>$value['account_name'],'group_master_id' =>$value['group_master_id'],'is_special' =>$value['is_special']);
		$this->db->where('id',$value['id']);
      	$this->db->update('account_master',$datamaster); 
		
		$datadetail = array('opening_balance' =>$value['opening_balance']);
		$this->db->where('id', $value['accblnceid']);
		$this->db->update('account_opening_master', $datadetail); 
		
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

    //  $exists = $this->checkExistance($value['parentid']);
	
	  	$this->db->trans_begin();
		 
		  
		  $this->db->where('id', $value['childid']);
		  $this->db->delete('account_opening_master'); 
	 
	 	  $this->db->where('account_master_id', $value['parentid']);
		  $this->db->delete('customer'); 
		  
		   $this->db->where('account_master_id', $value['parentid']);
		  $this->db->delete('vendor'); 
		  
		  $this->db->where('id', $value['parentid']);
		  $this->db->delete('account_master'); 
		  
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
	 
	 function checkExistance($id)
	 {
		 $this -> db -> select('*');
	   	 $this -> db -> from('vendor');
		 $this -> db -> where('account_master_id', $id);
	  
		 
		 $count =  $this->db->count_all_results();	
		 return $count;
		 
	 }
	
}
?>