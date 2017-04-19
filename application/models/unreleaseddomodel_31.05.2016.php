<?php

class unreleaseddomodel extends CI_Model {

    /**
     * @mehod getDoLists
     * @param type $purchaseInvoiceID
     * @return boolean
     * @description List of 'do' received
     */
    public function getDoLists($isPending = '') {

        if ($isPending == 'Y') {
            $whereClause = " WHERE (`purchase_invoice_detail`.`doRealisationDate` IS NULL) OR (`purchase_invoice_detail`.`do` IS NULL OR `purchase_invoice_detail`.`do` ='')";
        } else {
            $whereClause = "";
        }

        $sql = "SELECT 
                    `purchase_invoice_detail`.`id` as pDtlId,
                    `purchase_invoice_master`.`id` as pMstId,
                    `purchase_invoice_master`.`purchase_invoice_number`,
                    DATE_FORMAT(`purchase_invoice_master`.`purchase_invoice_date`,'%d-%m-%Y') AS PurchaseInvoiceDate,
                    `purchase_invoice_master`.`sale_number`,
                    `purchase_invoice_detail`.`invoice_number`,
                    `purchase_invoice_detail`.`net`,
                    `purchase_invoice_detail`.`grade_id`,
                    `grade_master`.`grade`,
                    `purchase_invoice_detail`.`package`,
                    `purchase_invoice_detail`.`total_weight`,
                    `purchase_invoice_detail`.`do`,
                    `garden_master`.`garden_name`,
                     DATE_FORMAT(`purchase_invoice_detail`.`doRealisationDate`,'%d-%m-%Y') AS doRealisationDate,
                     IF(`do_to_transporter`.`is_sent` IS NULL OR `do_to_transporter`.`is_sent` ='N','N','Y') AS sentStatus
                     FROM 
                    `purchase_invoice_master`
                    INNER JOIN
                    `purchase_invoice_detail` 
                    ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id` AND (`purchase_invoice_master`.`from_where`<>'SB' AND `purchase_invoice_master`.`from_where`<>'OP' AND `purchase_invoice_master`.`from_where`<>'STI' )
                    INNER JOIN `grade_master` ON `grade_master`.`id` = `purchase_invoice_detail`.`grade_id` 
                 LEFT JOIN `do_to_transporter` ON `purchase_invoice_detail`.`id` = `do_to_transporter`.`purchase_inv_dtlid` 
                INNER JOIN `garden_master` ON `purchase_invoice_detail`.`garden_id`=`garden_master`.`id` " .
                $whereClause;

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $rows) {
                // $data[$key]=$rows;

                $data[$key]['pDtlId'] = $rows->pDtlId;
                $data[$key]['pMstId'] = $rows->pMstId;
                $data[$key]['purchase_invoice_number'] = $rows->purchase_invoice_number;
                $data[$key]['PurchaseInvoiceDate'] = $rows->PurchaseInvoiceDate;
                $data[$key]['sale_number'] = $rows->sale_number;
                $data[$key]['invoice_number'] = $rows->invoice_number;
                $data[$key]['grade_id'] = $rows->grade_id;
                $data[$key]['grade'] = $rows->grade;
                $data[$key]['garden'] = $rows->garden_name;
                $data[$key]['total_weight'] = $rows->total_weight;
                $data[$key]['do'] = $rows->do;
                $data[$key]['doRealisationDate'] = $rows->doRealisationDate;
                $data[$key]['sentStatus'] = $rows->sentStatus;
                $data[$key]['Bags'] = $this->getPurchaseBagDetails($rows->pDtlId);
                $data[$key]['totalbags'] = sizeof($this->getPurchaseBagDetails($rows->pDtlId));
                
            }






            return $data;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $purchaseInvoiceDetailsId
     * @return boolean
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

    /**
     * 
     * @param type $purchaseDetailsId
     * @param type $data
     * @return int|boolean
     */
    public function UpdatePurDetailsDo($purchaseDetailsId = '', $data) {
        
        
        if ($purchaseDetailsId != '') {
            $this->db->trans_begin();

            $this->db->where('id', $purchaseDetailsId);
            $this->db->update('purchase_invoice_detail', $data);
            
          
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return 0;
            } else {
                $this->db->trans_commit();
                return 1;
            }
        } else {
            return false;
        }
    
        
        
        }
    
    
   

}
