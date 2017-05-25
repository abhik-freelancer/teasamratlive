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
        /*$sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number` FROM `purchase_invoice_detail`
                WHERE `purchase_invoice_detail`.`garden_id`='" . $gardenId . "'";*/
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $sql="SELECT 
                `purchase_invoice_detail`.`id`,
                `purchase_invoice_detail`.`invoice_number` 
             FROM `purchase_invoice_detail`
             INNER JOIN purchase_invoice_master ON purchase_invoice_master.id = purchase_invoice_detail.purchase_master_id
             WHERE `purchase_invoice_detail`.`garden_id`=".$gardenId." AND purchase_invoice_master.year_id=".$yearId.
             " AND purchase_invoice_master.company_id = ".$companyId;

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
        /*$sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`
                FROM `purchase_invoice_detail`
              WHERE `purchase_invoice_detail`.`garden_id`='" . $gardenId . "' AND `purchase_invoice_detail`.`invoice_number`='" . $invoice . "'";*/
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`
                FROM `purchase_invoice_detail`
                INNER JOIN purchase_invoice_master ON purchase_invoice_master.id = purchase_invoice_detail.purchase_master_id
                WHERE `purchase_invoice_detail`.`garden_id`=".$gardenId." 
                AND `purchase_invoice_detail`.`invoice_number`='".$invoice."'
                AND purchase_invoice_master.year_id=".$yearId. " AND purchase_invoice_master.company_id =".$companyId;
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
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $sql = "SELECT 
      `purchase_invoice_detail`.`id`,
      `purchase_invoice_detail`.`invoice_number`,
      `purchase_invoice_detail`.`lot`,
      `purchase_invoice_detail`.`grade_id`,
      `grade_master`.`grade` 
    FROM
      `purchase_invoice_detail` 
      INNER JOIN `grade_master` 
        ON `grade_master`.`id` = `purchase_invoice_detail`.`grade_id` 
      INNER JOIN purchase_invoice_master 
        ON purchase_invoice_master.id = purchase_invoice_detail.purchase_master_id 
    WHERE `purchase_invoice_detail`.`garden_id` = ".$garden."
      AND `purchase_invoice_detail`.`invoice_number` ='".$invoice."' 
      AND `purchase_invoice_detail`.`lot` = '".$lot."'
    AND purchase_invoice_master.year_id =".$yearId."  AND purchase_invoice_master.company_id = ".$companyId ;

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
    
    public function getMasterData($purchaseInvoiceDetailId){
     
        
        $sql="SELECT purchase_invoice_master.id,
		 purchase_invoice_detail.id AS prDtlId,	
		 purchase_invoice_master.purchase_invoice_date,
		 purchase_invoice_master.purchase_invoice_number,
		 purchase_invoice_master.vendor_id	,
		 vendor.vendor_name,
		 IFNULL(do_to_transporter.in_Stock,'N') AS in_Stock,
		 IFNULL (do_to_transporter.is_sent,'N') AS is_sent,
		 DATE_FORMAT(`do_to_transporter`.chalanDate,'%d-%m-%Y') AS ChallanDt,
		 transport.name AS transporterName
		 
    FROM purchase_invoice_detail 
    INNER JOIN purchase_invoice_master ON purchase_invoice_master.id  = purchase_invoice_detail.purchase_master_id	
    INNER JOIN vendor ON purchase_invoice_master.vendor_id = vendor.id
    LEFT  JOIN do_to_transporter ON purchase_invoice_detail.id =do_to_transporter.purchase_inv_dtlid
    LEFT  JOIN transport ON do_to_transporter.transporterId =  transport.id
    WHERE purchase_invoice_detail.id=".$purchaseInvoiceDetailId;
        
   
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
    
    public function getTeaStock($purchaseInvoiceDetailId){
        $data = array();
        $sql="SELECT 
                `purchase_invoice_detail`.id AS prDtlId,
                `purchase_invoice_master`.id AS prMastId,
                `purchase_invoice_master`.`purchase_invoice_number`,
                `purchase_bag_details`.`bagtypeid`,
                `purchase_bag_details`.`id` AS bagDtlId,
                `bagtypemaster`.`bagtype`,
                `purchase_bag_details`.`net`,
                `purchase_bag_details`.`actual_bags`
        FROM
                `purchase_invoice_detail` 
                INNER JOIN `purchase_invoice_master` 
                  ON `purchase_invoice_master`.id = `purchase_invoice_detail`.`purchase_master_id` 
                INNER JOIN `purchase_bag_details` 
                  ON `purchase_invoice_detail`.`id` = `purchase_bag_details`.`purchasedtlid` 
                INNER JOIN bagtypemaster 
                  ON `purchase_bag_details`.`bagtypeid` = `bagtypemaster`.`id` 
        WHERE 
                purchase_invoice_detail.id = ".$purchaseInvoiceDetailId;
        
        
        
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) 
                {
                    $noOfBlendBag = $this->getNoOfBlendBag($rows->bagDtlId);
                    $noOfStockOutbag = $this->getNoOfStockOutBag($rows->bagDtlId);
                    $noOfSaleBag = $this->getNoOfSaleBag($rows->bagDtlId);
                
                
             $data[]=array(
                   "prMastId" =>$rows->prMastId,
                   "prDtlId" =>$rows->prDtlId,
                   "bagDtlId"=>$rows->bagDtlId,
                   "purchase_invoice_number" =>$rows->purchase_invoice_number,
                   "bagtype" =>$rows->bagtype,
                   "ActualBags" =>$rows->actual_bags,
                   "net" => $rows->net,
                   "number_of_blended_bag" =>$noOfBlendBag,
                   "number_of_stockout_bag"=>$noOfStockOutbag,
                   "number_of_SaleBag"=>$noOfSaleBag,
                   "bagInstock"=>($rows->actual_bags-($noOfBlendBag + $noOfStockOutbag + $noOfSaleBag))
                   
                   
               );         
            }
        
            return $data;
        } else {
            return $data;
        }

        
    }
    
    
    /*@method getNoOfBlendBag
     * @param bagDtlId
     */
        
        public function getNoOfBlendBag($bagdtlid){
        /*  $sql="SELECT 
            SUM (`blending_details`.`number_of_blended_bag`) AS blendedbag
            FROM `blending_details`
            INNER JOIN `blending_master` 
            ON `blending_details`.`blending_master_id`=`blending_master`.`id`
            WHERE `blending_details`.`purchasebag_id`='".$bagdtlid."' AND blending_details.`number_of_blended_bag`<>0 GROUP BY `blending_details`.`purchasebag_id`";*/
          
          
        /*$sql="SELECT 
             SUM(`blending_details`.`number_of_blended_bag`) AS blendedbag
             FROM `blending_details`
             GROUP BY `blending_details`.`purchasebag_id`
             HAVING `blending_details`.`purchasebag_id`=".$bagdtlid;*/
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $sql = " SELECT 
             SUM(`blending_details`.`number_of_blended_bag`) AS blendedbag
             FROM `blending_details`
             INNER JOIN blending_master ON blending_master.id = blending_details.blending_master_id
             WHERE blending_master.companyid =".$companyId." 
			 /*AND blending_master.yearid =".$yearId."*/
             GROUP BY `blending_details`.`purchasebag_id`
             HAVING `blending_details`.`purchasebag_id`=".$bagdtlid;   
          
           $query = $this->db->query($sql);
           if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->blendedbag;
            } 
            else 
            {
                    return 0;
            }
            
        }
    
        
        
       /*@method getNoOfStockOutBag
         * 
         */
        
        public function getNoOfStockOutBag($bagdtlid){
            /* $sql="SELECT 
                SUM(stocktransfer_out_detail.`num_of_stockout_bag`) AS stockoutbag
                FROM `stocktransfer_out_detail`
                INNER JOIN `stocktransfer_out_master`
                ON `stocktransfer_out_master`.`id`=`stocktransfer_out_detail`.`stocktransfer_out_master_id`
                WHERE stocktransfer_out_detail.`purchase_bag_id`=".$bagdtlid." AND stocktransfer_out_detail.`num_of_stockout_bag`<>0 GROUP BY stocktransfer_out_detail.`purchase_bag_id`";*/
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];    
                 
        $sql="SELECT 
            SUM(`stocktransfer_out_detail`.`num_of_stockout_bag`) AS stockoutbag
            FROM `stocktransfer_out_detail`
            INNER JOIN
            stocktransfer_out_master ON stocktransfer_out_master.id = stocktransfer_out_detail.stocktransfer_out_master_id
            WHERE stocktransfer_out_master.company_id=".$companyId." 
			/*AND stocktransfer_out_master.year_id = ".$yearId."*/
            GROUP BY `stocktransfer_out_detail`.`purchase_bag_id`
            HAVING `stocktransfer_out_detail`.`purchase_bag_id`=".$bagdtlid;
             
             $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                            $row = $query->row(); 
                            return $row->stockoutbag;
                    } else {
                            return 0;
                    }
            
        }
        
        /*@method 
         * 
         */
        
        public function getNoOfSaleBag($bagDtldid){
           /*  $sql="SELECT 
                  SUM(`rawteasale_detail`.`num_of_sale_bag`) AS salebag
                FROM rawteasale_detail
               INNER JOIN `rawteasale_master`
               ON `rawteasale_master`.`id`=`rawteasale_detail`.`rawteasale_master_id`
               WHERE `rawteasale_detail`.`purchase_bag_id`=".$bagDtldid." AND `rawteasale_detail`.`num_of_sale_bag`<>0 GROUP BY `rawteasale_detail`.`purchase_bag_id`"; */
             
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];  
        
        $sql ="SELECT 
            SUM(`rawteasale_detail`.`num_of_sale_bag`) AS salebag
            FROM `rawteasale_detail`
            INNER JOIN rawteasale_master ON rawteasale_master.id = rawteasale_detail.rawteasale_master_id
            WHERE rawteasale_master.company_id =".$companyId." 
			/*AND rawteasale_master.year_id =".$yearId.
            "*/ GROUP BY `rawteasale_detail`.`purchase_bag_id`
            HAVING `rawteasale_detail`.`purchase_bag_id`=".$bagDtldid;
             
             
             $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                            $row = $query->row(); 
                            return $row->salebag;
                    } else {
                            return 0;
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
       $data = array();
        
        $sql="SELECT `blending_master`.`blending_ref`,
            `blending_master`.`blending_number`,
            DATE_FORMAT(`blending_master`.`blending_date`,'%d-%m-%Y') AS blendingDate,
            `blending_details`.`number_of_blended_bag`,
            `blending_details`.`qty_of_bag`
            FROM `blending_details`
            INNER JOIN `blending_master` 
            ON `blending_details`.`blending_master_id`=`blending_master`.`id`
            WHERE `blending_details`.`purchasebag_id`='".$bagDtlId."' AND blending_details.`number_of_blended_bag`<>0";
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

            return $data;
        } else {
            return $data;
        }
        
    }

    
  public function getStockOutBagDetail($bagDtlId){
      
        $data = array();
        $sql="SELECT `stocktransfer_out_master`.`refrence_number`,
            DATE_FORMAT(`stocktransfer_out_master`.`transfer_date`,'%d-%m-%Y') AS transferDt,
            stocktransfer_out_detail.`num_of_stockout_bag` AS StockOutBags,
            `stocktransfer_out_detail`.`qty_stockout_kg` 
            FROM `stocktransfer_out_detail`
            INNER JOIN `stocktransfer_out_master`
            ON `stocktransfer_out_master`.`id`=`stocktransfer_out_detail`.`stocktransfer_out_master_id`
            WHERE stocktransfer_out_detail.`purchase_bag_id`=".$bagDtlId." AND stocktransfer_out_detail.`num_of_stockout_bag`<>0";
        $query = $this->db->query($sql);
        
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                    
               
                $data[] = array(
                   "refrence_number" =>$rows->refrence_number,
                    "transferDt" =>$rows->transferDt,
                    "StockOutBags" => $rows->StockOutBags,
                    "qty_stockout_kg"=>$rows->qty_stockout_kg
                );
            }

            return $data;
        } else {
            return $data;
        }
        
    }   
 
    
   public function getSaleOutbagDtl($bagDtlId){
       $data = array();
       
      $sql="SELECT `rawteasale_master`.`invoice_no`,
            DATE_FORMAT(rawteasale_master.`sale_date`,'%d-%m-%Y') AS saleDt,
            `rawteasale_detail`.`num_of_sale_bag` AS NoOfsaleBag,
            rawteasale_detail.`qty_of_sale_bag`
            FROM rawteasale_detail
            INNER JOIN `rawteasale_master`
            ON `rawteasale_master`.`id`=`rawteasale_detail`.`rawteasale_master_id`
            WHERE `rawteasale_detail`.`purchase_bag_id`=".$bagDtlId." AND `rawteasale_detail`.`num_of_sale_bag`<>0"; 
      $query = $this->db->query($sql);
        
          if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                   "invoice_no" =>$rows->invoice_no,
                    "saleDt" =>$rows->saleDt,
                    "NoOfsaleBag" => $rows->NoOfsaleBag,
                    "qty_of_sale_bag"=>$rows->qty_of_sale_bag
                );
            }

            return $data;
        } else {
            return $data;
        }
   }
   
   public function  getPurchaseInvoiceId($gardenId,$invoiceNum,$lot,$grade){
       $session = sessiondata_method();
       $companyId = $session['company'];
       $yearId = $session['yearid'];
       $purchaseInvoiceId=0;
        $sql = "SELECT purchase_invoice_detail.id FROM 
               purchase_invoice_detail 
               INNER JOIN purchase_invoice_master 
               ON purchase_invoice_master.id = purchase_invoice_detail.purchase_master_id 
               WHERE
               `purchase_invoice_detail`.`garden_id` = ".$gardenId."
                AND `purchase_invoice_detail`.`invoice_number` = '".$invoiceNum."' 
                AND `purchase_invoice_detail`.`lot` = '".$lot."' AND purchase_invoice_detail.grade_id = ".$grade."
                AND purchase_invoice_master.year_id = ".$yearId."
                AND purchase_invoice_master.company_id = ".$companyId;
       $query = $this->db->query($sql);
       if($query->num_rows()>0) {
           $row = $query->row();
           $purchaseInvoiceId = $row->id;
       }
       return $purchaseInvoiceId;
       
   }
   

 
}

?>