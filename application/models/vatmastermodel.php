<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class vatmastermodel extends CI_Model{
 
    /**
     * returns a list of articles
     * @return array 
     */
    function vatlist()
	{
       $this -> db -> select('id,vat_rate,from_date,to_date,is_active,YEAR(from_date) AS yrfrm,YEAR(to_date) AS yrto');
	   $this -> db -> from('vat');
           $this->db->where('is_active','Y');  //added by mithilesh on 2nd July, 2016
	
	   $query = $this -> db -> get();
	
	   if($query -> num_rows() > 0)
	   {
		 foreach($query->result() as $rows)
		 {
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
		$this->db->insert('vat', $value);
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
      	$this->db->update('vat',$value); 
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
		  $this->db->delete('vat'); 
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
?>