<?php

class doreceivedmodel extends CI_Model{
	
 /**
     * @mehod getDoLists
     * @param type $purchaseInvoiceID
     * @return boolean
     * @description List of 'do' received
     */
            
    public function getDoTransporter($transporterId='',$company,$yearid){
        
             $sql = "SELECT 
                            `purchase_invoice_detail`.`id` AS purchaseDTLsId,
                            `do_to_transporter`.id AS doTransIds,
                            `do_to_transporter`.do,
                            `purchase_invoice_detail`.`invoice_number`,
                            `purchase_invoice_detail`.`grade_id`,
                            `grade_master`.`grade`,
                            `purchase_invoice_detail`.`total_weight`,
                            `do_to_transporter`.`chalanNumber`,
                            DATE_FORMAT(
                              `do_to_transporter`.`chalanDate`,
                              '%d-%m-%Y'
                            ) AS chalanDate,
                            `do_to_transporter`.`in_Stock`,
                            do_to_transporter.`locationId`,
                            `garden_master`.`garden_name` 
                          FROM
                            `do_to_transporter` 
                            INNER JOIN `purchase_invoice_detail` 
                              ON `purchase_invoice_detail`.`id` = `do_to_transporter`.`purchase_inv_dtlid` 
                            INNER JOIN purchase_invoice_master
                             ON purchase_invoice_detail.`purchase_master_id`=purchase_invoice_master.id
                            INNER JOIN `garden_master` 
                              ON `purchase_invoice_detail`.`garden_id` = `garden_master`.`id` 
                            INNER JOIN `grade_master` 
                              ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id` 
                            LEFT JOIN `location` 
                              ON do_to_transporter.`locationId` = `location`.`id` 
                            WHERE `do_to_transporter`.`transporterId` =".$transporterId." AND `do_to_transporter`.`is_sent` ='Y'
                            AND purchase_invoice_master.`company_id`=".$company ;/*." AND purchase_invoice_master.`year_id`=".$yearid;*/

        
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $rows) {
                // $data[$key]=$rows;

                $data[$key]['purchaseDTLsId'] = $rows->purchaseDTLsId;
                $data[$key]['doTransIds'] = $rows->doTransIds;
                $data[$key]['do'] = $rows->do;
                $data[$key]['invoice_number'] = $rows->invoice_number;
                $data[$key]['grade_id'] = $rows->grade_id;
                $data[$key]['grade'] = $rows->grade;
                $data[$key]['total_weight'] = $rows->total_weight;
                $data[$key]['chalanNumber'] = $rows->chalanNumber;
                $data[$key]['chalanDate'] = $rows->chalanDate;
                $data[$key]['in_Stock'] = $rows->in_Stock;
                $data[$key]['locationId'] = $rows->locationId;
                $data[$key]['garden_name'] = $rows->garden_name;
                $data[$key]['Bags'] = $this->getPurchaseBagDetails($rows->purchaseDTLsId);
                $data[$key]['totalbags'] = sizeof($this->getPurchaseBagDetails($rows->purchaseDTLsId));
                
            }

            return $data;
        } else {
            return false;
        }
        
    }
    
    /*@method  getPurchaseBagDetails($purchaseInvoiceDetailsId = '')
     * @date 27-01-2016
     * return $data
     */
    public function getPurchaseBagDetails($purchaseInvoiceDetailsId = '') {
        $data = array();
        if ($purchaseInvoiceDetailsId != '') {
            $sql = " SELECT 
                    `purchase_bag_details`.`id`,
                    `purchase_bag_details`.`bagtypeid`,
                    `purchase_bag_details`.`net`,
                    `purchase_bag_details`.`no_of_bags`,
                    `bagtypemaster`.`bagtype`
                     FROM
                    `purchase_bag_details`
                     INNER JOIN
                     bagtypemaster ON `purchase_bag_details`.`bagtypeid` = bagtypemaster.`id`  
                     WHERE `purchase_bag_details`.`purchasedtlid`= '".$purchaseInvoiceDetailsId."'";
            
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    $data[] = $rows;
                }


                return $data;
            } else {
                return $data;
            }
        } else {
            return FALSE;
        }
    } 
    
    
    
    /*@getStockwithtransporter
     * @param $value['transporterid']
     * @date 18-01-2016
     * This function used for liststockwithtransporter(),getStockWithTransPrint(),getStockWithTransporterPdf();
     */
     public function getStockwithtransporter($transporterId,$compnyId){
        
            $sql="SELECT 
                        `purchase_invoice_master`.`sale_number`,
                        purchase_invoice_master.from_where,
                        `purchase_invoice_detail`.`id` AS purchaseDTLsId,
                        `do_to_transporter`.id AS doTransIds,
                        `do_to_transporter`.do,
                        `purchase_invoice_detail`.`invoice_number`,
                        `purchase_invoice_detail`.`grade_id`,
                        `grade_master`.`grade`,
                        `purchase_invoice_detail`.`total_weight`,
                        `purchase_invoice_detail`.`price`,
                        `do_to_transporter`.`chalanNumber`,
                         DATE_FORMAT(`do_to_transporter`.`chalanDate`, '%d-%m-%Y') AS chalanDate,
                        `do_to_transporter`.`in_Stock`,
                        do_to_transporter.`locationId`,
                        `garden_master`.`garden_name`,
                        SUM(`purchase_bag_details`.`no_of_bags`) AS totalBags,
                        SUM(`purchase_bag_details`.`net`) AS NetKg,
                       (`purchase_invoice_detail`.`total_weight`*`purchase_invoice_detail`.`price`) AS amount
                     FROM
                        `do_to_transporter`
                        INNER JOIN 
                        `purchase_invoice_detail` ON `purchase_invoice_detail`.`id` = `do_to_transporter`.`purchase_inv_dtlid`
                        INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id`=`garden_master`.`id`
                       
                         INNER JOIN purchase_invoice_master
                         ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`

                        INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id`=`purchase_bag_details`.`purchasedtlid`
                        INNER JOIN 
                        `grade_master` ON `purchase_invoice_detail`.`grade_id` = `grade_master`.`id`
                         LEFT JOIN `location`
                         ON
                         do_to_transporter.`locationId`=`location`.`id`
                        WHERE purchase_invoice_master.from_where <> 'SB' AND purchase_invoice_master.company_id=".$compnyId." AND `do_to_transporter`.`transporterId` =".$transporterId." AND(`do_to_transporter`.`chalanNumber`='' OR `do_to_transporter`.`chalanNumber` IS NULL)"
                   . " GROUP BY `purchase_invoice_detail`.`id`";

        
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
    
    public function getTransporterName($transporterid){
      $sql="SELECT `transport`.`name` FROM`transport` WHERE `transport`.`id`=".$transporterid;
        $query = $this->db->query($sql);
		 if ($query->num_rows() > 0)
            {
                $rows=$query->row();
                $data = $rows->name;

                return $data;
            } else {
                return $data;
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