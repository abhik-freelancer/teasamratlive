<?php

class doreceivedmodel extends CI_Model{
	
 /**
     * @mehod getDoLists
     * @param type $purchaseInvoiceID
     * @return boolean
     * @description List of 'do' received
     */
            
    public function getDoTransporter($transporterId=''){
        
        
            
              $sql="SELECT 
                        `purchase_invoice_detail`.`id` AS purchaseDTLsId,
                        `do_to_transporter`.id AS doTransIds,
                        `do_to_transporter`.do,
                        `purchase_invoice_detail`.`invoice_number`,
                        `purchase_invoice_detail`.`grade_id`,
                        `grade_master`.`grade`,
                        `purchase_invoice_detail`.`total_weight`,
                        `do_to_transporter`.`chalanNumber`,
                         DATE_FORMAT(`do_to_transporter`.`chalanDate`, '%d-%m-%Y') AS chalanDate,
                        `do_to_transporter`.`in_Stock`,
                        do_to_transporter.`locationId`,
                        `garden_master`.`garden_name`
                     FROM
                        `do_to_transporter`
                        INNER JOIN 
                        `purchase_invoice_detail` ON `purchase_invoice_detail`.`id` = `do_to_transporter`.`purchase_inv_dtlid`
                        INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id`=`garden_master`.`id`
                        INNER JOIN 
                        `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
                         LEFT JOIN `location`
                         ON
                         do_to_transporter.`locationId`=`location`.`id`
                        WHERE `do_to_transporter`.`transporterId` =".$transporterId." AND `do_to_transporter`.`is_sent` ='Y'";

        
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
    /**
     * 
     * @param type $purchaseDetailsId
     * @param type $data
     * @return int|boolean
     */
    
    public function UpdateDoReceivedGoods($doTransRcvdId='', $data){
        if($doTransRcvdId!=''){
            
            $this->db->where('id', $doTransRcvdId);
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
	public function getShortageExist($purDtlId=0){
	 $sql="SELECT `id` FROM `purchase_bag_details` WHERE `purchasedtlid`='".$purDtlId."' AND `bagtypeid`=3";
	 $query = $this->db->query($sql);
	 
	 if($query -> num_rows() > 0)
	   	{
		 return 1;
        }
     else
     {
      return 0;
     }
	 	
	}
    
	
}