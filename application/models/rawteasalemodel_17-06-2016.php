<?php

class rawteasalemodel extends CI_Model {
    
    
    public function getRawTeasaleList($cmpny,$year){
        $data = array();
        $sql = "SELECT 
                rawteasale_master.id,
                rawteasale_master.`invoice_no`,
                DATE_FORMAT(rawteasale_master.`sale_date`,'%d-%m-%Y') AS saleDate,
                rawteasale_master.`total_sale_bag`,
                rawteasale_master.`total_sale_qty`,
                rawteasale_master.`grandtotal`,
                `customer`.`customer_name`
                FROM rawteasale_master
                INNER JOIN customer
                ON customer.`id`=rawteasale_master.`customer_id`
                WHERE rawteasale_master.`company_id`=".$cmpny ." AND rawteasale_master.`year_id`=".$year;
        
        $query = $this->db->query($sql); 
        if($query->num_rows() >0){
            foreach ($query->result() as $rows){
                $data[]= array(
                    "rawteaSaleMastId" => $rows->id,
                    "invoice_no" => $rows->invoice_no,
                    "saleDate" => $rows->saleDate,
                    "total_sale_bag" => $rows->total_sale_bag,
                    "total_sale_qty" => $rows->total_sale_qty,
                    "grandtotal" => $rows->grandtotal,
                    "customer_name" => $rows->customer_name
                );
            }
            return $data;
        }
        else{
             return $data;
        }
    }
    
    
    
    
    
        public function getTeaStock($garden = "", $invoice = "", $lotnumber = "", $grade = "") {
        $data = array();
        $sql ="SELECT 
                        PID.`id` AS purchaseDtl,
                        PBD.`id` AS purchaseBagDtlId,
                        PID.`teagroup_master_id`,
                        PID.`invoice_number`,
                        PID.`lot`,garden_master.`garden_name`,
                        PID.`garden_id`, grade_master.`grade`,PID.`grade_id`,
                        location.`location`,teagroup_master.`group_code`,
                        PID.`price`,PID.`cost_of_tea`,
                        PBD.`actual_bags`,
                        PBD.`net`,
                        PBD.`shortkg`
                        FROM `purchase_invoice_detail` PID 
                INNER JOIN 
                        `purchase_bag_details` PBD ON PID.`id` =PBD.`purchasedtlid`
                INNER JOIN 
                        do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
                INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
                INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
                INNER JOIN `location` ON DOT.`locationId`=`location`.`id`  
                INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
             WHERE PID.`garden_id`='".$garden."' AND PID.`invoice_number`='".$invoice."' AND PID.`lot`='".$lotnumber."' AND PID.`grade_id`='".$grade."'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                
                $NumberOfStockBag =($rows->actual_bags -  $this->getsaleOutBag($rows->purchaseBagDtlId));
                
                if ($NumberOfStockBag != 0) {
                    $data[] = array(
                        "purchaseDtl" => $rows->purchaseDtl,
                        "PbagDtlId" => $rows->purchaseBagDtlId,
                        "BagNet" => $rows->net,//purchased bag net
                        "Garden" => $rows->garden_name,
                        "Invoice" => $rows->invoice_number,
                        "Group" => $rows->group_code,
                        "Grade" => $rows->grade,
                        "Location" => $rows->location,
                        "Numberofbags" =>($rows->actual_bags - $this->getsaleOutBag($rows->purchaseBagDtlId)),//$rows->NumberOfStockBag,
                        "kgperbag" => $rows->net,
                        //"pricePerBag"=>$rows->price,
                        "pricePerBag"=>$rows->cost_of_tea,
                        "NetBags" =>($rows->actual_bags - $this->getsaleOutBag($rows->purchaseBagDtlId))*($rows->net),                //$rows->StockBagQty,
                        "blendedBag" => $this->getsaleOutBag($rows->purchaseBagDtlId),                            //$rows->number_of_blended_bag,
                        "blendedKgs" => number_format($rows->net * $this->getsaleOutBag($rows->purchaseBagDtlId), 2)
                    );
                }
            }
          
           
           return $data;
        } else {
            return $data;
        }
    }
    
    
    
    
    /**
 * @method getBlendedBag
 * @param type $bagDtlId
 * @return int
 */
  
public function getsaleOutBag($bagDtlId){
     $sql = "SELECT `rawteasale_detail`.`purchase_bag_id`,
                SUM(`rawteasale_detail`.`num_of_sale_bag`) AS sale_bag
            FROM `rawteasale_detail` 
            GROUP BY `rawteasale_detail`.`purchase_bag_id`
            HAVING `rawteasale_detail`.`purchase_bag_id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->sale_bag;
        } else {
                return 0;
        }
}
  
     
    /**
     * @method getInvoice
     * @param type $gardenId
     * @return type
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
    
     /**
     * @method getLotNumber
     * @param type $gardenId
     * @param type $invoice
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
    
     /**
     * @method getGradeNumber
     * @param type $garde Description
     * 
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
    
    
      public  function getPurchaseExist($garden,$invoice,$lot,$grade){
        $sql="SELECT DISTINCT `purchase_invoice_detail`.`id`
                FROM purchase_invoice_detail 
              WHERE `garden_id`='".$garden."' AND `invoice_number`='".$invoice."' AND `lot`='".$lot."' AND `grade_id`='".$grade."'";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
                $row = $query->row(); 
                
                return $row->id;
            
        } else {
                return 0;
        }
    }
    
    
        public function getRawsaleTeaSerialNo($cid,$yid){
        $sql="select srl_number from serials where `serials`.`moduleType`='Sale' AND company_id=".$cid." AND year_id=".$yid."";
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
           $row = $query->row();
            return $row->srl_number;
       } 
       else{
           return 0;
       }
     }
     
      /**
     * 
     * @param type $master
     * @param type $sercharr
     */
    public function insertData($master, $sercharr) {

        try {
            $this->db->trans_begin();
            $this->db->insert('rawteasale_master', $master);
           /* echo $this->db->last_query();
            exit;*/
            $rawteassaleMastId = $this->db->insert_id();
            $this->insertrawTeaSaleDtl($rawteassaleMastId, $sercharr);
            
          //  $this->updateSerialTableForaSale($srl_no);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    
    /**
     * 
     * @param type $masterId
     * @param type $dtlArr
     */
    public function insertrawTeaSaleDtl($masterId, $dtlArr) {
        $rawteaSaleDtl = array();
        $numberOfDtl = count($dtlArr['txtBagDtlId']);
        for ($i = 0; $i < $numberOfDtl; $i++) {
            $rawteaSaleDtl['rawteasale_master_id'] = $masterId;
            $rawteaSaleDtl['purchase_detail_id'] = $dtlArr['txtpurchaseDtl'][$i];
            $rawteaSaleDtl['purchase_bag_id'] = $dtlArr['txtBagDtlId'][$i];
            $rawteaSaleDtl['num_of_sale_bag'] = ($dtlArr['txtused'][$i]==""?0:$dtlArr['txtused'][$i]);
            $rawteaSaleDtl['qty_of_sale_bag'] = $dtlArr['txtnetinBag'][$i];
            $rawteaSaleDtl['rate'] = ($dtlArr['txtrate'][$i]==""?0:$dtlArr['txtrate'][$i]);

           // if ($dtlArr['txtused'][$i] != 0) {
                $this->db->insert('rawteasale_detail', $rawteaSaleDtl);
            //}
        }
    }
    
    
   /* @ will aplly later -- 14-06-2016
    * public function updateSerialTableForaSale($srl_no){
        $session = sessiondata_method();
        
        $check = array();
        $check['moduleType'] =  'Sale';
        $check['company_id'] = $session['company'];
        $check['year_id'] = $session['yearid'];
        
        $data = array();
        $data['srl_number'] = $srl_no;
         $this->db->where($check);
         $this->db->update('serials', $data);
        
        
    }*/
    
    public function updateRawTeaSale($rawTeasalemasterId,$masterData = array(), $detail = array()){
        if ($rawTeasalemasterId != '') {
            try {
                $this->db->trans_begin();
                $this->db->where('id', $rawTeasalemasterId);
                $this->db->update('rawteasale_master', $masterData);
              // echo $this->db->last_query();
                
                /*                 * details delete** */
                $this->db->delete('rawteasale_detail', array('rawteasale_master_id' => $rawTeasalemasterId));
                /*                 * details delete** */
                $this->insertrawTeaSaleDtl($rawTeasalemasterId, $detail);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            return false;
        }
    }
    
    
    
    
    
       /**
    * @name getCurrentcstrate
    * @param type $startYear
    * @param type $endYear
    * @return type
    */ 
   public  function getCurrentcstrate($startYear, $endYear) {
        $sql = "SELECT id, cst_rate FROM cst WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        } else {
            return $data = array();
        }
   }
   
   
   /**
     * @name getCurrentvatrate
     * @param type $startYear
     * @param type $endYear
     * @return type
     */
    public function getCurrentvatrate($startYear, $endYear) {
        $sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        
    }
    
    
    public function getRawTeaSalemasterData($rawteaslMastId){
        $sql = "SELECT 
                rawteasale_master.id,
                rawteasale_master.`invoice_no`,
                DATE_FORMAT(rawteasale_master.`sale_date`,'%d-%m-%Y') AS saleDate,
                rawteasale_master.`customer_id`,
                rawteasale_master.`vehichleno`,
                rawteasale_master.`taxrateType`,
                rawteasale_master.`taxrateTypeId`,
                rawteasale_master.`discountRate`,
                rawteasale_master.`discountAmount`,
                rawteasale_master.`deliverychgs`,
                rawteasale_master.`taxamount`,
                rawteasale_master.`totalamount`,
                rawteasale_master.`roundoff`,
                rawteasale_master.`total_sale_bag`,
                rawteasale_master.`total_sale_qty`,
                rawteasale_master.`grandtotal`
              FROM
                rawteasale_master 
                WHERE rawteasale_master.`id`=".$rawteaslMastId;
        
         $query = $this->db->query($sql); 
        if($query->num_rows() >0){
            foreach ($query->result() as $rows){
                $data= array(
                    "rawteaSaleMastId" => $rows->id,
                    "invoice_no" => $rows->invoice_no,
                    "saleDate" => $rows->saleDate,
                    "customer_id" => $rows->customer_id,
                    "vehichleno" => $rows->vehichleno,
                    "taxrateType" => $rows->taxrateType,
                    "taxrateTypeId" => $rows->taxrateTypeId,
                    "taxamount" => $rows->taxamount,
                    "discountRate" => $rows->discountRate,
                    "discountAmount"=> $rows->discountAmount,
                    "deliverychgs"=> $rows->deliverychgs,
                    "totalamount"=> $rows->totalamount,
                    "roundoff"=> $rows->roundoff,
                    "total_sale_bag" => $rows->total_sale_bag,
                    "total_sale_qty" => $rows->total_sale_qty,
                    "grandtotal" => $rows->grandtotal
                    
                );
            }
            return $data;
        }
        else{
             return $data;
        }
        
    }
    
    public function getRawTeaSaleDtlData($rawteaSlMastid){
     $sql="SELECT 
            `rawteasale_detail`.`rawteasale_master_id`,
            `rawteasale_detail`.`id`,
            `rawteasale_detail`.`num_of_sale_bag`,
            `rawteasale_detail`.`qty_of_sale_bag`,
            `rawteasale_detail`.`rate`,
            `rawteasale_detail`.`purchase_bag_id`,
            `rawteasale_detail`.`purchase_detail_id`,
            PID.`id` AS purchaseDtl,
            PID.`teagroup_master_id`,
            PID.`invoice_number`,
            PID.`price`,
            PID.`cost_of_tea`,
            PID.`lot`,
            PID.`garden_id`, 
            PID.`grade_id`,
            garden_master.`garden_name`,
            grade_master.`grade`,
            location.`location`,
            `teagroup_master`.`group_code`
            FROM
            `rawteasale_detail`
            INNER JOIN
            `purchase_invoice_detail` AS PID
            ON `rawteasale_detail`.`purchase_detail_id`=PID.`id`
            INNER JOIN garden_master ON PID.`garden_id` = garden_master.`id`
            INNER JOIN grade_master ON PID.`grade_id` = grade_master.`id`
            INNER JOIN 
             do_to_transporter DOT ON PID.`id`= DOT.`purchase_inv_dtlid` AND DOT.`in_Stock`='Y'
            INNER JOIN `location` ON DOT.`locationId`=`location`.`id` 
            INNER JOIN `teagroup_master` ON PID.`teagroup_master_id` = `teagroup_master`.`id`
            WHERE `rawteasale_detail`.`rawteasale_master_id`=".$rawteaSlMastid;
     
     
     
     
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                    
                $saleBag = ($this->getPurchasedBag($rows->purchase_bag_id) - $this->getsaleOutBag($rows->purchase_bag_id));
                $data[] = array(
                    "purchaseDtl" => $rows->purchase_detail_id,
                    "PbagDtlId" => $rows->purchase_bag_id,
                    "BagNet" => $rows->qty_of_sale_bag,
                    "Garden" => $rows->garden_name,
                    "Invoice" => $rows->invoice_number,
                    "Group" => $rows->group_code,
                    "Grade" => $rows->grade,
                    "Location" => $rows->location,
                    "Numberofbags" => $saleBag,//($this->getPurchasedBag($rows->purchasebag_id) - $this->getBlendedBag($rows->purchasebag_id)),//$rows->NumberOfStockBag,
                    "kgperbag" => $rows->qty_of_sale_bag,
                    "rate" => $rows->rate,
                   // "pricePerBag"=>$rows->price,
                    "pricePerBag"=>$rows->cost_of_tea,
                    "NetBags" => ($saleBag * $rows->qty_of_sale_bag), //$rows->StockBagQty,
                    "saleBagNo" => $rows->num_of_sale_bag,
                    "saleCost" =>($rows->num_of_sale_bag * $rows->rate ),
                    "saleKgs" => number_format($rows->qty_of_sale_bag * $rows->num_of_sale_bag, 2)
                );
            }


            return $data;
        } else {
            return $data;
        }
}

/**
 * @name getPurchasedBag
 * @param type $bagDtlId
 * @return int
 * @description get purchased bag from purchase_bag_details actual_bags
 */
public function getPurchasedBag($bagDtlId){
    $sql="SELECT `purchase_bag_details`.`id`,`purchase_bag_details`.`actual_bags`
            FROM `purchase_bag_details` WHERE `purchase_bag_details`.`id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->actual_bags;
        } else {
                return 0;
        }
    
}

public function RawTeaSalematerData($masterId){
        $data = array();
     $sql=" SELECT 
                rawteasale_master.id,
              rawteasale_master.`invoice_no`, 
              DATE_FORMAT(rawteasale_master.`sale_date`,'%d-%m-%Y') AS SaleDt,
                rawteasale_master.`customer_id`,
                rawteasale_master.`vehichleno`,
                rawteasale_master.taxrateType,
                rawteasale_master.taxrateTypeId,
                rawteasale_master.taxamount,
                rawteasale_master.discountRate,
                rawteasale_master.discountAmount,
                rawteasale_master.deliverychgs,
                rawteasale_master.`total_sale_bag`,
                rawteasale_master.`total_sale_qty`,
                rawteasale_master.totalamount,
                rawteasale_master.roundoff,
                rawteasale_master.grandtotal,
                rawteasale_master.year_id,
                rawteasale_master.company_id,
                customer.customer_name,
                customer.`address`,
                customer.`cst_number`,
                customer.`tin_number`,
                customer.`pin_number`,
                customer.`telephone`,
                `company`.`company_name`,
                `company`.`location` 
              FROM
                `rawteasale_master` 
                INNER JOIN `customer` 
                  ON `rawteasale_master`.`customer_id` = `customer`.`id` 
                INNER JOIN `company` 
                  ON rawteasale_master.company_id = `company`.`id` 
              WHERE `rawteasale_master`.`id`=".$masterId;
       
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "invoice_no" => $rows->invoice_no,
                    "SaleDt" => $rows->SaleDt,
                    "vehichleno"=>$rows->vehichleno,
                    "Customer"=>$rows->customer_name,
                    "CustomerAddress"=>$rows->address,
                    "CustomerCST"=>$rows->cst_number,
                    
                    "TotalSaleBag"=>$rows->total_sale_bag,
                    "TotalSaleQty"=>$rows->total_sale_qty,
                    "TotalAmount"=>$rows->totalamount,
                    
                    "TaxRateType"=>$rows->taxrateType,
                    "TaxAmount"=>$rows->taxamount,
                    "DiscountRate"=>$rows->discountRate,
                    "DiscountAmount"=>$rows->discountAmount,
                    "DeliveryChgs"=>$rows->deliverychgs,
                    "RoundOff"=>$rows->roundoff,
                    "GrandTotal"=>$rows->grandtotal,
                    "Company"=>$rows->company_name, 
                    "CompanyLocation"=>$rows->location, 
                    "VatNumber"=>$rows->vat_number,
                    "TinNumber"=>$rows->tin_number,
                    "PinNumber"=>$rows->pin_number,
                    "telephone"=>$rows->telephone
                );
            }


            return $data;
        } else {
            return $data;
        }
        
    }
    
    public function RawteaSaleDtlData($masterId){
        $data = array();
        $sql = "SELECT 
            `rawteasale_detail`.`num_of_sale_bag`,
            `rawteasale_detail`.`qty_of_sale_bag` AS net,
            `rawteasale_detail`.rate,
            `purchase_invoice_detail`.`invoice_number`,
            `purchase_invoice_detail`.`cost_of_tea`,
            `teagroup_master`.group_code,
            `grade_master`.`grade`,
            `garden_master`.`garden_name`,
            `purchase_bag_details`.`net`

            FROM
            `rawteasale_detail`
            INNER JOIN purchase_invoice_detail
            ON purchase_invoice_detail.id = rawteasale_detail.`purchase_detail_id`
            INNER JOIN teagroup_master
            ON teagroup_master.id=purchase_invoice_detail.`teagroup_master_id`
            INNER JOIN grade_master
            ON grade_master.`id` = purchase_invoice_detail.`grade_id`
            INNER JOIN garden_master
            ON garden_master.`id` = purchase_invoice_detail.`garden_id`
            INNER JOIN `purchase_bag_details`
            ON `purchase_bag_details`.`id`=`rawteasale_detail`.`purchase_bag_id`
            WHERE `rawteasale_detail`.`rawteasale_master_id`=".$masterId;
        
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "invoice_number"=>$rows->invoice_number,
                    "group_code"=> $rows->group_code,
                    "grade"=>$rows->grade,
                    "garden_name"=>$rows->garden_name,
                    "net"=>$rows->net,
                    "cost_of_tea"=>$rows->cost_of_tea,
                    "num_of_sale_bag"=>$rows->num_of_sale_bag,
                    "rate"=>$rows->rate,
                    "amount"=>($rows->num_of_sale_bag*$rows->rate),
                    "totalDtlkgs"=>($rows->net*$rows->num_of_sale_bag)
                    
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
        
        
        
        
    }


    
    
    
}
?>