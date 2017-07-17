<?php

class dototransportermodel extends CI_Model{
    
    
  
    /**
     * @mehod getDoLists
     * @param type $purchaseInvoiceID
     * @return boolean
     * @description List of 'do' received
     */
 /*           
    public function getDoTransLists($isPending=''){
        
           if($isPending=='Y'){
                $whereClause = " WHERE `do_to_transporter`.`is_sent` ='Y' ORDER BY purchase_invoice_master.id DESC";
           }else{
               $whereClause=" WHERE `do_to_transporter`.`is_sent` IS NULL OR `do_to_transporter`.`is_sent` ='N' ORDER BY purchase_invoice_master.id DESC";
           }
            
              $sql="SELECT 
                    `purchase_invoice_detail`.`id` as pDtlId,
                    `purchase_invoice_master`.`id` as pMstId,
                    `do_to_transporter`.`id` as dotransportaionid,
                    `purchase_invoice_master`.`purchase_invoice_number`,
                    DATE_FORMAT(`purchase_invoice_master`.`purchase_invoice_date`,'%d-%m-%Y') AS PurchaseInvoiceDate,
                    `purchase_invoice_master`.`sale_number`,
                    `purchase_invoice_master`.`from_where`,
                    `purchase_invoice_detail`.`invoice_number`,
                    `purchase_invoice_detail`.`grade_id`,
                    `grade_master`.`grade`,
                    `purchase_invoice_detail`.`total_weight`,
                    `purchase_invoice_detail`.`do`,
                    purchase_invoice_detail.`warehouse_id`,
                    warehouse.`name` AS WarehouseName,warehouse.`area`,
                    garden_master.`garden_name`,
                    DATE_FORMAT(`purchase_invoice_detail`.`doRealisationDate`,'%d-%m-%Y') AS doRealisationDate,
                    `do_to_transporter`.`transporterId`,
                    DATE_FORMAT(`do_to_transporter`.`transportationdt`,'%d-%m-%Y') AS  transportdate,
                    IF(`do_to_transporter`.`is_sent` IS NULL OR `do_to_transporter`.`is_sent` ='N','N','Y') AS sentStatus,
                    `do_to_transporter`.`in_Stock`,
                    `transport`.`name`
                    FROM 
                    `purchase_invoice_master`
                    INNER JOIN
                    `purchase_invoice_detail` 
                    ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id` AND `purchase_invoice_master`.`from_where`<>'SB'
                    LEFT JOIN   `warehouse` ON purchase_invoice_detail.`warehouse_id` = warehouse.`id`
                    INNER JOIN  `garden_master` ON purchase_invoice_detail.`garden_id` = garden_master.`id`
                    INNER JOIN `grade_master` ON `grade_master`.`id` = `purchase_invoice_detail`.`grade_id`
                    LEFT JOIN `do_to_transporter` ON `purchase_invoice_detail`.`id` = `do_to_transporter`.`purchase_inv_dtlid`
                    LEFT JOIN `transport` 
                    ON `transport`.`id` = `do_to_transporter`.`transporterId`  
                    ".
                    $whereClause;
        
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
                    return false;
                }
        
    }*/
    
    
      public function getDoTransLists($isPending='',$saleNo,$cmpy){
        
           if($isPending=='Y'){
                $whereClause = " WHERE `do_to_transporter`.`is_sent` ='Y' AND `purchase_invoice_master`.`sale_number`='".$saleNo."' AND purchase_invoice_master.`company_id`='".$cmpy."' ORDER BY purchase_invoice_master.id DESC";
           }else{
               $whereClause=" WHERE (`do_to_transporter`.`is_sent` IS NULL OR `do_to_transporter`.`is_sent` ='N') AND `purchase_invoice_master`.`sale_number`='".$saleNo."' AND purchase_invoice_master.`company_id`='".$cmpy."' ORDER BY purchase_invoice_master.id DESC";
           }
            
              $sql="SELECT 
                    `purchase_invoice_detail`.`id` as pDtlId,
                    `purchase_invoice_master`.`id` as pMstId,
                    `do_to_transporter`.`id` as dotransportaionid,
                    `purchase_invoice_master`.`purchase_invoice_number`,
                    DATE_FORMAT(`purchase_invoice_master`.`purchase_invoice_date`,'%d-%m-%Y') AS PurchaseInvoiceDate,
                    `purchase_invoice_master`.`sale_number`,
                    `purchase_invoice_master`.`from_where`,
                    `purchase_invoice_detail`.`invoice_number`,
                    `purchase_invoice_detail`.`grade_id`,
                    `grade_master`.`grade`,
                    `purchase_invoice_detail`.`total_weight`,
                    `purchase_invoice_detail`.`do`,
                    purchase_invoice_detail.`warehouse_id`,
                    warehouse.`name` AS WarehouseName,warehouse.`area`,
                    garden_master.`garden_name`,
                    DATE_FORMAT(`purchase_invoice_detail`.`doRealisationDate`,'%d-%m-%Y') AS doRealisationDate,
                    `do_to_transporter`.`transporterId`,
                    DATE_FORMAT(`do_to_transporter`.`transportationdt`,'%d-%m-%Y') AS  transportdate,
                    IF(`do_to_transporter`.`is_sent` IS NULL OR `do_to_transporter`.`is_sent` ='N','N','Y') AS sentStatus,
                    `do_to_transporter`.`in_Stock`,
                    `transport`.`name`
                    FROM 
                    `purchase_invoice_master`
                    INNER JOIN
                    `purchase_invoice_detail` 
                    ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`
				/*	AND `purchase_invoice_master`.`from_where`<>'SB' */
					AND `purchase_invoice_master`.`from_where`<>'OP' AND `purchase_invoice_master`.`from_where`<>'STI'
                    LEFT JOIN   `warehouse` ON purchase_invoice_detail.`warehouse_id` = warehouse.`id`
                    INNER JOIN  `garden_master` ON purchase_invoice_detail.`garden_id` = garden_master.`id`
                    INNER JOIN `grade_master` ON `grade_master`.`id` = `purchase_invoice_detail`.`grade_id`
                    LEFT JOIN `do_to_transporter` ON `purchase_invoice_detail`.`id` = `do_to_transporter`.`purchase_inv_dtlid`
                    LEFT JOIN `transport` 
                    ON `transport`.`id` = `do_to_transporter`.`transporterId`  
                    ".
                    $whereClause;
        
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
                    return false;
                }
        
    }
    
    public function saleNumberList($cmpyid,$yearid){
       /*$sql="SELECT DISTINCT `purchase_invoice_master`.`sale_number` FROM `purchase_invoice_master` 
                  WHERE `purchase_invoice_master`.`sale_number`<>'' 
				   AND purchase_invoice_master.`company_id`=".$cmpyid." AND purchase_invoice_master.`year_id`=".$yearid." 
                ORDER BY CONVERT(`purchase_invoice_master`.`sale_number`,DECIMAL) ASC";01/04/2017*/ 

		$sql="SELECT DISTINCT `purchase_invoice_master`.`sale_number` FROM `purchase_invoice_master` 
                  WHERE `purchase_invoice_master`.`sale_number`<>'' 
				   AND purchase_invoice_master.`company_id`=".$cmpyid." ORDER BY CONVERT(`purchase_invoice_master`.`sale_number`,DECIMAL) ASC";
        
        $query = $this->db->query($sql);
		if($query -> num_rows() > 0)
	   	{
			foreach($query->result() as $rows){
				$data[] = $rows;
		 	}
			
			
			
                       
                        return $data;
                }
    }
    
    /**
     * @method updateDoTrans
     * @param type $doTransId
     * @param type $data
     * @return int|boolean
     */
    public function updateDoTrans($doTransId,$data){
        
         if($doTransId!=''){
             
         
            
            $this->db->where('id', $doTransId);
            $this->db->update('do_to_transporter', $data); 
            if( $this->db->affected_rows()==1)
            {
                return 1;
            }else{
                return 0;
            }
            
        }else{
            return false;
        }
    }
    
    /**
     * @method insertDoTrans
     * @param type $data
     */
   public function insertDoTrans($data){
        
        $this->db->insert('do_to_transporter', $data); 
        
        if($this->db->affected_rows() > 0)
        {
        
            return true; // to the controller
        }else{
            return false;
        }
    }
    
   
    
}
    
    