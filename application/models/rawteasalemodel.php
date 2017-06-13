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
                
                $NumberOfStockBag =($rows->actual_bags -  ($this->getsaleOutBag($rows->purchaseBagDtlId)+$this->getstockOutBag($rows->purchaseBagDtlId)+$this->getBlendedBag($rows->purchaseBagDtlId)));
                
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
                        "Numberofbags" =>$NumberOfStockBag,//($rows->actual_bags - $this->getsaleOutBag($rows->purchaseBagDtlId)),
                        "kgperbag" => $rows->net,
                        //"pricePerBag"=>$rows->price,
                        "pricePerBag"=>$rows->cost_of_tea,
                        "NetBags" =>($NumberOfStockBag)*($rows->net),                //$rows->StockBagQty,
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
 * @method getBlendedBag
 * @param type $bagDtlId
 * @return int
 */
public function getstockOutBag($bagDtlId){
     $sql = "SELECT `stocktransfer_out_detail`.`purchase_bag_id`,
                SUM(`stocktransfer_out_detail`.`num_of_stockout_bag`) AS stock_bag
            FROM `stocktransfer_out_detail` 
            GROUP BY `stocktransfer_out_detail`.`purchase_bag_id`
            HAVING `stocktransfer_out_detail`.`purchase_bag_id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->stock_bag;
        } else {
                return 0;
        }
}

/* @method getBlendedbag
 * @param type $bagDtlId
 */

public function getBlendedBag($bagDtlId){
     $sql = "SELECT `blending_details`.`purchasebag_id`,
                SUM(`blending_details`.`number_of_blended_bag`) AS blended_bag
            FROM `blending_details` 
            GROUP BY `blending_details`.`purchasebag_id`
            HAVING `blending_details`.`purchasebag_id`='".$bagDtlId."'";
    
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
                $row = $query->row(); 
                return $row->blended_bag;
        } else {
                return 0;
        }
}

  
     
    /**
     * @method getInvoice
     * @param type $gardenId
     * @return type
     */
    public function getInvoice($gardenId,$compnyId) {
        $data = array();
        
        $sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number` FROM `purchase_invoice_detail`
                INNER JOIN `purchase_invoice_master`
                ON purchase_invoice_master.`id`=purchase_invoice_detail.`purchase_master_id`
                WHERE `purchase_invoice_detail`.`garden_id`=".$gardenId." AND purchase_invoice_master.`company_id`=".$compnyId;
        

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
    public function getLotNumber($gardenId, $invoice ,$companyId) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,`purchase_invoice_detail`.`invoice_number`,`purchase_invoice_detail`.`lot`
                FROM `purchase_invoice_detail`
                INNER JOIN purchase_invoice_master  ON purchase_invoice_master.`id`=purchase_invoice_detail.`purchase_master_id`
              WHERE `purchase_invoice_detail`.`garden_id`='" . $gardenId . "' AND `purchase_invoice_detail`.`invoice_number`='" . $invoice . "' AND "
                . "purchase_invoice_master.company_id=".$companyId;
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
    public function getGradeNumber($garden, $invoice, $lot, $companyId) {
        $data = array();
        $sql = "SELECT `purchase_invoice_detail`.`id`,
                    `purchase_invoice_detail`.`invoice_number`,
                    `purchase_invoice_detail`.`lot`,
                    `purchase_invoice_detail`.`grade_id`,
                    `grade_master`.`grade`
              FROM `purchase_invoice_detail`
                    INNER JOIN purchase_invoice_master  ON purchase_invoice_master.`id`=purchase_invoice_detail.`purchase_master_id`
                    INNER JOIN `grade_master` ON `grade_master`.`id`=`purchase_invoice_detail`.`grade_id`
              WHERE `purchase_invoice_detail`.`garden_id`='" . $garden . "'  
                AND `purchase_invoice_detail`.`invoice_number`='" . $invoice . "' AND `purchase_invoice_detail`.`lot`='" . $lot . "' AND"
                 ." purchase_invoice_master.company_id=".$companyId;

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
     
     
     /*Update Raw tea sale */
     
     public function updateRawTeaSale($vouchermastId,$masterData = array(), $detail = array()){
     
        try {
                $this->db->trans_begin();
                $this->db->where('id',$vouchermastId);
                $this->db->update('voucher_master', $masterData);
                
                $this->insertintoVouchrDtl($vouchermastId,$detail);
                
                
                
                $this->updateRawTeaSaleMaster($detail);
                
              // echo $this->db->last_query();
                $rawteasleMastId = $detail['txtrawTeaSaleMastId'];
                $this->db->delete('rawteasale_detail', array('rawteasale_master_id' => $rawteasleMastId));
                $this->insertrawTeaSaleDtl($rawteasleMastId, $detail);
                
                $this->updateBillMaster($rawteasleMastId, $detail);

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
    
   private  function updateBillMaster($taxinvoiceId,$searcharray){
        $session = sessiondata_method();
        $updatearr = array("invoicemasterid"=>$taxinvoiceId,
            "saletype"=>'R');
       
        $billMasterArray["billdate"]=date("Y-m-d", strtotime($searcharray['saleDt']));
        $billMasterArray["billamount"]=$searcharray['txtGrandTotal'];
        $billMasterArray["customeraccountid"]=  $this->getCustomerAccId($searcharray['customer'], $session['company']);
        $this->db->where($updatearr);
        $this->db->update("customerbillmaster",$billMasterArray);
        //echo $this->db->last_query();
    } 
    
    
    
    
    
    
    public function updateRawTeaSaleMaster($searcharray){
        $session = sessiondata_method();
        
        $rawTeasalemaster=array();
        
         $rawTeasalemasterId = $searcharray['txtrawTeaSaleMastId'];
        
        $rawTeasalemaster['invoice_no'] = $searcharray['invoice_no'];
        $rawTeasalemaster['sale_date'] = date("Y-m-d", strtotime($searcharray['saleDt']));
        $rawTeasalemaster['customer_id'] = $searcharray['customer'];
        $rawTeasalemaster['voucher_master_id'] = $searcharray['txthdVoucherMastId'];
        $rawTeasalemaster['vehichleno'] = $searcharray['vehichleno'];
        $rawTeasalemaster['taxrateType'] = $searcharray['rateType'];
        if ($searcharray['rateType'] == 'V') {
            $rawTeasalemaster['taxrateTypeId'] = $searcharray['vat'];
        } else {
            $rawTeasalemaster['taxrateTypeId'] = $searcharray['cst'];
        }

        $rawTeasalemaster['taxamount'] = $searcharray['txtTaxAmount'];
        $rawTeasalemaster['discountRate'] = $searcharray['txtDiscountPercentage'];
        $rawTeasalemaster['discountAmount'] = $searcharray['txtDiscountAmount'];
        $rawTeasalemaster['deliverychgs'] = $searcharray['txtDeliveryChg'];
        $rawTeasalemaster['total_sale_bag'] = $searcharray['txtTotalSaleBag'];
        $rawTeasalemaster['total_sale_qty'] = $searcharray['txtSaleOutKgs'];
        $rawTeasalemaster['totalamount'] = $searcharray['txtTotalSalePrice'];
        $rawTeasalemaster['roundoff'] = $searcharray['txtRoundOff'];
        $rawTeasalemaster['grandtotal'] = $searcharray['txtGrandTotal'];

        $rawTeasalemaster['company_id'] = $session['company'];
        $rawTeasalemaster['year_id'] = $session['yearid'];
        
        $this->db->where('id',$rawTeasalemasterId);
        $this->db->update('rawteasale_master',$rawTeasalemaster);
    }
    
     
     
     
     
     
     
      /**
     * 
     * @param type $master
     * @param type $sercharr
     */
    public function insertData($voucherMaster, $searcharray) {

        try {
            $rawTeaSaleInvoice = "";
            $session = sessiondata_method();
            $this->db->trans_begin();
            $voucherMaster['voucher_number']= $this->getSerialNumber($session['company'], $session['yearid']);
            $this->db->insert('voucher_master', $voucherMaster);
            $vMastId = $this->db->insert_id();
            $rawTeaSaleInvoice = $voucherMaster['voucher_number'];
            $this->insertintoVouchrDtl($vMastId,$searcharray);
            $this->insertintoRawTeaSaleMaster($vMastId,$searcharray,$rawTeaSaleInvoice);
            
           /* echo $this->db->last_query();
            exit;*/
            $rawteassaleMastId = $this->db->insert_id();
            $this->insertrawTeaSaleDtl($rawteassaleMastId, $searcharray);
            $this->insertBillMaster($rawteassaleMastId, $searcharray);
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
    
    private function getSerialNumber($company,$year){
        $lastnumber = (int)(0);
        $tag = "";
        $noofpaddingdigit = (int)(0);
        $autoSaleNo="";
        $yeartag ="";
        $sql="SELECT
                id,
                SERIAL,
                moduleTag,
                lastnumber,
                noofpaddingdigit,
                module,
                companyid,
                yearid,
                yeartag
            FROM serialmaster
            WHERE companyid=".$company." AND yearid=".$year." AND module='SALE'";
        
                  $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
			  $row = $query->row(); 
			  $lastnumber = $row->lastnumber;
                          $tag = $row->moduleTag;
                          $noofpaddingdigit = $row->noofpaddingdigit;
                          $yeartag = $row->yeartag;
                          
                          
		  }
          $digit = (int)(log($lastnumber,10)+1) ;  
          if($digit==5){
              $autoSaleNo = $tag."/".$lastnumber."/".$yeartag;
          }elseif ($digit==4) {
              $autoSaleNo = $tag."/0".$lastnumber."/".$yeartag;
            
        }elseif($digit==3){
            $autoSaleNo = $tag."/00".$lastnumber."/".$yeartag;
        }elseif($digit==2){
            $autoSaleNo = $tag."/000".$lastnumber."/".$yeartag;
        }elseif($digit==1){
            $autoSaleNo = $tag."/0000".$lastnumber."/".$yeartag;
        }
        $lastnumber = $lastnumber + 1;
        
        //update
        $data = array(
        'SERIAL' => $lastnumber,
        'lastnumber' => $lastnumber
        );
        $array = array('companyid' => $company, 'yearid' => $year, 'module' => "SALE");
        $this->db->where($array); 
        $this->db->update('serialmaster', $data);
        
        return $autoSaleNo;
        
    }
    
    
    
public function insertBillMaster($newSaleId, $searcharray){
        
        $session = sessiondata_method();
        $billMasterArray["billdate"]=date("Y-m-d", strtotime($searcharray['saleDt']));
        $billMasterArray["billamount"]=$searcharray['txtGrandTotal'];
        $billMasterArray["invoicemasterid"]=$newSaleId;
        $billMasterArray["saletype"]="R";
        $billMasterArray["customeraccountid"]=  $this->getCustomerAccId($searcharray['customer'], $session['company']);
        $billMasterArray["companyid"]=$session['company'];
        $billMasterArray["yearid"]=$session['yearid'];
        $this->db->insert('customerbillmaster', $billMasterArray);
        
    }




/*@method insertintoVouchrDtl
     * @date 01-06-2016
     * @By Mithilesh
     */
        public function insertintoVouchrDtl($vMastId,$searcharray){
            
            $this->deleteVoucherDetailData($vMastId);
            
       $session = sessiondata_method();
       $vouchrDtlCus = array();
       $vouchrDtlSale =array();
       $vouchrDtlVat = array();
          
       $cusAccId = $this->getCustomerAccId($searcharray['customer'],$session['company']);
       $saleAccId = $this->getSaleAccId($session['company']);
       $vatAccId = $this->getVatAccId($session['company']);
       
       $totalAmt =$searcharray['txtGrandTotal']; // For Cuss acc Debt
       $sAmount = ($searcharray['txtTotalSalePrice']+ $searcharray['txtDeliveryChg']+$searcharray['txtRoundOff']);
       $saleAmt = $sAmount - $searcharray['txtDiscountAmount']; // for sale
       $vatAmt = $searcharray['txtTaxAmount']; // for vat
       
       
       
       //For Customer Acc
       $vouchrDtlCus['voucher_master_id'] = $vMastId;
       $vouchrDtlCus['account_master_id'] = $cusAccId;
       $vouchrDtlCus['voucher_amount'] = $totalAmt;
       $vouchrDtlCus['is_debit'] ='Y' ;
       $vouchrDtlCus['account_id_for_trial'] = NULL;
       $vouchrDtlCus['subledger_id'] = NULL;
       $vouchrDtlCus['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlCus);
       
        //For Sale Acc
       $vouchrDtlSale['voucher_master_id'] = $vMastId;
       $vouchrDtlSale['account_master_id'] = $saleAccId;
       $vouchrDtlSale['voucher_amount'] = $saleAmt;
       $vouchrDtlSale['is_debit'] ='N' ;
       $vouchrDtlSale['account_id_for_trial'] = NULL;
       $vouchrDtlSale['subledger_id'] = NULL;
       $vouchrDtlSale['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlSale);
       
         //For VAT Acc
       
       if($vatAmt>0){
       $vouchrDtlVat['voucher_master_id'] = $vMastId;
       $vouchrDtlVat['account_master_id'] = $vatAccId;
       $vouchrDtlVat['voucher_amount'] = $vatAmt;
       $vouchrDtlVat['is_debit'] ='N' ;
       $vouchrDtlVat['account_id_for_trial'] = NULL;
       $vouchrDtlVat['subledger_id'] = NULL;
       $vouchrDtlVat['is_master'] = NULL;
       $this->db->insert('voucher_detail', $vouchrDtlVat);
       }else{
           
       }
       
       
        }
        
          public function deleteVoucherDetailData($voucherId){
        
         $this->db->where('voucher_master_id', $voucherId);
         $this->db->delete('voucher_detail');
    }
    
    
    public function insertintoRawTeaSaleMaster($vMastId,$searcharray,$rawTeaSaleInvoice){
        $session=  sessiondata_method();
        $rawteasale = array();
        
        $rawteasale['invoice_no'] = $rawTeaSaleInvoice;//$searcharray['invoice_no'];
        $rawteasale['sale_date'] = date("Y-m-d", strtotime($searcharray['saleDt']));
        $rawteasale['customer_id'] = $searcharray['customer'];
        $rawteasale['voucher_master_id'] = $vMastId;
        $rawteasale['vehichleno'] = $searcharray['vehichleno'];
        $rawteasale['taxrateType'] = $searcharray['rateType'];
        
        if ($searcharray['rateType'] == 'V') {
                   $rawteasale['taxrateTypeId'] = $searcharray['vat'];
               } else {
                   $rawteasale['taxrateTypeId'] = $searcharray['cst'];
               }
               
        $rawteasale['taxamount'] = $searcharray['txtTaxAmount'];
        $rawteasale['discountRate'] = $searcharray['txtDiscountPercentage'];
        $rawteasale['discountAmount'] = $searcharray['txtDiscountAmount'];
        $rawteasale['deliverychgs'] = $searcharray['txtDeliveryChg'];
        $rawteasale['total_sale_bag'] = $searcharray['txtTotalSaleBag'];
        $rawteasale['total_sale_qty'] = $searcharray['txtSaleOutKgs'];
        $rawteasale['totalamount'] = $searcharray['txtTotalSalePrice'];
        $rawteasale['roundoff'] = $searcharray['txtRoundOff'];
        $rawteasale['grandtotal'] = $searcharray['txtGrandTotal'];
       
        $rawteasale['company_id'] = $session['company'];
        $rawteasale['year_id'] = $session['yearid'];
        
        $this->db->insert('rawteasale_master', $rawteasale);
        
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
            $rawteaSaleDtl['num_of_sale_bag'] = ($dtlArr['txtused'][$i] == "" ? 0 : $dtlArr['txtused'][$i]);
            $rawteaSaleDtl['qty_of_sale_bag'] = $dtlArr['txtnetinBag'][$i];
            $rawteaSaleDtl['rate'] = ($dtlArr['txtrate'][$i] == "" ? 0 : $dtlArr['txtrate'][$i]);

            // if ($dtlArr['txtused'][$i] != 0) {
            $this->db->insert('rawteasale_detail', $rawteaSaleDtl);
            //}
        }
    }
    
    
        /* Mithilesh on 31-05-2016 */
function getCustomerAccId($cus_id,$compny){
      $sql = " SELECT  `account_master`.`id` FROM `account_master` INNER JOIN customer ON 
	  `account_master`.`id` = customer.account_master_id "
              . " WHERE customer.id=".$cus_id." AND account_master.`company_id`=".$compny;
       return $this->db->query($sql)->row()->id;
  }
   function getSaleAccId($compny){
      $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='Sale A/C' AND account_master.`company_id`=".$compny;
       return $this->db->query($sql)->row()->id;
      
  }
   function getVatAccId($compny){
      $sql="SELECT account_master.`id` FROM account_master WHERE account_master.`account_name`='VAT(Output)' AND account_master.`company_id`=".$compny;
    return $this->db->query($sql)->row()->id;
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
    
    
    
    
    
       /**
    * @name getCurrentcstrate
    * @param type $startYear
    * @param type $endYear
    * @return type
    */ 
 /*  public  function getCurrentcstrate($startYear, $endYear) {
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
   }*/
  
  public  function getCurrentcstrate() {
        $sql = "SELECT id, cst_rate FROM cst WHERE cst.is_active='Y' ORDER BY cst_rate";
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
   /* public function getCurrentvatrate($startYear, $endYear) {
        $sql = "SELECT id, vat_rate FROM vat WHERE from_date BETWEEN '" . $startYear . "' AND '" . $endYear . "'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        }
        
    }*/
   
    public function getCurrentvatrate() {
        $sql ="SELECT id, vat_rate FROM vat WHERE vat.is_active='Y' ORDER BY vat_rate";
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
                rawteasale_master.`voucher_master_id`,
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
                    "voucher_master_id" => $rows->voucher_master_id,
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
                    
                $saleBag = ($this->getPurchasedBag($rows->purchase_bag_id) - ($this->getsaleOutBag($rows->purchase_bag_id)+$this->getstockOutBag($rows->purchase_bag_id)+$this->getBlendedBag($rows->purchase_bag_id)));
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
                  //  "saleCost" =>($rows->num_of_sale_bag * $rows->rate ),
                    "saleCost" =>($rows->num_of_sale_bag * $rows->qty_of_sale_bag * $rows->rate ),
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
                `company`.`location`,
                vat.`vat_rate` 
              FROM
                `rawteasale_master` 
                INNER JOIN `customer` 
                  ON `rawteasale_master`.`customer_id` = `customer`.`id` 
                INNER JOIN `company` 
                  ON rawteasale_master.company_id = `company`.`id` 
                LEFT JOIN vat
                ON vat.`id`=rawteasale_master.`taxrateTypeId`
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
                    "telephone"=>$rows->telephone,
					"vat_rate"=>$rows->vat_rate
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
                    "amount"=>($rows->num_of_sale_bag * $rows->net * $rows->rate),
                    "totalDtlkgs"=>($rows->net*$rows->num_of_sale_bag)
                    
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }
    
    /*@method getExixtingInvoiceNo
     * @date 17-06-2016
     * @by Mithilesh
     */
    public function getExixtingInvoiceNo($invoiceNo,$cmpny,$year){
        
       $data=array(
             "invoice_no"=>$invoiceNo,
             "company_id"=> $cmpny,
             "year_id"=> $year
         );
         
         $sql = $this->db->select('id')->from('rawteasale_master')->where($data)->get();
          if ($sql->num_rows() > 0) {
           
            return TRUE;
        }
        else{
            return FALSE;
        }

        
    }


    
    
    
}
?>