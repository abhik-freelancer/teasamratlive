<?php

class salertobuyermodel extends CI_Model{
	
	function saveInvoicemaster($value)
	{
		$this->db->trans_begin();
		
		$this->db->insert('saler_to_buyer_master', $value); 
		$insertdetail = $this->db->insert_id();
		
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
	
	function saveInvoicedetail($value)
	{
		$this->db->trans_begin();
		
		$this->db->insert('saler_to_buyer_details', $value); 
		$insertdetail = $this->db->insert_id();
		
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
	
	function updateInvoicedetail($value,$invoiceid)
	{
		
		$this->db->where('id',$invoiceid);
      	$this->db->update('saler_to_buyer_details',$value); 
		
	}
	
	function saveItemamster($value)
	{
		$this->db->trans_begin();
		
		$this->db->insert('item_master', $value); 
		$insertdetail = $this->db->insert_id();
		
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
	
	 function delsample($value)
	 {
		  $this->db->where('saler_to_buyer_detail_id', $value);
		  $this->db->delete('saler_to_buyer_sample');
	}
	 
	 
	function saveStockdetail($value)
	{
		$this->db->trans_begin();
		
		$this->db->insert('stock', $value); 
		$insertdetail = $this->db->insert_id();
		
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
	
	function insertVoucher($valuevoucher)
	{
		$this->db->trans_begin();
		
		$this->db->insert('voucher_master', $valuevoucher); 
		$insertdetail = $this->db->insert_id();
		
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
	
	function insertVoucherDetail($value)
	{
		$this->db->trans_begin();
		
		$this->db->insert('voucher_detail', $value); 
		$insertdetail = $this->db->insert_id();
		
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
	
	function insertVendorBill($value)
	{
		$this->db->trans_begin();
		
		$this->db->insert('vendor_bill_master', $value); 
		$insertdetail = $this->db->insert_id();
		
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
	
	function getVendorAccount($vendor_id)
	{
		$sql = " SELECT `account_master`.`id` FROM `account_master` 
				 INNER JOIN vendor ON `account_master`.`account_name` = `vendor`.`vendor_name` 
				  WHERE `vendor`.`id` = ".$vendor_id;
		$query = $this->db->query($sql);
		return ($query->result());
		
	}
	
	function lastvoucherid()
	{
		$sql = "SELECT YEAR(`voucher_date`) as year, `id` FROM `voucher_master` ORDER BY id DESC LIMIT 0,1";
		$query = $this->db->query($sql);
		return ($query->result());

	}
	
	function getserialnumber($comapny,$year)
	{
		$sql = "SELECT `serial_number` FROM `voucher_master` WHERE `transaction_type`= 'PR' AND `company_id`= ".$comapny." AND `year_id`=".$year." ORDER BY id DESC LIMIT 0,1";	
		$query = $this->db->query($sql);
		return ($query->result());
	}
	function saveInvoicesample($value)
	{
		//ssprint_r($value);
		//$this->db->trans_begin();
		
		$this->db->insert('saler_to_buyer_sample', $value); 
		$insertdetail = $this->db->insert_id();
		
		/*if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}*/
		return  $insertdetail;
	}
	
	function getCurrentservicetax($startYear,$endYear)
	{
		$sql = "SELECT id, tax_rate FROM service_tax WHERE from_date BETWEEN '".$startYear."' AND '".$endYear."'";
		$query = $this->db->query($sql);
		return ($query->result());
	}
	
	function getCurrentvatrate($startYear,$endYear)
	{
		$sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '".$startYear."' AND '".$endYear."'";
		$query = $this->db->query($sql);
		
		if($query -> num_rows() > 0)
	   	{
			foreach($query->result() as $rows){
				$data[] = $rows;
		 	}
			
			return $data;
	   	}
		//return ($query->result());
	}
	
	function teagrouplist()
	{
		
		$sql = "SELECT `id`,`group_code`,`group_description` FROM teagroup_master";
		$query = $this->db->query($sql);
		
		if($query -> num_rows() > 0)
	   	{
			foreach($query->result() as $rows){
				$data[] = $rows;
		 	}
			
			return $data;
	   	}
	}
	
	function getCurrentcstrate($startYear,$endYear)
	{
		$sql = "SELECT id, cst_rate FROM cst WHERE from_date BETWEEN '".$startYear."' AND '".$endYear."'";
		$query = $this->db->query($sql);
		
		if($query -> num_rows() > 0)
	   	{
			foreach($query->result() as $rows){
				$data[] = $rows;
		 	}
			
			return $data;
	   	}
		//return ($query->result());
	}
	
	function getVendorlist($session)
	{
		$sql = "SELECT `id`,`vendor_name`,IF (id = ".$session.", 'Y', 'N') selected	FROM `vendor`";
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0)
	   	{
			foreach($query->result() as $rows){
				$data[] = $rows;
		 	}
			
			return $data;
	   	}
		
	}
	
	function getSellertobuyerlistingdata($session)
	{
		  $sql= " SELECT `saler_to_buyer_master`.* ,
					`vendor`.`vendor_name` 
					FROM `saler_to_buyer_master` 
					INNER JOIN vendor ON `saler_to_buyer_master`.`vendor_id` = `vendor`.`id` 
					WHERE (salertobuyer_invoice_date BETWEEN '".date("Y-m-d", strtotime($session['startdate']))."' AND '".date("Y-m-d", strtotime($session['enddate']))."') 
					AND `vendor_id` = ".$session['vendor']." 
					AND `saler_to_buyer_master`.`year_id` = ".$session['pryear']." 
					AND `saler_to_buyer_master`.`company_id` = ".$session['prcom'];
					
		
		$query = $this->db->query($sql);
		if($query -> num_rows() > 0)
	   	{
			foreach($query->result() as $rows){
				$data[] = $rows;
		 	}
			
			
			return $data;
	   	}
		
		
	}
	
	function getlistingdetaildata($id)
	{
		 $sql= "SELECT 
			`saler_to_buyer_details`.*,
			`garden_master`.`garden_name`,
			`grade_master`.`grade`,
			 GROUP_CONCAT(`saler_to_buyer_sample`.`id`) AS sampleid,
			 GROUP_CONCAT(`saler_to_buyer_sample`.`sample_number`) AS samplenumber,
			 GROUP_CONCAT(`saler_to_buyer_sample`.`sample_net`) AS samplenet
			 FROM 
			`saler_to_buyer_details` 
			LEFT JOIN `saler_to_buyer_sample` ON `saler_to_buyer_details`.`id` = `saler_to_buyer_sample`.`saler_to_buyer_detail_id` 
			LEFT JOIN `garden_master` ON `saler_to_buyer_details`.`garden_id` = `garden_master`.`id` 
			LEFT JOIN `grade_master` ON `saler_to_buyer_details`.`grade_id` = `grade_master`.`id` 
			WHERE `saler_to_buyer_details`.`saler_to_buyer_master_id` = ".$id." 
			GROUP BY `saler_to_buyer_details`.`id` ";
		$query = $this->db->query($sql);
		
		if($query -> num_rows() > 0)
	   	{
			foreach($query->result() as $rows){
				$data[] = $rows;
		 	}
			
			return $data;
	   	}
		else
		{
				return "no record found";
		}
				
				
		
	}
	
	function editdata($id)
	{
		
		$sql="  SELECT 
				`saler_to_buyer_master`.`id` AS masterid ,
				`saler_to_buyer_master`.`salertobuyer_invoice_number`,
				`saler_to_buyer_master`.`salertobuyer_invoice_date`,
				`saler_to_buyer_master`.`vendor_id`,
				`saler_to_buyer_master`.`sale_number`,
				`saler_to_buyer_master`.`sale_date`,
				`saler_to_buyer_master`.`promt_date`,
				`saler_to_buyer_master`.`tea_value`,
				`saler_to_buyer_master`.`brokerage` as tbrokerage,
				`saler_to_buyer_master`.`service_tax` as tservice_tax,
				`saler_to_buyer_master`.`total_cst`,
				`saler_to_buyer_master`.`total_vat`,
				`saler_to_buyer_master`.`chestage_allowance`,
				`saler_to_buyer_master`.`stamp` as masterstamp,
				`saler_to_buyer_master`.`total`,
				`saler_to_buyer_master`.`voucher_master_id`,
				 saler_to_buyer_details.*,
				 `saler_to_buyer_details`.*,
				`garden_master`.`garden_name`,
				`grade_master`.`grade`,
				`teagroup_master`.`id` as teagroupid,
				`teagroup_master`.`group_code` as teagroupcode,
				 GROUP_CONCAT(`saler_to_buyer_sample`.`id`) AS sampleid,
				 GROUP_CONCAT(`saler_to_buyer_sample`.`sample_number`) AS samplenumber,
				 GROUP_CONCAT(`saler_to_buyer_sample`.`sample_net`) AS samplenet
				 FROM `saler_to_buyer_master` 
				 LEFT JOIN `saler_to_buyer_details` ON `saler_to_buyer_master`.id = `saler_to_buyer_details`.`saler_to_buyer_master_id` 
				 LEFT JOIN `saler_to_buyer_sample` ON `saler_to_buyer_details`.id = `saler_to_buyer_sample`.`saler_to_buyer_detail_id` 
				 LEFT JOIN `garden_master` ON `saler_to_buyer_details`.`garden_id` = `garden_master`.`id` 
				 LEFT JOIN `grade_master` ON `saler_to_buyer_details`.`grade_id` = `grade_master`.`id` 
				 LEFT JOIN `teagroup_master` ON `saler_to_buyer_details`.`teagroup_master_id` = `teagroup_master`.`id`
				 WHERE `saler_to_buyer_master`.id = ".$id." 
				 GROUP BY saler_to_buyer_details.id ";
			
			$query = $this->db->query($sql);
		
			if($query -> num_rows() > 0)
			{
				foreach($query->result() as $rows)
				{
					//print_r($rows);
				
					$data[] = $rows;
				}
				
				
				return $data;
			}
			else
			{
				return "no record found";
			}
		
	}
	
	function updateVoucherid($voucherid,$invoiceid)
	{
		
		$value=array('voucher_master_id'=>$voucherid);
		$this->db->where('id',$invoiceid);
      	$this->db->update('saler_to_buyer_master',$value); 
		
	}
	
	function updatedateVoucherMaster($voucherdate,$voucherid)
	{
		$value=array('voucher_date'=>$voucherdate);
		$this->db->where('id',$voucherid);
      	$this->db->update('voucher_master',$value); 
	}
	function updatedateBillMaster($id,$rate)
	{
		/*$value=array('bill_amount'=>$rate);
		$this->db->where('id',$id);
      	$this->db->update('party_bill_master',$value);*/
		$sql = "UPDATE  `vendor_bill_master` SET `bill_amount` = ".$rate.", `due_amount` = ".$rate." WHERE `voucher_id`= ".$id;	
		$query = $this->db->query($sql);
	}
	function updateInvoicemaster($value)
	{
		
		if (isset($value['id'])) {
    	$this->db->trans_begin();
		
		
		$this->db->where('id',$value['id']);
      	$this->db->update('saler_to_buyer_master',$value); 
		
			
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
	
	function deleteInvoicemaster($value)
 	 {
		//  $this->db->where('saler_to_buyer_master_id', $value);
		//  $this->db->delete('saler_to_buyer_details'); 
		  
		  $this->db->where('bill_id', $value);
		  $this->db->where('from_where', "SB");
		  $this->db->delete('item_master'); 
		  
		   $this->db->where('received_master_id', $value);
		  $this->db->where('from_where', "SB");
		  $this->db->delete('stock'); 
	  
 	 }
	 
	 function deleteInvoicedetail($value,$invoice)
 	 {
		 $this->db->where('id', $value);
		 $this->db->delete('saler_to_buyer_details'); 
		 
		
		 $sql = "DELETE `item_master` FROM `item_master`INNER JOIN saler_to_buyer_details ON bill_id = saler_to_buyer_master_id WHERE saler_to_buyer_details.id = ".$value." AND 			item_master.`invoice_number` = ".$invoice." AND from_where = 'SB'";	
		 $query = $this->db->query($sql);
		
		
 	 }
	 
	 function deleteVoucherdetail($value)
 	 {
				  //$this->db->where('voucher_master_id', $value);
		  //$this->db->delete('voucher_detail'); 
		  $sql = "DELETE FROM `voucher_detail` WHERE `voucher_master_id`= ".$value;	
		  $query = $this->db->query($sql);
	  
 	 }
	 
	 function deleteRecord($parentId)
	 {
		
		
		$this -> db -> select('	voucher_master_id');
	    $this -> db -> from('saler_to_buyer_master');
		$this->db->where('id', $parentId);
	    $query1 = $this -> db -> get();
		$voucherId = $query1->result()[0]->voucher_master_id;
		
		
		$this->db->where('bill_id', $parentId);
		$this->db->where('from_where', "SB");
		$query_result = $this->db->delete('vendor_bill_master');
		
		$this->db->where('received_master_id', $parentId);
		$this->db->where('from_where', "SB");
		$query_result = $this->db->delete('stock');
		
		$sql2 = 'DELETE `voucher_detail`,`voucher_master` 
				FROM `voucher_master` 
				INNER JOIN `voucher_detail` ON `voucher_master`.`id` = `voucher_detail`.`voucher_master_id` 
				WHERE `voucher_master`.`id` = '.$voucherId;
		$query3 = $this->db->query($sql2);
		
		$sql1 = 'DELETE `saler_to_buyer_sample`,`saler_to_buyer_details`,`item_master` 
				FROM `saler_to_buyer_master` 
				LEFT JOIN `saler_to_buyer_details` ON `saler_to_buyer_master`.id = `saler_to_buyer_details`.`saler_to_buyer_master_id` 
				LEFT JOIN `saler_to_buyer_sample` ON `saler_to_buyer_details`.`id` = `saler_to_buyer_sample`.`saler_to_buyer_detail_id` 
				LEFT JOIN `item_master` ON `saler_to_buyer_details`.id = `item_master`.`bill_id` 
				WHERE `saler_to_buyer_master`.`id`= '.$parentId.' 
				OR `item_master`.`from_where` = "SB" ';
		$query2 = $this->db->query($sql1);
		
		$this->db->where('id', $parentId);
		$query_result2 = $this->db->delete('saler_to_buyer_master');
		
		//echo $errorno = $this->db->_error_message();
		
		 
	 }
}