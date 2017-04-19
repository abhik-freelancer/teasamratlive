<?php

class invoicestatusmodel extends CI_Model {
    
    
    /*
       @method getInvoice()
     * @parma $gardenId
     * @return invoice_number as $data
     * @date 08.02.2016
     * @author Mithilesh
     */
    public function getInvoice($gardenId) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number` FROM `purchase_invoice_detail`
                WHERE `purchase_invoice_detail`.`garden_id`='" . $gardenId . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "pdtlId" => $rows->id,
                    "invoice" => $rows->invoice_number,
                );
            }

            return $data;
        } else {
            return $data;
        }
    }
    
      /*
       @method getLotNumber()
     * @parma $gardenId, $invoice
     * @return lot as $data
     * @date 08.02.2016
     * @author Mithilesh
     */
    
        public function getLotNumber($gardenId, $invoice) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`
                FROM `purchase_invoice_detail`
              WHERE `purchase_invoice_detail`.`garden_id`='" . $gardenId . "' AND `purchase_invoice_detail`.`invoice_number`='" . $invoice . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "lot" => $rows->lot,
                    "lotnumber" => $rows->lot,
                );
            }

            return $data;
        } else {
            return $data;
        }
    }
    
     /*
       @method getGradeNumber()
     * @parma $garden, $invoice, $lot
     * @return grade as $data
     * @date 08.02.2016
     * @author Mithilesh
     */
    
     public function getGradeNumber($garden, $invoice, $lot) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,
                    `purchase_invoice_detail`.`invoice_number`,
                    `purchase_invoice_detail`.`lot`,
                    `purchase_invoice_detail`.`grade_id`,
                    `grade_master`.`grade`
              FROM `purchase_invoice_detail`
                    INNER JOIN `grade_master` ON `grade_master`.`id`=`purchase_invoice_detail`.`grade_id`
              WHERE `purchase_invoice_detail`.`garden_id`='" . $garden . "'  
                AND `purchase_invoice_detail`.`invoice_number`='" . $invoice . "' AND `purchase_invoice_detail`.`lot`='" . $lot . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "gradeid" => $rows->grade_id,
                    "grade" => $rows->grade,
                );
            }

            return $data;
        } else {
            return $data;
        }
    }
    
     /*
       @method getMasterData()
     * @parma $garden, $invoice, $lot ,$inStock
     * @return  $data
     * @date 08.02.2016
     * @author Mithilesh
     */
    
    public function getMasterData($garden,$invoice,$lotNum,$grade){
     
        
        $sql="SELECT 
            `purchase_invoice_master`.`purchase_invoice_number`,
           
            `vendor`.`vendor_name`,
            `purchase_invoice_detail`.`id` AS prDtlId,
            `do_to_transporter`.`is_sent`,
            `do_to_transporter`.`in_Stock`,
            `transport`.`name` AS transporterName,
            DATE_FORMAT(`do_to_transporter`.chalanDate,'%d-%m-%Y') AS ChallanDt

            FROM  `purchase_invoice_detail`
            INNER JOIN purchase_invoice_master
            ON `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id`
            LEFT JOIN `do_to_transporter`
            ON `do_to_transporter`.`purchase_inv_dtlid`=`purchase_invoice_detail`.`id`
           INNER JOIN vendor
           ON purchase_invoice_master.vendor_id=vendor.id
           LEFT JOIN `transport`
           ON `do_to_transporter`.`transporterId`=`transport`.`id`
            WHERE `purchase_invoice_detail`.`garden_id`=".$garden." AND
            `purchase_invoice_detail`.`invoice_number`='".$invoice."' AND
            `purchase_invoice_detail`.`lot`='".$lotNum."' AND
            `purchase_invoice_detail`.`grade_id`=".$grade;
        
   
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "purchase_invoice_number"=>$rows->purchase_invoice_number,
                    "prDtlId" => $rows->prDtlId,
                    "vendor_name" =>$rows->vendor_name,
                    "transporterName"=>$rows->transporterName,
                    "instock"=>$rows->in_Stock,
                    "isSent"=>$rows->is_sent,
                    "ChallanDt"=>$rows->ChallanDt
                );
            }

            return $data;
        } else {
            return $data;
        }
           
    }
    
     /*
       @method getTeaStock()
     * @parma $garden, $invoice, $lot ,$inStock
     * @return  $data
     * @date 08.02.2016
     * @author Mithilesh
     */
    
    public function getTeaStock($garden,$invoice,$lotNum,$grade){
      //  $data = array();
      
        
        $sql="SELECT 
            `purchase_invoice_detail`.id AS prDtlId,
            `purchase_invoice_master`.id AS prMastId,
            `purchase_invoice_master`.`purchase_invoice_number`,
            `purchase_bag_details`.`bagtypeid`,
            `purchase_bag_details`.`id` AS bagDtlId,
            `bagtypemaster`.`bagtype`,
           `purchase_bag_details`.`actual_bags` AS ActualBags,
          `purchase_bag_details`.`net`,
            `purchase_bag_details`.`actual_bags`,
            SUM(`blending_details`.`number_of_blended_bag`) AS blendedBags,
           
            `blending_master`.`id` AS blndMasterId,
            `blending_details`.`id` AS blndDtlId,
            `do_to_transporter`.`in_Stock`,
            `do_to_transporter`.`is_sent`
          FROM
            `purchase_invoice_detail` 
            INNER JOIN `purchase_invoice_master` 
              ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
            INNER JOIN `purchase_bag_details` 
              ON `purchase_invoice_detail`.`id` = `purchase_bag_details`.`purchasedtlid` 
            INNER JOIN bagtypemaster 
              ON `purchase_bag_details`.`bagtypeid` = `bagtypemaster`.`id` 
            LEFT JOIN do_to_transporter 
              ON `do_to_transporter`.`purchase_inv_dtlid` = `purchase_invoice_detail`.`id` 
            LEFT JOIN blending_details 
              ON `blending_details`.`purchasebag_id` = `purchase_bag_details`.`id` 
            LEFT JOIN blending_master 
              ON `blending_details`.`blending_master_id` = `blending_master`.`id` 
         WHERE `purchase_invoice_detail`.`garden_id` = '".$garden."' 
                    AND `purchase_invoice_detail`.`invoice_number` = '".$invoice."' 
                    AND `purchase_invoice_detail`.`lot` = '".$lotNum."' 
                    AND `purchase_invoice_detail`.`grade_id` = '".$grade."' 
                  
         GROUP BY purchase_bag_details.`bagtypeid`";
        
                $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
               $data[]=array(
                   "prMastId" =>$rows->prMastId,
                   "prDtlId" =>$rows->prDtlId,
                   "bagDtlId"=>$rows->bagDtlId,
                   "blndMasterId" =>$rows->blndMasterId,
                   "blndDtlId" =>$rows->blndDtlId,
                   "purchase_invoice_number" =>$rows->purchase_invoice_number,
                   "bagtype" =>$rows->bagtype,
                   "ActualBags" =>$rows->ActualBags,
                   "net" => $rows->net,
                   "number_of_blended_bag" =>$rows->blendedBags,
                   "in_Stock"=>$rows->in_Stock,
                   "is_sent"=>$rows->is_sent,
                   "bagInstock"=>($rows->ActualBags)-($rows->blendedBags)
                   
                   
               );           
            }
        
            return $data;
        } else {
            return $data;
        }

        
    }
    
      /*
       @method getBlendedDetail()
     * @parma $bagDtlId
     * @return  $data
     * @date 08.02.2016
     * @author Mithilesh
     */
  
    
    public function getBlendedDetail($bagDtlId){
       
        $sql="SELECT `blending_master`.`blending_ref`,
            `blending_master`.`blending_number`,
            DATE_FORMAT(`blending_master`.`blending_date`,'%d-%m-%Y') AS blendingDate,
            `blending_details`.`number_of_blended_bag`,
            `blending_details`.`qty_of_bag`
            FROM `blending_details`
            INNER JOIN `blending_master` 
            ON `blending_details`.`blending_master_id`=`blending_master`.`id`
            WHERE `blending_details`.`purchasebag_id`='".$bagDtlId."' AND blending_details.`number_of_blended_bag`!=0";
        $query = $this->db->query($sql);
        
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                    
               
                $data[] = array(
                   "blending_ref" =>$rows->blending_ref,
                    "blending_number" =>$rows->blending_number,
                    "blendingDate" => $rows->blendingDate,
                    "number_of_blended_bag" => $rows->number_of_blended_bag,
                    "qty_of_bag"=>$rows->qty_of_bag
                );
            }
/*
echo "<pre>";
    print_r($data);
echo "</pre>";*/
            return $data;
        } else {
            return $data;
        }
        
    }


 
}

?>